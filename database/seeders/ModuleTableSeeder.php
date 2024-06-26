<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                'name' => 'Session',
                'order_level' => 1
            ],
            [
                'name' => 'Class',
                'order_level' => 2
            ],
            [ 
                'name' => 'Section',
                'order_level' => 3
            ],
            [
                'name' => 'Group',
                'order_level' => 4
            ],
            [
                'name' => 'Subject',
                'order_level' => 5
            ],
            [
                'name' => 'Student', 
                'order_level' => 6
            ],
            [
                'name' => 'Attendance Status',
                'order_level' => 7
            ],
            [
                'name' => 'Student Attendance',
                'order_level' => 8
            ],
            [
                'name' => 'Exams',
                'order_level' => 9
            ],
            [
                'name' => 'Grade',
                'order_level' => 11
            ],
            [
                'name' => 'Exam Schedule',
                'order_level' => 10
            ],
            [
                'name' => 'Mark Slip',
                'order_level' => 12
            ],
            [
                'name' => 'Result Card',
                'order_level' => 13
            ],
            [
                'name' => 'Role',
                'order_level' => 14
            ],
            [
                'name' => 'User',
                'order_level' => 15
            ],
            [
                'name' => 'Settings',
                'order_level' => 16
            ],
            [
                'name' => 'User Profile',
                'order_level' => 17
            ],
            [
                'name' => 'Dashboard',
                'order_level' => 18
            ]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($modules as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Module::insert($data);
    }
}
