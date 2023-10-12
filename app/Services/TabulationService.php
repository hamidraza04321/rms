<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Grade;
use App\Models\StudentSession;
use App\Models\ExamClass;

class TabulationService 
{
	/**
     * Get markslip tabulation sheet
     *
     * @return \Illuminate\Http\Response
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

        $examSchedules = $this->getExamSchedules($request) ?? [];
        $hasAllGradings = count($examSchedules) == count(collect($examSchedules)->where('type', 'grade')) ? true : false; // Check the all exam schedules is gradings
        $hasAllCategoryGradings = $this->checkAllExamScheduleCategoryIsGradings($examSchedules); // Check if all categories is grading and marks type is not exists
        $students = $this->getStudents($request, $examSchedules, $gradings, $hasAllGradings, $hasAllCategoryGradings);

        $data = [
            'students' => $students,
            'examSchedules' => $examSchedules,
            'hasAllGradings' => $hasAllGradings,
            'hasAllCategoryGradings' => $hasAllCategoryGradings,
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
     * @return \Illuminate\Http\Response
     */
    public function getStudents($request, $examSchedules, $gradings, $hasAllGradings, $hasAllCategoryGradings)
    {
        $students = StudentSession::where(
            [
                'class_id' => $request->class_id,
                'session_id' => $request->session_id,
                'section_id' => $request->section_id
            ])
            ->with('student', fn($query) =>  $query->select('id', 'roll_no', 'first_name', 'last_name'))
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
            ->map(function($student) use($examSchedules, $gradings, $hasAllGradings, $hasAllCategoryGradings) {
                $student->remarks = $this->getStudentRemarks(
                    $student, 
                    $examSchedules, 
                    $gradings, 
                    $hasAllGradings,
                    $hasAllCategoryGradings
                );

                return $student;
            });

        // Ranking
        if (!$hasAllGradings && !$hasAllCategoryGradings) {
        	$this->setRanking($students);
        }

        return $students;
    }

    /**
     * Get remarks array of student for tabulation
     *
     * @return \Illuminate\Http\Response
     */    
    public function getStudentRemarks($student, $examSchedules, $gradings, $hasAllGradings, $hasAllCategoryGradings)
    {
        $remarks = [];
        $student_session_id = $student->student_session_id;
        $student_is_fail = false; // Check student is pass / fail
        $grand_total = $examSchedules->sum('total_marks');
        $grand_obtain = 0;

        foreach ($examSchedules as $examSchedule) {

            // Grade
            if ($examSchedule->type == 'grade') {
                $remark = $examSchedule->gradeRemarks->firstWhere('student_session_id', $student_session_id);
                $grade = $gradings->firstWhere('id', $remark?->grade_id);

                $remarks[] = (Object)[
                    'exam_schedule_id' => $examSchedule->id,
                    'subject_id' => $examSchedule->subject_id,
                    'type' => 'grade',
                    'grade' => $grade
                ];
            }

            // Marks
            if ($examSchedule->type == 'marks') {
                $remark = $examSchedule->remarks->firstWhere('student_session_id', $student_session_id);
                $total_marks = $examSchedule->total_marks;
                $subject_obtain_marks = $remark?->remarks ?? 0;
                $grand_obtain += $subject_obtain_marks;
                $percentage = $this->getPercentage($total_marks, $subject_obtain_marks);
                $grade = $this->getGradingByPercentage($percentage, $gradings);

                $remarks[] = (Object)[
                    'exam_schedule_id' => $examSchedule->id,
                    'subject_id' => $examSchedule->subject_id,
                    'type' => 'marks',
                    'obtain_marks' => $subject_obtain_marks ?? null,
                    'total_marks' => $total_marks,
                    'grade' => $grade
                ];
            }

            // Categories
            if ($examSchedule->type == 'categories') {
                $total_marks = $examSchedule->total_marks;
                $subject_obtain_marks = 0;

                foreach ($examSchedule->categories as $category) {
                    
                    // If category is grading
                    if ($category->is_grade) {
                        $remark = $category->gradeRemarks->firstWhere('student_session_id', $student_session_id);
                        $grade = $gradings->firstWhere('id', $remark?->grade_id);

                        $remarks[] = (Object)[
                            'exam_schedule_id' => $examSchedule->id,
                            'subject_id' => $examSchedule->subject_id,
                            'type' => 'category_grade',
                            'grade' => $grade
                        ];

                        continue;
                    }

                    $remark = $category->remarks->firstWhere('student_session_id', $student_session_id);
                    $obtain_marks = $remark?->remarks ?? 0;
                    $subject_obtain_marks += $obtain_marks;

                    $remarks[] = (Object)[
                        'exam_schedule_id' => $examSchedule->id,
                        'subject_id' => $examSchedule->subject_id,
                        'type' => 'category_marks',
                        'total_marks' => $category->marks,
                        'obtain_marks' => $obtain_marks
                    ];
                }

                // Check if all category is not grading
                if (!$examSchedule->has_all_category_gradings) {
                    $percentage = $this->getPercentage($total_marks, $subject_obtain_marks);
                    $grade = $this->getGradingByPercentage($percentage, $gradings);

                    $remarks[] = (Object)[
                        'type' => 'category_total',
                        'obtain_marks' => $subject_obtain_marks,
                        'grade' => $grade
                    ];
                }

                $grand_obtain += $subject_obtain_marks;
            }

        }

        $grand_remarks = [];
        $grand_remarks['type'] = 'grand_total';
        $grand_remarks['result'] = ($student_is_fail) ? 'Fail' : 'Pass';

        // If the all exam schdules is not grading categories
        if (!$hasAllGradings && !$hasAllCategoryGradings) {
            $percentage = $this->getPercentage($grand_total, $grand_obtain);
            $grade = $this->getGradingByPercentage($percentage, $gradings);

            $grand_remarks['grand_obtain'] = $grand_obtain;
            $grand_remarks['grade'] = $grade;
            $grand_remarks['percentage'] = $percentage;
        }

        $remarks[] = (Object)$grand_remarks;

        return $remarks;
    }

