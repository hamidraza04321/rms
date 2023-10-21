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

        $exam_schedules = $this->getExamSchedules($request) ?? [];
        $exam_dates = (count($exam_schedules)) ? $exam_schedules->pluck('date')->toArray() : [];
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
            'section' => $section,
            'group' => $group,
            'gradings' => $gradings
        ];

        return view('markslip.get-tabulation-sheet', compact('data'))->render();
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
        $grand_total = $exam_schedules->sum('total_marks');

        foreach ($exam_schedules as $exam_schedule) {
            match($exam_schedule->type) {
                'grade' => $this->setGradeRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id),
                'marks' => $this->setRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id, $grand_obtain),
                'categories' => $this->setCategoryRemarks($remarks, $exam_schedule, $student_is_fail, $gradings, $student_session_id, $grand_obtain)
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
     */ 
    public function setGradeRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id)
    {
        $remark = $exam_schedule->gradeRemarks->firstWhere('student_session_id', $student_session_id);
        $grade = $gradings->firstWhere('id', $remark?->grade_id);
        $student_is_fail = ($student_is_fail || !isset($grade->is_fail) || $grade->is_fail) ? true : false;

        $remarks[] = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'type' => 'grade',
            'grade' => $grade
        ];
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
     */
    public function setRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id, &$grand_obtain)
    {
        $remark = $exam_schedule->remarks->firstWhere('student_session_id', $student_session_id);
        $total_marks = $exam_schedule->total_marks;
        $subject_obtain_marks = $remark?->remarks ?? 0;
        $grand_obtain += $subject_obtain_marks;
        $percentage = $this->getPercentage($total_marks, $subject_obtain_marks);
        $grade = $this->getGradingByPercentage($percentage, $gradings);
        $student_is_fail = ($student_is_fail || !isset($grade->is_fail) || $grade->is_fail) ? true : false;

        $remarks[] = (Object)[
            'exam_schedule_id' => $exam_schedule->id,
            'subject_id' => $exam_schedule->subject_id,
            'type' => 'marks',
            'obtain_marks' => $subject_obtain_marks ?? null,
            'total_marks' => $total_marks,
            'grade' => $grade
        ];
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
     */
    public function setCategoryRemarks(&$remarks, $exam_schedule, &$student_is_fail, $gradings, $student_session_id, &$grand_obtain)
    {
        $total_marks = $exam_schedule->total_marks;
        $subject_obtain_marks = 0;

        foreach ($exam_schedule->categories as $category) {
            
            // If category is grading
            if ($category->is_grade) {
                $remark = $category->gradeRemarks->firstWhere('student_session_id', $student_session_id);
                $grade = $gradings->firstWhere('id', $remark?->grade_id);

                $remarks[] = (Object)[
                    'exam_schedule_id' => $exam_schedule->id,
                    'subject_id' => $exam_schedule->subject_id,
                    'type' => 'category_grade',
                    'grade' => $grade
                ];

                continue;
            }

            $remark = $category->remarks->firstWhere('student_session_id', $student_session_id);
            $obtain_marks = $remark?->remarks ?? 0;
            $subject_obtain_marks += $obtain_marks;

            $remarks[] = (Object)[
                'exam_schedule_id' => $exam_schedule->id,
                'subject_id' => $exam_schedule->subject_id,
                'type' => 'category_marks',
                'total_marks' => $category->marks,
                'obtain_marks' => $obtain_marks
            ];
        }

        // Check if all category is not grading
        if (!$exam_schedule->has_all_category_gradings) {
            $percentage = $this->getPercentage($total_marks, $subject_obtain_marks);
            $grade = $this->getGradingByPercentage($percentage, $gradings);
            $student_is_fail = ($student_is_fail || !isset($grade->is_fail) || $grade->is_fail) ? true : false;

            $remarks[] = (Object)[
                'type' => 'category_total',
                'obtain_marks' => $subject_obtain_marks,
                'grade' => $grade
            ];
        }

        $grand_obtain += $subject_obtain_marks;
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
     * Get exam schedules for tabulation sheet
     *
     * @param $request  array
     */
    public function getExamSchedules($request)
    {
        $where = [
            'exam_id' => $request->exam_id,
            'class_id' => $request->class_id
        ];

        // Add Group when exists
        if ($request->group_id) $where['group_id'] = $request->group_id;

        // Get Exam schedules
        $exam_schedules = ExamClass::where($where)
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
            ->first()
            ?->examSchedule
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

        return $exam_schedules;
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

        return round(($obtain_marks * 100) / $total_marks);
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