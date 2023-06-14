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

        // Start and End date of month
        $start_date = date('Y-m-01', strtotime($request->month));
        $end_date = date('Y-m-t', strtotime($request->month));

        // Get array of month dates
        $dates = [];
        $period = CarbonPeriod::create($start_date, $end_date);
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Get Students According to request parameters
        $where = $request->safe()->except('month');
        $where['session_id'] = $this->current_session_id;

        // Making array of attendance percentage
        $attendance_percentages = [];
        foreach ($attendance_statuses as $attendance_status) {
            $attendance_percentages[$attendance_status->id] = 0;
        }

        // Get students from Student Session
        $student_session = StudentSession::where($where)
            ->with([
                'student',
                'attendances' => function($query) use($start_date, $end_date) {
                    $query->whereBetween('attendance_date', [ $start_date, $end_date ])
                        ->with('attendanceStatus');
                }
            ])
            ->get()
            ->map(function($student_session) use($dates, $attendance_percentages) {
                $attendances = [];
                foreach ($dates as $date) {
                    $data = (object)[
                        'date' => $date,
                        'short_code' => null,
                        'color' => null
                    ];

                    $attendance = $student_session->attendances->where('attendance_date', $date)->first();

                    if ($attendance) {
                        $data->short_code = $attendance->attendanceStatus->short_code;
                        $data->color = $attendance->attendanceStatus->color;
                        $attendance_percentages[$attendance->attendance_status_id] += 1;
                    }

                    $attendances[] = (object)$data;
                }

                $attendance_percentage = [];
                $total_days = count($dates);
                foreach ($attendance_percentages as $attendance_status_id => $attendance_count) {
                    $attendance_percentage[$attendance_status_id] = ($attendance_count) ? round($attendance_count * 100 / $total_days, 1) : '0.0';
                }
                
                $student_session['attendances'] = $attendances;
                $student_session['attendance_percentage'] = $attendance_percentage;
                return $student_session;
            });

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
