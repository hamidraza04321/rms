<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamClass;

class ExamClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ExamClass::insert([
        	[ 'exam_id' => 1, 'class_id' => 1, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 2, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 3, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 4, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 5, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 6, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 7, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 8, 'group_id' => null ],
        	[ 'exam_id' => 1, 'class_id' => 9, 'group_id' => 1 ],
        	[ 'exam_id' => 1, 'class_id' => 9, 'group_id' => 2 ],
        	[ 'exam_id' => 1, 'class_id' => 9, 'group_id' => 3 ],
        	[ 'exam_id' => 1, 'class_id' => 9, 'group_id' => 4 ],
        	[ 'exam_id' => 1, 'class_id' => 10, 'group_id' => 1 ],
        	[ 'exam_id' => 1, 'class_id' => 10, 'group_id' => 2 ],
        	[ 'exam_id' => 1, 'class_id' => 10, 'group_id' => 3 ],
        	[ 'exam_id' => 1, 'class_id' => 10, 'group_id' => 4 ]
        ]);
    }
}
