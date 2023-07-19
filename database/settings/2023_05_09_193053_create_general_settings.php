<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.school_name', 'School Name');
    	$this->migrator->add('general.school_name_in_short', 'RMS');
    	$this->migrator->add('general.email', 'info@gmail.com');
    	$this->migrator->add('general.phone_no', '');
        $this->migrator->add('general.school_address', 'School Address');
        $this->migrator->add('general.school_logo', 'assets/dist/img/your-school-logo.png');
        $this->migrator->add('general.date_format', 'd-m-Y');
        $this->migrator->add('general.date_format_in_js', 'dd-mm-yy');
        $this->migrator->add('general.current_session_id', 2);
    }
};
