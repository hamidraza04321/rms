<?php

namespace App\Services;

use App\Models\Exam;

class ExamDatesheetService
{
	/**
	 * Get Datesheet 
	 *
	 * @param $exam_id int
	 */
	public function getDatesheet($exam_id)
	{
		$datesheet = new \stdClass;
		
		$exam = Exam::with([
			'session',
			'classes' => function($query) {
				$query->has('examSchedule')->with('group', 'examSchedule.subject');
			}
		])->findOrFail($exam_id);

		$exam_classes = $exam->classes->filter(fn($exam_class) => empty($exam_class->group));
		$exam_classes_group = $exam->classes->filter(fn($exam_class) => !empty($exam_class->group));

		$datesheet->exam = $exam;
		$datesheet->classes = $exam_classes->pluck('class');
		$datesheet->exam_schedules = $this->arrangeExamSchedule($exam_classes);
		$datesheet->group_classes = $exam_classes_group->groupBy('class.name');
		$datesheet->exam_schedules_group = $this->arrangeExamScheduleGroup($exam_classes_group);

		// dd($this->arrangeExamScheduleGroup($exam_classes_group));
		return $datesheet;
	}

	/**
	 * Arrange exam schedule
	 *
	 * @param $exam_classes  array
	 */
	public function arrangeExamSchedule($exam_classes)
	{
		$exam_schedules = [];
		$class_ids = $exam_classes->pluck('class_id');
		$exam_classes = $this->groupByDateAndTimeExamSchedules($exam_classes);

		$i = 0;
		foreach ($exam_classes as $date => $exam_class) {
			++$i;

			foreach ($exam_class as $time => $exam_schedule) {
				foreach ($class_ids as $class_id) {
					$subjects = $exam_schedule->where('class_id', $class_id)->pluck('subject.name')->toArray();
					$exam_schedules[$i]['date'] = $date;
					$exam_schedules[$i]['timings_count'] = count($exam_class);
					$exam_schedules[$i]['timings'][$time][$class_id] = $subjects;
				}
			}
		}

		return json_decode(json_encode($exam_schedules)); // Convert array in to object
	}

	/**
	 * Group by date and time of exam schedule
	 *
	 * @param $exam_classes  array
	 */
	public function groupByDateAndTimeExamSchedules($exam_schedules)
	{
		return $exam_schedules
			->map(function($exam_class){
				$exam_class->examSchedule
					->map(function($schedule) use($exam_class){
						$schedule->class_id = $exam_class->class_id;
						$schedule->group_id = $exam_class->group_id;
						$schedule->time = $this->getTime($schedule);
						return $schedule;
					});

				return $exam_class;
			})
			->pluck('examSchedule')
			->collapse()
			->sortBy('date')
			->groupBy('date')
			->map(fn($schedule) => $schedule->groupBy('time'));
	}

	/**
	 * Arrange exam schedule group
	 *
	 * @param $exam_classes_group  array
	 */
	public function arrangeExamScheduleGroup($exam_classes_group)
	{
		$exam_schedules = [];
		$class_group_ids = $exam_classes_group->map(fn($class) => $class->class_id . '-'. $class->group_id)->toArray();
		$exam_classes_group = $this->groupByDateAndTimeExamSchedules($exam_classes_group);

		$i = 0;
		foreach ($exam_classes_group as $date => $exam_class_group) {
			++$i;

			foreach ($exam_class_group as $time => $exam_schedule) {
				foreach ($class_group_ids as $class_group_id) {
					$class_group_id = explode('-', $class_group_id);
					$class_id = $class_group_id[0];
					$group_id = $class_group_id[1];

					$subjects = $exam_schedule
						->where('class_id', $class_id)
						->where('group_id', $group_id)
						->pluck('subject.name')
						->toArray();

					$exam_schedules[$i]['date'] = $date;
					$exam_schedules[$i]['timings_count'] = count($exam_class_group);
					$exam_schedules[$i]['timings'][$time][$class_id][$group_id] = $subjects;
				}
			}
		}

		return json_decode(json_encode($exam_schedules)); // Convert array in to object
	}

	/**
	 * Get time
	 *
	 * @param $schedule  Object
	 */
	public function getTime($schedule)
	{
		$start_time = date('h:i A', strtotime($schedule->start_time));
		$end_time = date('h:i A', strtotime($schedule->end_time));

		return $start_time . ' to ' . $end_time;
	}
}