    /**
     * Apply ranking based on obtain marks and student is not fail
     */
    public function setRanking(&$students)
    {
    	$grand_obtain = $students
    		->pluck('remarks')
    		->collapse()
    		->where('type', 'grand_total')
    		->pluck('grand_obtain')
    		->toArray();

		dd($rankings);
    }

    /**
     * Get exam schedules for tabulation sheet
     *
     * @return \Illuminate\Http\Response
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
            ->map(function($examSchedule) {
                $this->setTableConsumeColspan($examSchedule);

                // Exam Schedule total marks
                $examSchedule->total_marks = match($examSchedule->type) {
                    'grade' => 0,
                    'marks' => $examSchedule->marks,
                    'categories' => $examSchedule->categories->sum('marks')
                };

                return $examSchedule;
            });

        return $exam_schedules;
    }

    /**
     * Get colspan of exam schedule for view
     *
     * @return int
     */
    public function setTableConsumeColspan(&$examSchedule)
    {
        // When the exam schedule type is grade there are no colpsn needed
        $examSchedule->has_colspan = $examSchedule->type == 'grade' ? false : true;

        // Colspan
        $examSchedule->colspan = match($examSchedule->type) {
            'grade' => 0,
            'marks' => 2,
            'categories' => count($examSchedule->categories)
        };

        // Check if all catgories is grading
        if (count($examSchedule->categories)) {
            $gradingCategories = $examSchedule->categories->where('is_grade', 1) ?? [];
            $examSchedule->has_all_category_gradings = count($gradingCategories) == count($examSchedule->categories) ? true : false;

            // Plus one for add total column in table
            if (!$examSchedule->has_all_category_gradings) {
                $examSchedule->colspan += 1;
            }
        }
    }

    /**
     * Check all exam schedules categorie are gradings
     *
     * @return bool
     */
    public function checkAllExamScheduleCategoryIsGradings($examSchedules)
    {
        $examSchedules = collect($examSchedules);
        $marksExamSchedules = $examSchedules->where('type', 'marks');
        
        $marksCategory = $examSchedules
            ->where('type', 'categories')
            ->filter(function($examSchedule) {
                return count($examSchedule->categories->where('is_grade', 0));
            });

        if (!count($marksExamSchedules) && !count($marksCategory)) {
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
}