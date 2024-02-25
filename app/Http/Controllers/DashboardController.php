<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardRequest;
use App\Models\Scopes\ActiveScope;
use App\Models\StudentSession;
use App\Services\DashboardService;
use App\Models\Session;
use App\Models\User;
use App\Models\UserDetail;
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
        $user = Auth::user();

        if ($user) {
            // Default Image
            $file_name = $user->userDetail->image;

            if ($request->image) {
                // Unlink Image
                $image_path = public_path('uploads/users/' . $file_name);

                if (is_file($image_path))
                    unlink($image_path);

                $file_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/users'), $file_name);
            }

            // Update user data
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email
            ];

            $user->update($data);

            // Set Socail media links
            $social_media_links = json_encode([
                'facebook' => $request->facebook_link,
                'instagram' => $request->instagram_link,
                'twitter' => $request->twitter_link,
                'youtube' => $request->youtube_link,
            ]);

            // Update or create user detail
            $user_detail = [
                'phone_no' => $request->phone_no,
                'image' => $file_name,
                'designation' => $request->designation,
                'age' => $request->age,
                'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
                'education' => $request->education,
                'location' => $request->location,
                'address' => $request->address,
                'skills' => $request->skills,
                'social_media_links' => $social_media_links
            ];

            UserDetail::updateOrCreate([ 'user_id' => $user->id ], $user_detail);

            return response()->success([
                'user' => array_merge($data, $user_detail),
                'message' => 'User Updated Successfully!'
            ]);
        }

        return response()->errorMessage('User not Found !');
    }

    /**
     * Change authenticate user password
     *
     * @param \App\Http\Requests\DashboardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(DashboardRequest $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->update([
                'password' => bcrypt($request->retype_password)
            ]);

            return response()->successMessage('Password Changed Successfully !');
        }

        return response()->errorMessage('User not Found !');
    }
}
