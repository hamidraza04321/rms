<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\StudentSession;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$student_sessions = [];
        
        Student::factory()
        	->count(5000)
        	->create()
        	->each(function($student) use(&$student_sessions) {
	    		$class_id = rand(1, 10);
	    		$section_id = rand(1, 4);
				$group_id = (in_array($class_id, [9,10])) ? rand(1, 4) : null;

				$student_sessions[] = [
					'student_id' => $student->id,
					'session_id' => 2,
					'class_id' => $class_id,
					'section_id' => $section_id,
					'group_id' => $group_id,
					'created_at' => now(),
					'updated_at' => now()
				];
	    	});

	    StudentSession::insert($student_sessions);
    }
}
