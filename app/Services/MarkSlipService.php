<?php 

namespace App\Services;
use App\Models\StudentSession;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
 
class MarkSlipService
{
	/**
     * Get markslips.
     *
     * @return \Illuminate\Http\Response
     */
	public function getMarkSlips($request)
	{
		$exam = Exam::with('session')->find($request->exam_id);
        $class = Classes::find($request->class_id);
        $subjects = Subject::whereIn('id', $request->subject_id)->get();
		$students = $this->getStudents($request);
		$exam_schedules = $this->getExamSchedules($request);
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
            ->with('student')
            ->get()
            ->map(function($student_session){
            	$student_session->student->section_id = $student_session->section_id;
            	return $student_session;
            })
            ->pluck('student')
            ->groupBy('section_id');

        return $students;
	}
}