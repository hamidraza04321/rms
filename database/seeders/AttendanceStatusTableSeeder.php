<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AttendanceStatus;

class AttendanceStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendance_statuses = collect([
        	[
        		'name' => 'Present',
                'short_code'=> 'P',
        		'color'=> '#28a745',
        		'show_in_result_card' => 0
        	],
        	[
        		'name' => 'Absent',
        		'short_code'=> 'A',
                'color'=> '#dc3545',
        		'show_in_result_card' => 1
        	],
        	[
        		'name' => 'Leave',
        		'short_code'=> 'L',
                'color'=> '#b48700',
        		'show_in_result_card' => 0
        	],
        	[
        		'name' => 'Holiday',
        		'short_code'=> 'H',
                'color'=> '#007bff',
        		'show_in_result_card' => 0
        	]
        ]);

        $attendance_statuses->each(function($attendance_status) {
	        AttendanceStatus::create($attendance_status);
        });
    }
}
