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
        $attendance_statuses = [
        	[
        		'name' => 'Present',
                'short_code'=> 'P',
        		'color'=> '#28a745',
        		'type' => 'present'
        	],
        	[
        		'name' => 'Absent',
        		'short_code'=> 'A',
                'color'=> '#dc3545',
        		'type' => 'absent'
        	],
        	[
        		'name' => 'Leave',
        		'short_code'=> 'L',
                'color'=> '#b48700',
        		'type' => 'leave'
        	],
        	[
        		'name' => 'Holiday',
        		'short_code'=> 'H',
                'color'=> '#007bff',
        		'type' => 'holiday'
        	]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($attendance_statuses as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        AttendanceStatus::insert($data);
    }
}
