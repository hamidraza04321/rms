<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
	public string $school_name;
    
    public bool $school_address;

    public string $school_logo;

    public string $date_format;

    public int $current_session_id;

    public static function group(): string
    {
        return 'general';
    }
}