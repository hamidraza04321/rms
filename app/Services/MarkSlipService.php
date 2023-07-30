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
     * Get Students by session, class, section.
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
     * Get Exam Schedules of class subjects.
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
                        ->with('categories');
                }
            ])
            ->first()
            ->examSchedule;

        return $exam_schedules;
    }
}