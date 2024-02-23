<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardRequest;
use App\Models\Scopes\ActiveScope;
use App\Models\StudentSession;
use App\Services\DashboardService;
use App\Models\Session;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$session = Session::find($this->current_session_id);
    	
        // Get counts
        $total_users = User::count();
    	$active_students = StudentSession::where('session_id', $this->current_session_id)->count();
    	$total_students = StudentSession::where('session_id', $this->current_session_id)
    		->withoutGlobalScope(ActiveScope::class)
    		->count();

        // Get Graph data
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-t');
        $student_attendances = (new DashboardService)->getAttendanceGraphData($from_date, $to_date);
        $total_students_graph_data = (new DashboardService)->getTotalStudentsGraphData();

    	$data = [
    		'total_users' => $total_users,
    		'total_students' => $total_students,
    		'active_students' => $active_students,
            'student_attendances' => $student_attendances,
            'total_students_graph_data' => $total_students_graph_data,
    		'session' => $session,
            'page_title' => 'Dashboard',
            'menu' => 'Home'
        ];

    	return view('dashboard', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\DashboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getAttendanceGraphData(DashboardRequest $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $student_attendances = (new DashboardService)->getAttendanceGraphData($from_date, $to_date);

        return response()->success([
            'student_attendances' => $student_attendances
        ]);
    }

    /**
     * Authenticate user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'page_title' => 'Profile',
            'menu' => 'Home'
        ];

        return view('profile', compact('data'));
    }

    /**
     * Update authenticate user profile
     *
     * @param \App\Http\Requests\DashboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(DashboardRequest $request)
    {
        dd($request->all());
    }
}
