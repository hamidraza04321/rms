<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\URL;
use Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'page_title' => 'Login'
        ];

    	return view('auth.login', compact('data'));
    }

    public function attemptLogin(AuthRequest $request)
    {
    	if (Auth::attempt($request->validated())) {
    		return response()->success([
                'message' => 'Login Successcully !',
                'redirect' => url('/')
            ]);
    	}

    	return response()->errorMessage('Invalid Email or Password !');
    }

    public function logout()
    {
        Auth::logout();
        return response()->success([
            'redirect' => route('login')
        ]);
    }
}
