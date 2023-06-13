<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceReportRequest;
use App\Models\StudentAttendance;
use App\Models\AttendanceStatus;
use App\Models\StudentSession;
use App\Models\Classes;
use Carbon\CarbonPeriod;

class AttendanceReportController extends Controller
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
    		'page_title' => 'Attendance Report',
            'menu' => 'Attendance'
    	];

    	return view('attendance-report.index', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\AttendanceReportRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getStudentsAttendanceReport(AttendanceReportRequest $request)
    {
        $attendance_statuses = AttendanceStatus::get();

        // Get Students According to request parameters
        $where = $request->safe()->except('month');
        $where['session_id'] = $this->current_session_id;

        // Start and End date of month
        $start_date = date('Y-m-01', strtotime($request->month));
        $end_date = date('Y-m-t', strtotime($request->month));

        // Get month dates
        $dates = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Get students from Student Session
        $student_session = StudentSession::where($where)
            ->with([
                'student',
                'attendances' => function($query) use($start_date, $end_date) {
                    $query->whereBetween('attendance_date', [ $start_date, $end_date ]);
                }
            ])
            ->get();

        $data = [
            'attendance_statuses' => $attendance_statuses,
            'student_session' => $student_session,
            'attendance_date' => $request->attendance_date,
            'dates' => $dates
        ];

        // Render View of attendance table
        $view = view('attendance-report.get-students-attendance-report-table', compact('data'))->render();

        return response()->success([
            'view' => $view
        ]); 
    }
}
