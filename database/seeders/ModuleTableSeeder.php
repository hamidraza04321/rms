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
        $modules = collect([
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
            ]
        ]);

        $modules->each(function($module) {
	        Module::create($module);
        });
    }
}
