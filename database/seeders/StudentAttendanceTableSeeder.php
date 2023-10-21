<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentAttendance;
use App\Models\StudentSession;
use Carbon\CarbonPeriod;

class StudentAttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Create Attendance from date to date
    	$dates = [];
        $from_date = date('Y-m-d', strtotime('-2 days'));
        $to_date = date('Y-m-t', strtotime('+2 days'));

        $period = CarbonPeriod::between($from_date, $to_date);
        foreach ($period as $date) {
		    $dates[] = $date->format('Y-m-d');
		}

		// Get student session ids
		$student_session_ids = StudentSession::pluck('id');

		$attendances = [];
		foreach ($dates as $date) {
			foreach ($student_session_ids as $student_session_id) {
				$attendances[] = [
					'student_session_id' => $student_session_id,
					'attendance_status_id' => (date('D', strtotime($date)) == 'Sun') ? 4 : rand(1, 3),
					'attendance_date' => $date,
					'created_at' => now(),
					'updated_at' => now()
				];
			}
		}

		StudentAttendance::insert($attendances);
    }
}
