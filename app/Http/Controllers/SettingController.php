<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Settings\GeneralSettings;
use App\Models\Session;

class SettingController extends Controller
{
    public function __construct(GeneralSettings $settings)
    {
        $this->middleware('permission:general-settings-view', [ 'only' => 'generalSettings' ]);
        $this->middleware('permission:general-settings-edit', [ 'only' => [ 'updateLogo', 'update' ] ]);
        $this->settings = $settings;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalSettings()
    {
    	$sessions = Session::get();

    	$data = [
            'sessions' => $sessions,
    		'page_title' => 'General Settings',
            'menu' => 'Settings'
    	];

    	return view('settings.general-settings', compact('data'));
    }

    /**
     * Update app logo.
     *
     * @param \App\Http\Requests\SettingsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateLogo(SettingsRequest $request)
    {
        $file_name = 'logo.' . $request->app_logo->extension();
        $request->app_logo->move(public_path('assets/dist/img'), $file_name);
     	
     	// Update Settings   
        $this->settings->school_logo = 'assets/dist/img/' . $file_name;
        $this->settings->save();

        return response()->success([
        	'image_src' => url($this->settings->school_logo),
        	'message' => 'Logo Updated Successfully!'
        ]);
    }

    /**
     * Update Settings.
     *
     * @param \App\Http\Requests\SettingsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(SettingsRequest $request)
    {
        collect($request->validated())
            ->each(function($setting, $key){
                $this->settings->$key = $setting;
            });

        $this->settings->save();
        return response()->successMessage('Settings Updated Successfully !');
    }
}
