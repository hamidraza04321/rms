<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Settings\GeneralSettings;
use App\Models\Session;

class SettingController extends Controller
{
    public function index()
    {
    	$sessions = Session::get();

    	$data = [
    		'page_title' => 'General Settings'
    	];

    	return view('settings', compact('data'));
    }

    public function updateLogo(SettingsRequest $request, GeneralSettings $settings)
    {
        $file_name = 'logo.' . $request->app_logo->extension();
        $request->app_logo->move(public_path('assets/dist/img'), $file_name);
     	
     	// Update Settings   
        $settings->school_logo = 'assets/dist/img/' . $file_name;
        $settings->save();

        return response()->success([
        	'image_src' => url($settings->school_logo),
        	'message' => 'Logo Updated Successfully!'
        ]);
    }
}
