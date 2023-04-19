<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassGroup;

class ClassGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($class_id = 9; $class_id <= 10; $class_id++) {
        	for ($group_id = 1; $group_id <= 4; $group_id++) { 
        		ClassGroup::create([
        			'class_id' => $class_id,
        			'group_id' => $group_id
        		]);
        	}
        }
    }
}
