<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkAttendanceRequest;
use App\Models\StudentAttendance;
use App\Models\AttendanceStatus;
use App\Models\StudentSession;
use App\Models\Classes;

class MarkAttendanceController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$classes = Classes::get();

    	$data = [
    		'classes' => $classes,
    		'page_title' => 'Mark Attendance',
            'menu' => 'Attendance'
    	];

    	return view('mark-attendance.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\MarkAttendanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getStudentsAttendanceTable(MarkAttendanceRequest $request)
    {
    	$attendance_statuses = AttendanceStatus::get();

    	// Get Students According to request parameters
        $where = $request->safe()->except('attendance_date');
        $where['session_id'] = $this->current_session_id;

        // Get students from Student Session
    	$student_session = StudentSession::where($where)
    		->with([
    			'student',
    			'attendances' => function($query) use($request) {
    				$query->where('attendance_date', $request->attendance_date);
    			}
    		])
    		->get()
            ->map(function($student_session){
                $student_session['attendance_status_id'] = $student_session->attendances[0]->attendance_status_id ?? null;
                return $student_session;
            });

    	$data = [
    		'attendance_statuses' => $attendance_statuses,
    		'student_session' => $student_session,
            'attendance_date' => $request->attendance_date
    	];

        // Render View of attendance table
    	$view = view('mark-attendance.get-students-attendance-table', compact('data'))->render();
    	
    	return response()->success([
    		'view' => $view
    	]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MarkAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveStudentAttendance(MarkAttendanceRequest $request)
    {
        $data = [];
        
        foreach ($request->attendances as $student_session_id => $attendance_status_id) {
            $data[] = [
                'student_session_id' => (int)$student_session_id,
                'attendance_status_id' => (int)$attendance_status_id,
                'attendance_date' => $request->attendance_date
            ];
        }

        StudentAttendance::upsert($data, ['student_session_id', 'attendance_date'], ['attendance_status_id']);
        return response()->successMessage('Attendance Marked Successfully !');
    }
}
