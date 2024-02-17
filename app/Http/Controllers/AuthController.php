<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\URL;
use Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $data = [
            'page_title' => 'Login'
        ];

    	return view('auth.login', compact('data'));
    }

    /**
     * Login Attempt
     *
     * @param  \App\Http\Requests\AuthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function attemptLogin(AuthRequest $request)
    {
        // Check field type is email or username
        $field_type = filter_var($request->login , FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Set credentails according to field type
        $credentials = [
            $field_type => $request->login,
            'password' => $request->password
        ];

    	if (Auth::attempt($credentials, $request->has('remember'))) {
    		return response()->success([
                'message' => 'Login Successcully !',
                'redirect' => url('/')
            ]);
    	}

    	return response()->errorMessage('Invalid Email or Password !');
    }

    /**
     * User Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return response()->success([
            'redirect' => route('login')
        ]);
    }
}
