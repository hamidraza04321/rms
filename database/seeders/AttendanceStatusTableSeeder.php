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
        		'is_absent' => 0
        	],
        	[
        		'name' => 'Absent',
        		'short_code'=> 'A',
                'color'=> '#dc3545',
        		'is_absent' => 1
        	],
        	[
        		'name' => 'Leave',
        		'short_code'=> 'L',
                'color'=> '#b48700',
        		'is_absent' => 0
        	],
        	[
        		'name' => 'Holiday',
        		'short_code'=> 'H',
                'color'=> '#007bff',
        		'is_absent' => 0
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
