<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scopes\ActiveScope;
use App\Models\StudentSession;
use App\Services\DashboardService;
use App\Models\Session;
use App\Models\User;

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
        $student_attendances = (new DashboardService)->getAttendaceGraphData($from_date, $to_date);

    	$data = [
    		'total_users' => $total_users,
    		'total_students' => $total_students,
    		'active_students' => $active_students,
            'student_attendances' => $student_attendances,
    		'session' => $session,
            'page_title' => 'Dashboard',
            'menu' => 'Index'
        ];

    	return view('dashboard', compact('data'));
    }
}
