<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Grade;
use App\Models\StudentSession;
use App\Models\ExamClass;
use App\Models\Group;

class TabulationService 
{
	/**
     * Get markslip tabulation sheet
     *
     * @param $request  array
     */
    public function getTabulationSheetView($request)
    {
        $exam = Exam::with('session')->find($request->exam_id);
        $class = Classes::with('grades')->find($request->class_id);
        $section = Section::find($request->section_id);
        $group = ($request->group_id) ? Group::find($request->group_id, [ 'name' ]) : null;
        $gradings = $class->grades;

        // If gradings are empty run default gradings
        if (!count($class->grades)) {
            $gradings = Grade::withoutGlobalScopes()->where('is_default', 1)->get();
        }

        $exam_class = $this->getExamClass($request);
        $exam_schedules = $exam_class->examSchedule ?? [];
        $exam_dates = $this->getExamDates($exam_schedules);
        $has_all_gradings = count($exam_schedules) == count(collect($exam_schedules)->where('type', 'grade')) ? true : false; // Check the all exam schedules is gradings
        $has_all_category_gradings = $this->checkAllExamScheduleCategoryIsGradings($exam_schedules); // Check if all categories is grading and marks type is not exists
        $students = $this->getStudents($request, $exam_schedules, $exam_dates, $gradings, $has_all_gradings, $has_all_category_gradings);

        $data = [
            'students' => $students,
            'exam_schedules' => $exam_schedules,
            'has_all_gradings' => $has_all_gradings,
            'has_all_category_gradings' => $has_all_category_gradings,
            'exam' => $exam,
            'class' => $class,
            'exam_class' => $exam_class,
            'section' => $section,
            'group' => $group,
            'gradings' => $gradings
        ];

        return view('markslip.get-tabulation-sheet', compact('data'))->render();
    }

    /**
     * Get exam class
     * 
     * @param $request  array
     */
    public function getExamClass($request)
    {
        $exam_class = ExamClass::where(
            [
                'exam_id' => $request->exam_id,
                'class_id' => $request->class_id
            ])
            ->when($request->group_id, fn($query) => $query->where('group_id', $request->group_id))
            ->with([
                'examSchedule' => function($query) {
                    $query->select(
                            'id',
                            'exam_class_id',
                            'subject_id',
                            'group_id', 
                            'date',
                            'type',
                            'marks'
                        )
                        ->with([
                            'categories' => [ 'remarks', 'gradeRemarks' ],
                            'remarks', 
                            'gradeRemarks',
                            'subject'
                        ]);
                }
            ])
            ->first();

        // Exam Schedules
        $exam_class?->examSchedule
            ->map(function($exam_schedule) {
                $this->setTableConsumeColspan($exam_schedule);

                // Exam Schedule total marks
                $exam_schedule->total_marks = match($exam_schedule->type) {
                    'grade' => 0,
                    'marks' => $exam_schedule->marks,
                    'categories' => $exam_schedule->categories->sum('marks')
                };

                return $exam_schedule;
            });

        return $exam_class;
    }

    /**
     * Get students for tabulation
     *
     * @param $request                      array
     * @param $exam_schedules               array
     * @param $exam_dates                   array
     * @param $gradings                     array
     * @param $has_all_gradings             bool
     * @param $has_all_category_gradings    bool
     */
    public function getStudents($request, $exam_schedules, $exam_dates, $gradings, $has_all_gradings, $has_all_category_gradings)
    {
        $students = StudentSession::where(
            [
                'class_id' => $request->class_id,
                'session_id' => $request->session_id,
                'section_id' => $request->section_id
            ])
            ->when($request->group_id, fn($query) => $query->where('group_id', $request->group_id))
            ->with([
                'student' => function($query) {
                    $query->select('id', 'roll_no', 'first_name', 'last_name');
                },
                'attendances' => function($query) use($exam_dates) {
                    $query->select('id', 'student_session_id', 'attendance_status_id', 'attendance_date')
                        ->with('attendanceStatus')
                        ->whereIn('attendance_date', $exam_dates);
                }
            ])
            ->get([
                'id',
                'student_id',
                'section_id'
            ])
            ->map(function($student_session){
                $student_session->student->section_id = $student_session->section_id;
                $student_session->student->student_session_id = $student_session->id;
                $student_session->student->attendances = $student_session->attendances;
                return $student_session;
            })
            ->pluck('student')
            ->map(function($student) use($exam_schedules, $gradings, $has_all_gradings, $has_all_category_gradings) {
                $student->remarks = $this->getStudentRemarks(
                    $student,
                    $exam_schedules,
                    $gradings,
                    $has_all_gradings,
                    $has_all_category_gradings
                );

                return $student;
            });

        // Ranking
        if (!$has_all_gradings && !$has_all_category_gradings) {
        	$this->setRanking($students);
        }

        return $students;
    }

