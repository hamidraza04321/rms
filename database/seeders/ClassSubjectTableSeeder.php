<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClassSubject;

class ClassSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($class_id = 1; $class_id <= 10; $class_id++) { 
        	for ($subject_id = 1; $subject_id <= 8; $subject_id++) { 
        		ClassSubject::create([
        			'class_id' => $class_id,
        			'subject_id' => $subject_id
        		]);
        	}
        }
    }
}
