<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Settings\GeneralSettings;

class ExamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// For Testing Purpose
        Exam::create([
        	'session_id' => (new GeneralSettings)->current_session_id,
        	'name' => 'First Mid Term',
        	'description' => 'First Term Exam'
        ]);
    }
}