    /**
     * Get remarks array of student for tabulation
     *
     * @param $student                      Object
     * @param $exam_scheudles               array
     * @param $gradings                     array
     * @param $has_all_gradings             bool
     * @param $has_all_category_gradings    bool
     */    
    public function getStudentRemarks(&$student, $exam_schedules, $gradings, $has_all_gradings, $has_all_category_gradings)
    {
        $remarks = [];
        $grand_obtain = 0;
        $student_is_fail = false; // Check student is pass / fail
        $student_session_id = $student->student_session_id;
        $grand_total = collect($exam_schedules)->sum('total_marks');

        foreach ($exam_schedules as $exam_schedule) {
            $attendance = $student->attendances->firstWhere('attendance_date', $exam_schedule->date->format('Y-m-d'));

            match($exam_schedule->type) {
                'grade' => $this->setGradeRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id, $attendance),
                'marks' => $this->setRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id, $grand_obtain, $attendance),
                'categories' => $this->setCategoryRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id, $grand_obtain, $attendance)
            };
        }

        $grand_remarks = [];
        $grand_remarks['type'] = 'grand_total';
        $grand_remarks['student_session_id'] = $student_session_id;
        $grand_remarks['result'] = ($student_is_fail) ? 'Fail' : 'Pass';
        $student->student_is_fail = $student_is_fail;

        // If the all exam schdules is not grading categories
        if (!$has_all_gradings && !$has_all_category_gradings) {
            $percentage = $this->getPercentage($grand_total, $grand_obtain);
            $grade = $this->getGradingByPercentage($percentage, $gradings);

            $grand_remarks['grand_obtain'] = $grand_obtain;
            $grand_remarks['grade'] = $grade;
            $grand_remarks['percentage'] = $percentage;
            $student->grand_obtain = $grand_obtain;
        }

        $remarks[] = (Object)$grand_remarks;

        return $remarks;
    }

    /**
     * Set grade remarks of student
     *
     * @param $remarks              array
     * @param $exam_schedule        array
     * @param $student_is_fail      bool
     * @param $gradings             array
     * @param $student_session_id   int
     * @param $attendance           Object
     */ 
    public function setGradeRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id, $attendance)
    {
        // Check student is absent
        $is_absent = ($attendance?->attendanceStatus->is_absent) ? true : false;

        $data = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'type' => 'grade',
            'grade' => null,
            'is_absent' => $is_absent,
            'attendance_status' => $attendance?->attendanceStatus
        ];

        // If student is absent then student is fail and no any remarks
        if ($is_absent) {
            $remarks[] = $data;
            $student_is_fail = true;
            return;
        }

        $remark = $exam_schedule->gradeRemarks->firstWhere('student_session_id', $student_session_id);
        $grade = $gradings->firstWhere('id', $remark?->grade_id);
        $student_is_fail = ($student_is_fail || empty($grade) || $grade->is_fail) ? true : false;

        $data->grade = $grade;
        $remarks[] = $data;
    }

    /**
     * Set remarks of student
     *
     * @param $remarks              array
     * @param $exam_schedule        array
     * @param $student_is_fail      bool
     * @param $gradings             array
     * @param $student_session_id   int
     * @param $grand_obtain         int
     * @param $attendance           Object
     */
    public function setRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id, &$grand_obtain, $attendance)
    {
        // Check student is absent
        $is_absent = ($attendance?->attendanceStatus->is_absent) ? true : false;
        $total_marks = $exam_schedule->total_marks;

        $data = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'type' => 'marks',
            'obtain_marks' => 0,
            'total_marks' => $total_marks,
            'grade' => null,
            'is_absent' => $is_absent,
            'attendance_status' => $attendance?->attendanceStatus
        ];

        // If student is absent then student is fail and no any remarks
        if ($is_absent) {
            $data->grade = $this->getGradingByPercentage(0, $gradings);
            $remarks[] = $data;
            $student_is_fail = true;
            return;
        }

        $remark = $exam_schedule->remarks->firstWhere('student_session_id', $student_session_id);
        $obtain_marks = $remark?->remarks ?? 0;
        $grand_obtain += $obtain_marks;
        $percentage = $this->getPercentage($total_marks, $obtain_marks);
        $grade = $this->getGradingByPercentage($percentage, $gradings);
        $student_is_fail = ($student_is_fail || empty($grade) || $grade->is_fail) ? true : false;

        $data->obtain_marks = $obtain_marks;
        $data->grade = $grade;
        $remarks[] = $data;
    }

    /**
     * Set category remarks of student
     *
     * @param $remarks              array
     * @param $exam_schedule        array
     * @param $student_is_fail      bool
     * @param $gradings             array
     * @param $student_session_id   int
     * @param $grand_obtain         int
     * @param $attendance           Object
     */
    public function setCategoryRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id, &$grand_obtain, $attendance)
    {
        $total_marks = $exam_schedule->total_marks;
        $subject_obtain_marks = 0;

        foreach ($exam_schedule->categories as $category) {
            if ($category->is_grade) {
                $this->setCategoryGradeRemarks($remarks, $category, $exam_schedule, $gradings, $student_session_id, $attendance);
                continue;
            }

            $this->setCategoryMarks($remarks, $category, $exam_schedule, $subject_obtain_marks, $student_session_id, $attendance);
        }

        // Check if all category is not grading
        if (!$exam_schedule->has_all_category_gradings) {
            $percentage = $this->getPercentage($total_marks, $subject_obtain_marks);
            $grade = $this->getGradingByPercentage($percentage, $gradings);
            $student_is_fail = ($student_is_fail || empty($grade) || $grade->is_fail) ? true : false;

            $remarks[] = (Object)[
                'type' => 'category_total',
                'obtain_marks' => $subject_obtain_marks,
                'exam_schedule_id' => $exam_schedule->id,
                'grade' => $grade
            ];
        }

        $grand_obtain += $subject_obtain_marks;
    }

    /**
     * Set category grade remarks of student
     *
     * @param $remarks              array
     * @param $category             Object
     * @param $exam_schedule        Object
     * @param $gradings             array
     * @param $student_session_id   int
     * @param $attendance           Object
     */
    public function setCategoryGradeRemarks(&$remarks, $category, $exam_schedule, $gradings, $student_session_id, $attendance)
    {
        $is_absent = ($attendance?->attendanceStatus->is_absent) ? true : false;

        $data = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'category_id' => $category->id,
            'type' => 'category_grade',
            'grade' => null,
            'is_absent' => $is_absent,
            'attendance_status' => $attendance?->attendanceStatus
        ];

        if ($is_absent) {
            $remarks[] = $data;
            return;
        }

        $remark = $category->gradeRemarks->firstWhere('student_session_id', $student_session_id);
        $data->grade = $gradings->firstWhere('id', $remark?->grade_id);
        $remarks[] = $data;
    }

    /**
     * Set exam schedule category marks of student
     *
     * @param $remarks              array
     * @param $category             Object
     * @param $exam_schedule        Object
     * @param $subject_obtain_marks int
     * @param $student_session_id   int
     * @param $attendance           Object
     */
    public function setCategoryMarks(&$remarks, $category, $exam_schedule, &$subject_obtain_marks, $student_session_id, $attendance)
    {
        $is_absent = ($attendance?->attendanceStatus->is_absent) ? true : false;

        $data = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'category_id' => $category->id,
            'type' => 'category_marks',
            'total_marks' => $category->marks,
            'obtain_marks' => 0,
            'is_absent' => $is_absent,
            'attendance_status' => $attendance?->attendanceStatus
        ];

        if ($is_absent) {
            $remarks[] = $data;
            return;            
        }

        $remark = $category->remarks->firstWhere('student_session_id', $student_session_id);
        $obtain_marks = $remark?->remarks ?? 0;
        $subject_obtain_marks += $obtain_marks;

        $data->obtain_marks = $obtain_marks;
        $remarks[] = $data;
    }

    /**
     * Apply ranking based on obtain marks and student is not fail
     *
     * @param $students  array
     */
    public function setRanking(&$students)
    {
        $rank = 1;
        $previous_obtain = null;
    	$students
            ->where('student_is_fail', false) // Apply ranking on students whoose not fail
            ->sortByDesc('grand_obtain')
            ->map(function($student) use(&$rank, &$previous_obtain) {
                if ($student->grand_obtain !== $previous_obtain) {
                    $student->rank = $this->suffix($rank++);
                    $previous_obtain = $student->grand_obtain;
                } else {
                    $student->rank = $this->suffix($rank - 1);
                }

                return $student;
            });
    }

    /**
     * Get exam schedule dates
     *
     * @param $exam_schedules  array
     * @return array
     */    
    public function getExamDates($exam_schedules)
    {
        if (!count($exam_schedules))
            return [];

        $dates = [];
        foreach ($exam_schedules as $exam_schedule) {
            $dates[] = $exam_schedule->date->format('Y-m-d');
        }

        return $dates;
    }

    /**
     * Get colspan of exam schedule for view
     *
     * @param $exam_schedule  Object
     */
    public function setTableConsumeColspan(&$exam_schedule)
    {
        // When the exam schedule type is grade there are no colpsn needed
        $exam_schedule->has_colspan = $exam_schedule->type == 'grade' ? false : true;

        // Colspan
        $exam_schedule->colspan = match($exam_schedule->type) {
            'grade' => 0,
            'marks' => 2,
            'categories' => count($exam_schedule->categories)
        };

        // Check if all catgories is grading
        if (count($exam_schedule->categories)) {
            $gradingCategories = $exam_schedule->categories->where('is_grade', 1) ?? [];
            $exam_schedule->has_all_category_gradings = count($gradingCategories) == count($exam_schedule->categories) ? true : false;

            // Plus one for add total column in table
            if (!$exam_schedule->has_all_category_gradings) {
                $exam_schedule->colspan += 1;
            }
        }
    }

    /**
     * Check all exam schedules categorie are gradings
     *
     * @param $exam_schedules  array
     * @return bool
     */
    public function checkAllExamScheduleCategoryIsGradings($exam_schedules)
    {
        $exam_schedules = collect($exam_schedules);
        $marks_exam_schedules = $exam_schedules->where('type', 'marks');
        
        $marks_category = $exam_schedules
            ->where('type', 'categories')
            ->filter(function($exam_schedule) {
                return count($exam_schedule->categories->where('is_grade', 0));
            });

        if (!count($marks_exam_schedules) && !count($marks_category)) {
            return true;
        }

        return false;
    }

    /**
     * Get percentage by total and obtain marks
     *
     * @return int|float
     */
    public function getPercentage($total_marks, $obtain_marks)
    {
        if (!$obtain_marks || !$total_marks) {
            return 0;
        }

        return round(($obtain_marks * 100) / $total_marks, 2);
    }

    /**
     * Get percentage by total and obtain marks
     *
     * @return int|float
     */
    public function getGradingByPercentage($percentage, $gradings)
    {
        foreach ($gradings as $grade) {
            if ($percentage >= $grade->percentage_from &&
                $percentage <= $grade->percentage_to) {
                return $grade;
            }    
        }
    }

    /**
     * Number suffix
     * 
     * @param $number  int
     * @return string
     */
    public function suffix($number)
    {
        if (!is_numeric($number)) {
            return $number; // Return as is if it's not a number
        }

        $last_two_digits = $number % 100;

        if ($last_two_digits >= 11 && $last_two_digits <= 13) {
            $suffix = 'th';
        } else {
            $last_digit = $number % 10;

            switch ($last_digit) {
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
                    break;
            }
        }

        return $number . $suffix;
    }
}