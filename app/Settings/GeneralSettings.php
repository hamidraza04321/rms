<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;
use App\Models\Session;

class GeneralSettings extends Settings
{
	public string $school_name;

	public string $school_name_in_short;

	public string $email;

	public string $phone_no;
    
    public string $school_address;

    public string $school_logo;

    public string $date_format;

    public int $current_session_id;

    public static function group(): string
    {
        return 'general';
    }

    public function currentSessionName()
    {
    	return Session::find($this->current_session_id)->name ?? '';
    }
}