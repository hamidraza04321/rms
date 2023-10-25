<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamClass;
use App\Models\Subject;
use App\Models\ExamSchedule;

class ExamScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = [];
        $exam_classes = ExamClass::get();
        $subjects = Subject::get();

        foreach ($exam_classes as $exam_class) {
            $date = date('Y-m-d');
        	
            foreach ($subjects as $subject) {
        		$data[] = [
        			'exam_class_id' => $exam_class->id,
        			'subject_id' => $subject->id,
        			'type' => 'grade',
                    'date' => $date,
                    'from_time' => '09:00',
                    'to_time' => '12:00',
        			'created_at' => now(),
        			'updated_at' => now()
        		];

                $date = date('Y-m-d', strtotime($date . ' +1 day'));
        	}
        }

        ExamSchedule::insert($data);
    }
}
