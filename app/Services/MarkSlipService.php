<?php 

namespace App\Services;

use App\Models\StudentSession;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Group;
use App\Models\ExamClass;
use App\Models\Grade;
use App\Models\MarkSlip;
use App\Models\ExamGradeRemarks;
use App\Models\ExamRemarks;
 
class MarkSlipService
{
	/**
     * Get markslips.
     *
     * @return \Illuminate\Http\Response
     */
	public function getMarkSlips($request)
	{
        // Store marslips
        $markslips = [];

		$exam = Exam::with('session')->find($request->exam_id);
        $class = Classes::with('grades')->find($request->class_id);
        $group = Group::find($request->group_id);
        $sections = Section::whereIn('id', $request->section_id)->get();
        $subjects = Subject::whereIn('id', $request->subject_id)->get();

        // Apply Default Gradings where grade not exists in class
        if (!count($class->grades)) {
            $class->grades = Grade::withoutGlobalScopes()->where('is_default', 1)->get();
        }

        // Get Student according to group by section key
		$students = $this->getStudents($request);

        // Get exam schedules of class
        $exam_schedules = $this->getExamSchedules($request);

        // Check if exam schedule exists

        if (count($exam_schedules)) {
            // Loop in subject
            foreach ($subjects as $subject) {
                // Loop in sections
                foreach ($sections as $section) {
                    // Check if the student exists in section by thier key in group by
                    if (!isset($students[$section->id])) {
                        continue;
                    }

                    // Get new stdClass
                    $markslip = new \stdClass;
                    
                    // Filter from collection
                    $section = $sections->firstWhere('id', $section->id);
                    $subject = $subjects->firstWhere('id', $subject->id);

                    // Store Names
                    $markslip->session = $exam->session->name;
                    $markslip->exam = $exam->name;
                    $markslip->class = $class->name;
                    $markslip->section = $section->name;
                    $markslip->subject = $subject->name;
                    $markslip->group = $group->name ?? '---';

                    // Class Gradeings
                    $markslip->grades = $class->grades;

                    // Get student by section key from collecion
                    $markslip->students = $students[$section->id];

                    // Exam Schedule by subject filter from exam schedules
                    $markslip->exam_schedule = $exam_schedules->firstWhere('subject_id', $subject->id);

                    // Push in to collection
                    $markslips[] = $markslip;
                }
            }
        }

        return $markslips;
	}

