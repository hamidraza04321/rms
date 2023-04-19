<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassSection;

class ClassSectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($class_id = 1; $class_id <= 10; $class_id++) {
    		for ($section_id= 1; $section_id <= 6; $section_id++) { 
        		ClassSection::create([
        			'class_id' => $class_id,
        			'section_id' => $section_id
        		]);
    		}
    	}
    }
}
