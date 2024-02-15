<?php

namespace App\Services;

use App\Models\StudentAttendance;
use App\Models\Classes;
use App\Models\AttendanceStatus;

class DashboardService
{
	/**
	 * Get attendance graph data
	 *
	 * @param $from_date 	string
	 * @param $to_date 		string
	 * @return 				array
	 */
	public function getAttendaceGraphData($from_date, $to_date)
	{
		$graph_data = [];

		$classes = Classes::get([ 'id', 'name' ]);
		$graph_data['categories'] = $classes->pluck('name')->toArray(); // Graph Categories

		// Get Attendaces count with group by class_id and attendance_status_id
		$attendances = StudentAttendance::join('student_sessions', 'student_sessions.id', '=', 'student_attendances.student_session_id')
		    ->join('attendance_statuses', 'attendance_statuses.id', '=', 'student_attendances.attendance_status_id')
		    ->select('student_sessions.class_id', 'attendance_statuses.name', 'student_attendances.attendance_status_id', \DB::raw('count(*) as total_attendances'))
		    ->whereBetween('student_attendances.attendance_date', [$from_date, $to_date])
		    ->has('studentSession')
		    ->groupBy('student_sessions.class_id', 'student_attendances.attendance_status_id')
		    ->get();

		$graph_data['series'] = $this->getAttendanceGraphSeries($classes, $attendances);

		return $graph_data;
	}

	/**
	 * Get attendance graph series
	 *
	 * @param App\Models\Classes 			$classes
	 * @param App\Models\StudentAttendance 	$attendances
	 * @return 								array
	 */
	public function getAttendanceGraphSeries($classes, $attendances)
	{
		$attendance_statuses = AttendanceStatus::pluck('name')->toArray();
		$series = array_fill_keys($attendance_statuses, []);

		foreach ($classes->pluck('id') as $class_id)
		{
			$class_attendances = $attendances->where('class_id', $class_id);
			$this->setClassAttendance($class_attendances, $attendance_statuses, $series);
		}

		return $series;
	}

	/**
	 * Set class attendances
	 *
	 * @param App\Models\StudentAttendance 	$class_attendances
	 * @param App\Models\AttendanceStatus   $attendance_statuses
	 * @param $series 						array
	 * @return 								void
	 */
	public function setClassAttendance($class_attendances, $attendance_statuses, &$series)
	{
		$total_attendances = $class_attendances->sum('total_attendances');

		foreach ($attendance_statuses as $attendance_status)
		{
			$attendance = $class_attendances->firstWhere('name', $attendance_status);

			if ($attendance) {
				$percentage = ($attendance->total_attendances * 100) / $total_attendances;
				$series[$attendance_status][] = round($percentage, 2);
				continue;
			}

			$series[$attendance_status][] = 0; // Default set attendance percentage is zero
		}
	}
}