	/**
     * Get students by session, class, section.
     *
     * @return \Illuminate\Http\Response
     */ 
	public function getStudents($request)
	{
		$where = [
			'class_id' => $request->class_id,
            'session_id' => $request->session_id
		];

		// Get students by group by section
		$students = StudentSession::where($where)
            ->whereIn('section_id', $request->section_id)
            ->with([
                'student' => function($query) {
                    $query->select('id', 'roll_no', 'first_name', 'last_name');
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
            ->groupBy('section_id');

        return $students;
	}

    /**
     * Get exam schedules of class subjects.
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
                'examSchedule' => function($query) use($request) {
                    $query->select(
                            'id',
                            'exam_class_id',
                            'subject_id',
                            'group_id', 
                            'date',
                            'type',
                            'marks'
                        )
                        ->whereIn('subject_id', $request->subject_id)
                        ->with([
                            'categories' => [ 'remarks', 'gradeRemarks' ],
                            'remarks', 
                            'gradeRemarks'
                        ]);
                }
            ])
            ->first()
            ->examSchedule;

        return $exam_schedules;
    }

    /**
     * Get exam schedules of class subjects.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMarkSlip($request)
    {
        // Get markslips from exam class id
        $markslips = MarkSlip::where('exam_class_id', $request->exam_class_id)->get();

        // Store Remarks
        $exam_remarks = [];
        $exam_grade_remarks = [];

        foreach ($request->student_remarks as $key => $student_remarks) {
            $key = explode('-', $key);
            $section_id = $key[0];
            $subject_id = $key[1];

            // Check if markslip exists
            $markslip = $markslips->where('section_id', $section_id)->where('subject_id', $subject_id)->first();

            // Create markslip where not exits
            if (!$markslip && !empty($student_remarks)) {
                $markslip = MarkSlip::create([
                    'exam_class_id' => $request->exam_class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id
                ]);
            }

            foreach ($student_remarks as $student_session_id => $remarks) {

                // If the grades key are exists
                if (isset($remarks['grades'])) {
                    foreach ($remarks['grades'] as $exam_schedule_id => $grade_id) {
                        $exam_grade_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamSchedule',
                            'remarkable_id' => $exam_schedule_id,
                            'student_session_id' => $student_session_id,
                            'grade_id' => $grade_id,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the grading categories key are exists
                if (isset($remarks['grading_categories'])) {
                    foreach ($remarks['grading_categories'] as $exam_schedule_category_id => $grade_id) {
                        $exam_grade_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamScheduleCategory',
                            'remarkable_id' => $exam_schedule_category_id,
                            'student_session_id' => $student_session_id,
                            'grade_id' => $grade_id,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the categories key are exists
                if (isset($remarks['categories'])) {
                    foreach ($remarks['categories'] as $exam_schedule_category_id => $marks) {
                        $exam_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamScheduleCategory',
                            'remarkable_id' => $exam_schedule_category_id,
                            'student_session_id' => $student_session_id,
                            'remarks' => $marks,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the marks key are exists
                if (isset($remarks['marks'])) {
                    foreach ($remarks['marks'] as $exam_schedule_id => $marks) {
                        $exam_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamSchedule',
                            'remarkable_id' => $exam_schedule_id,
                            'student_session_id' => $student_session_id,
                            'remarks' => $marks,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }
            }
        }

        // Upsert Remarks
        ExamGradeRemarks::upsert($exam_grade_remarks, ['remarkable_type', 'remarkable_id', 'student_session_id'], ['grade_id', 'updated_by']);
        ExamRemarks::upsert($exam_remarks, ['remarkable_type', 'remarkable_id', 'student_session_id'], ['remarks', 'updated_by']);
    }

    /**
     * Get markslip tabulation sheet
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabulationSheetView($request)
    {
        $students = $this->getStudentsForTabulation($request);
        $examSchedules = $this->getExamSchedulesForTabulation($request) ?? [];

        // Check the all exam schedules is gradings
        $gradeExamSchedules = collect($examSchedules)->where('type', 'grade');
        $hasAllGradings = count($examSchedules) == count($gradeExamSchedules) ? true : false;

        // Check if all categories is grading and marks type is not exists
        $hasAllCategoryGradings = false;
        $marksExamSchedules = collect($examSchedules)->where('type', 'marks');
        $marksCategory = collect($examSchedules)
            ->where('type', 'categories')
            ->filter(function($examSchedule){
                return count($examSchedule->categories->where('is_grade', 0));
            });

        if (!count($marksExamSchedules) && !count($marksCategory)) {
            $hasAllCategoryGradings = true;
        }

        $exam = Exam::with('session')->find($request->exam_id);
        $class = Classes::with('grades')->find($request->class_id);
        $section = Section::find($request->section_id);
        $group = ($request->group_id) ? Group::find($request->group_id, [ 'name' ]) : null;
        $gradings = $class->grades;

        // If gradings are empty run default gradings
        if (!count($class->grades)) {
            $gradings = Grade::withoutGlobalScopes()->where('is_default', 1)->get();
        }

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

        $view = view('markslip.get-tabulation-sheet', compact('data'))->render();
        return $view;
    }

    /**
     * Get students for tabulation
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudentsForTabulation($request)
    {
        $where = [
            'class_id' => $request->class_id,
            'session_id' => $request->session_id,
            'section_id' => $request->section_id
        ];

        $students = StudentSession::where($where)
            ->with([
                'student' => function($query) {
                    $query->select('id', 'roll_no', 'first_name', 'last_name');
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
            ->pluck('student');

        return $students;
    }

    /**
     * Get exam schedules for tabulation sheet
     *
     * @return \Illuminate\Http\Response
     */
    public function getExamSchedulesForTabulation($request)
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
            ->map(function($examSchedule){
                $examSchedule->has_colspan = $examSchedule->type == 'grade' ? false : true;
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

                return $examSchedule;
            });

        return $exam_schedules;
    }
}