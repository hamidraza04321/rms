<?php 

namespace App\Services;
use App\Models\StudentSession;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Group;
 
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
        $class = Classes::find($request->class_id);
        $group = Group::find($request->group_id);
        $sections = Section::whereIn('id', $request->section_id)->get();
        $subjects = Subject::whereIn('id', $request->subject_id)->get();

        // Get Student according to group by section key
		$students = $this->getStudents($request);

        // Get exam schedules of class
        // $exam_schedules = $this->getExamSchedules($request);

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
                $markslip->group = $group->name;

                // Get student by section key from collecion
                $markslip->students = $students[$section->id];

                // Push in to collection
                $markslips[] = $markslip;
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
}