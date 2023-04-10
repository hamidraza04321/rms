<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
    	return view('auth.login', [
    		'page_title' => 'Login'
    	]);
    }

    public function attemptLogin(AuthRequest $request)
    {
    	if (Auth::attempt($request->validated())) {
    		return response()->successMessage('Login Successfully !');
    	}

    	return response()->errorMessage('Invalid Email or Password !');
    }
}
