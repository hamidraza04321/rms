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
        	'description' => 'First Term Exam',
            'datesheet_note' => '<h5><b>Note:</b></h5><ul><li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</li><li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li><li><strong style="margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer&nbsp;</span><br></li></ul>'
        ]);
    }
}
