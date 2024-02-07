<?php 

namespace App\Services;

use App\Models\StudentSession;
use App\Models\ExamClass;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Group;
use App\Models\Section;
use App\Models\Grade;
 
class GenerateResultCardService
{
    /**
     * @var $session_id int
     */
    private $session_id;

    /**
     * @var $exam_id int
     */
    private $exam_id;

    /**
     * @var $class_id int
     */
    private $class_id;

    /**
     * @var $section_id int
     */
    private $section_id;

    /**
     * @var $group_id int|null
     */
    private $group_id;

    /**
     * @var $gradings
     */
    private $gradings;

    /**
     * @var $exam_schedules
     */
    private $exam_schedules;

    /**
     * @var $exam_schedule
     */
    private $exam_schedule;

    /**
     * @var $exam_schedule_categories
     */
    private $exam_schedule_categories;

    /**
     * @var $has_all_sub_categories_grading  boolean
     */
    private $has_all_sub_categories_grading;

    /**
     * @var $result_cards
     */
    private $result_cards;

    /**
     * @var $student_session
     */
    private $student_session;

    /**
     * @var $has_student_absent_in_exam  boolean
     */
    private $has_student_absent_in_exam;

    /**
     * @var $absent_status  string
     */
    private $absent_status;

    /**
     * @var $absent_status_color  string
     */
    private $absent_status_color;

    /**
     * @var $empty_cell_value  string
     */
    private $empty_cell_value = '--';

    /**
     * Generate result cards render view.
     *
     * @param \App\Http\Requests\ResultCardRequest  $request
     */
    public function __construct($request)
    {
        $this->session_id = $request->session_id;
        $this->exam_id = $request->exam_id;
        $this->class_id = $request->class_id;
        $this->section_id = $request->section_id;
        $this->group_id = $request->group_id;
    }

	/**
	 * Get result cards view
	 */
	public function getResultCardsView()
	{
		$exam = Exam::with('session')->find($this->exam_id, [ 'id', 'name', 'session_id' ]);
        $class = Classes::with('grades')->find($this->class_id, [ 'id', 'name' ]);
        $group = Group::find($this->group_id, [ 'id', 'name' ]);
        $section = Section::find($this->section_id, [ 'id', 'name' ]);

        $this->setGradings($class); // Gradings
        $this->setExamSchedules(); // Exam Schedules

        // Alert on exam schedules not found
        if (!count($this->exam_schedules)) {
            return $this->alert('exam_schedule', $class);
        }

        $this->setExamScheduleDetails(); // Exam Schedules Details
        $this->setExamScheduleCategories(); // Exam Schedules Categories
        $this->setStudentResultCards();

        // Alert on students not found
        if (!count($this->result_cards)) {
            return $this->alert('student', $class);
        }

		$data = [
			'exam' => $exam,
			'class' => $class,
			'section' => $section,
			'group' => $group,
            'result_cards' => $this->result_cards,
            'has_all_sub_categories_gradings' => $this->has_all_sub_categories_grading,
            'exam_schedule_categories' => $this->exam_schedule_categories
		];

		return view('result-card.get-students-result-card', compact('data'))->render();
	}

	/**
     * Set exam schedules of class.
     *
     * @return void
     */
    public function setExamSchedules()
    {
       $this->exam_schedules = ExamClass::where($this->where('exam_schedule'))
            ->with([
                'examSchedule' => function($query) {
                    $query->select('id', 'exam_class_id', 'subject_id', 'group_id', 'date', 'type', 'marks')
                        ->with([
                            'categories' => [ 'remarks', 'gradeRemarks' ],
                            'remarks', 
                            'gradeRemarks',
                            'subject'
                        ]);
                }
            ])
            ->first()
            ?->examSchedule ?? [];
    }

    /**
     * Set exam schedule details
     * 
     * @return void
     */
    public function setExamScheduleDetails()
    {
        $this->exam_schedules->map(function($exam_schedule) {
            // Exam Schedule total marks
            $exam_schedule->total_marks = match($exam_schedule->type) {
                'grade' => $this->empty_cell_value,
                'marks' => $exam_schedule->marks,
                'categories' => $exam_schedule->categories->sum('marks')
            };

            if ($exam_schedule->type == 'categories') {
                $exam_schedule->has_all_categories_gradings = count($exam_schedule->categories->where('is_grade', 1)) == count($exam_schedule->categories) ? true : false;
            }

            return $exam_schedule;
        });

        $gradings_existance = $this->exam_schedules->where('type', 'categories')->pluck('has_all_categories_gradings')->toArray();
        $this->has_all_sub_categories_grading = in_array(true, $gradings_existance) && !in_array(false, $gradings_existance);
    }

    /**
     * Set exam schedules categories of class.
     *
     * @return void
     */
    public function setExamScheduleCategories()
    {
        $this->exam_schedule_categories = $this->exam_schedules
            ->where('type', 'categories')
            ->flatMap(fn($schedule) => $schedule['categories'])
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Set students result card
     *
     * @return void
     */
    public function setStudentResultCards()
    {
		$this->result_cards = StudentSession::where($this->where('student'))
			->with([
				'student' => function($query) {
                    $query->select('id', 'admission_no', 'first_name', 'last_name');
                },
                'attendances' => function($query) {
                    $query->select('id', 'student_session_id', 'attendance_status_id', 'attendance_date')
                        ->with('attendanceStatus', fn($query) => $query->select('id', 'type'))
                        ->whereIn('attendance_date', $this->getExamDates());
                }
			])
            ->withCount([
                'attendances as total_attendances',
                'attendances as total_present_attendances' => function($query) {
                    $query->whereHas('attendanceStatus', function($query) {
                        $query->where('type', 'present');
                    });
                }
            ])
			->get();

        $this->setStudentResultCardDetails();

        if (!$this->has_all_sub_categories_grading) {
            $this->setStudentResultCardRanking();
        }
    }

    /**
     * Get exam schedule dates
     *
     * @return array
     */    
    public function getExamDates()
    {
        $dates = [];
        foreach ($this->exam_schedules as $exam_schedule) {
            $dates[] = $exam_schedule->date->format('Y-m-d');
        }

        return array_unique($dates);
    }

    /**
     * Set Gradings
     *
     * @param \App\Models\Classes  $class
     */
    public function setGradings($class)
    {
        $this->gradings = $class->gradings;

        // Apply Default Gradings where grade not exists in class
        if (!count($class->grades)) {
            $this->gradings = Grade::withoutGlobalScopes()->where('is_default', 1)->get();
        }
    }

    /**
     * Set student result card details
     *
     * @return void
     */
    public function setStudentResultCardDetails()
    {
        $this->result_cards->map(function($student_session){
            $student_session->gr_no = $student_session->student->admission_no;
            $student_session->student_name = $student_session->student->fullName();

            $this->student_session = $student_session;
            $student_session->result = $this->getStudentResultData();
            
            return $student_session;
        });
    }

    /**
     * Get student result data
     *
     * @return Object
     */
    public function getStudentResultData()
    {
        $result = new \stdClass;
        
        $grading_subjects = []; // Store grading subjects
        $marks_subjects = []; // Store marks subjects

        foreach ($this->exam_schedules as $exam_schedule) {
            $this->exam_schedule = $exam_schedule; // Set exam schedule

            // Check student is absent in exam
            $attendance = $this->student_session->attendances->firstWhere('attendance_date', $exam_schedule->date);
            $this->has_student_absent_in_exam = ($attendance?->attendanceStatus->type == 'absent') ? true : false;
            $this->absent_status = ($this->has_student_absent_in_exam) ? $attendance->attendanceStatus->short_code : '';
            $this->absent_status_color = ($this->has_student_absent_in_exam) ? $attendance->attendanceStatus->color : '';

            match($exam_schedule->type) {
                'categories' => $this->setExamScheduleCategoriesMarks($marks_subjects),
                'marks' => $this->setExamScheduleMarks($marks_subjects),
                'grade' => $this->setExamScheduleGrade($grading_subjects)
            };
        }

        $result->marks_subjects = $marks_subjects;
        $result->grading_subjects = $grading_subjects;

        if (!$this->has_all_sub_categories_grading) {
            $result->is_fail = $this->checkStudentIsFail($marks_subjects, $grading_subjects);
            $result->grand_total = collect($marks_subjects)->sum('total_marks');
            $result->obtain_grand_total = collect($marks_subjects)->sum('obtain_marks');

            // Set percentage from grand total and obtain
            $percentage = 0.00;
            if ($result->obtain_grand_total) {
                $percentage = round(($result->obtain_grand_total * 100) / $result->grand_total, 2);
            }

            // Get grade by percentage
            $grade = $this->getGradeByPercentage($percentage);
            $result->grade = $grade?->grade ?? $this->empty_cell_value;
            $result->grade_remarks = $grade?->remarks ?? $this->empty_cell_value;
            $result->percentage = $percentage;
        }

        return $result;
    }

    /**
     * Set exam schedule categories marks
     * 
     * @param $marks_subjects  array
     * @return void
     */
    public function setExamScheduleCategoriesMarks(&$marks_subjects)
    {
        $remarks = new \stdClass;
        $remarks->subject = $this->exam_schedule->subject->name;
        $remarks->is_absent = $this->has_student_absent_in_exam;
        $remarks->absent_status = $this->absent_status;
        $remarks->absent_status_color = $this->absent_status_color;
        $remarks->max_marks = $this->getExamScheduleMaxRemarks();
        $remarks->sub_categories = $this->getExamScheduleSubCategoriesRemarks();
        $remarks->total_marks = $this->exam_schedule->total_marks;        
        $remarks->obtain_marks = ($this->exam_schedule->has_all_categories_gradings) ? $this->empty_cell_value : array_sum($remarks->sub_categories);
        
        // student is fail when the attendance is absent in exam day
        $remarks->is_fail = $this->has_student_absent_in_exam;

        // Set grade according to total and obtain marks when
        // exam schedule not contain all grading categories
        $remarks->grade = $this->empty_cell_value;
        if (!$this->exam_schedule->has_all_categories_gradings) {
            $grade = $this->getGradeBy($remarks->total_marks, $remarks->obtain_marks);

            // If student not absent in exam but the grade is fail
            // then the student is fail in exam.
            if ($grade) {
                $remarks->grade = $grade->grade;
                $remarks->is_fail = ($grade->is_fail && !$this->has_student_absent_in_exam) ? true : false;
            }
        }

        $marks_subjects[] = $remarks;
    }

    /**
     * Set exam schedule marks
     * 
     * @param $marks_subjects  array
     * @return void
     */
    public function setExamScheduleMarks(&$marks_subjects)
    {
        $remarks = new \stdClass;
        $remarks->subject = $this->exam_schedule->subject->name;
        $remarks->is_absent = $this->has_student_absent_in_exam;
        $remarks->absent_status = $this->absent_status;
        $remarks->absent_status_color = $this->absent_status_color;
        $remarks->max_marks = $this->getExamScheduleMaxRemarks();
        $remarks->sub_categories = $this->getExamScheduleSubCategoriesRemarks();
        $remarks->total_marks = $this->exam_schedule->total_marks;
        $obtain_marks = $this->exam_schedule->remarks->firstWhere('student_session_id', $this->student_session->id);
        $remarks->obtain_marks = ($obtain_marks) ? $obtain_marks->remarks : $this->empty_cell_value;
        
        // student is fail when the attendance is absent in exam day
        $remarks->is_fail = $this->has_student_absent_in_exam;
        $remarks->grade = $this->empty_cell_value;

        // Get grade by total marks and obtain marks
        $grade = $this->getGradeBy($remarks->total_marks, $remarks->obtain_marks);

        if ($grade) {
            $remarks->grade = $grade->grade;
            $remarks->is_fail = ($grade->is_fail && !$this->has_student_absent_in_exam) ? true : false;
        }

        $marks_subjects[] = $remarks;
    }

    /**
     * Set exam schedule grade
     * 
     * @param $grading_subjects  array
     * @return void
     */
    public function setExamScheduleGrade(&$grading_subjects)
    {
        $remarks = new \stdClass;
        $remarks->subject = $this->exam_schedule->subject->name;
        $remarks->is_absent = $this->has_student_absent_in_exam;
        $remarks->absent_status = $this->absent_status;
        $remarks->absent_status_color = $this->absent_status_color;
        $obtain_marks = $this->exam_schedule->gradeRemarks->firstWhere('student_session_id', $this->student_session->id);

        // student is fail when the attendance is absent in exam day
        $remarks->is_fail = $this->has_student_absent_in_exam;
        $remarks->obtain_grade = $this->empty_cell_value;
        
        if ($obtain_marks) {
            $grade = $this->getGradeById($obtain_marks->grade_id);

            // If grade exists set grade value and also check grade failure
            if ($grade) {
                $remarks->obtain_grade = $grade->grade;
                $remarks->is_fail = ($grade->is_fail && !$this->has_student_absent_in_exam) ? true : false;
            }
        }

        $grading_subjects[] = $remarks;
    }

    /**
     * Get exam schedule sub categories remarks
     *
     * @return array
     */
    public function getExamScheduleSubCategoriesRemarks()
    {
        if ($this->exam_schedule->type == 'marks') {
            return array_map(fn($value) => $this->empty_cell_value, $this->exam_schedule_categories);
        }

        $remarks = [];
        foreach ($this->exam_schedule_categories as $category) {
            $category = $this->exam_schedule->categories->firstWhere('name', $category);

            if ($category) {
                $remarks[] = ($category->is_grade == 1)
                    ? $this->getExamScheduleSubCategoryGradeMarks($category)
                    : $this->getExamScheduleSubCategoryObtainMarks($category);
                
                continue;
            }

            $remarks[] = $this->empty_cell_value;
        }

        return $remarks;
    }

    /**
     * Get exam schedule max remarks
     *
     * @return array
     */
    public function getExamScheduleMaxRemarks()
    {
        if ($this->exam_schedule->type == 'marks'
            || $this->exam_schedule->has_all_categories_gradings) {
            return array_map(fn($value) => $this->empty_cell_value, $this->exam_schedule_categories);
        }

        $max_remarks = [];
        foreach ($this->exam_schedule_categories as $category) {
            $category = $this->exam_schedule->categories->firstWhere('name', $category);

            if ($category) {
                $max_remarks[] = ($category->is_grade == 1)
                    ? $this->empty_cell_value
                    : $category->marks;
                
                continue;
            }

            $max_remarks[] = $this->empty_cell_value;
        }

        return $max_remarks;
    }

    /**
     * Get grade by id
     *
     * @param $grade_id  int
     * @return string
     */
    public function getGradeById($grade_id)
    {
        return $this->gradings->firstWhere('id', $grade_id);
    }

    /**
     * Get exam schedule sub category grade marks
     * 
     * @return string
     */
    public function getExamScheduleSubCategoryGradeMarks($category)
    {
        $obtain_grade = $category->gradeRemarks->firstWhere('student_session_id', $this->student_session->id);

        if ($obtain_grade?->grade_id) {
            return $this->getGradeById($obtain_grade->grade_id)?->grade ?? $this->empty_cell_value;
        }

        return $this->empty_cell_value;
    }

    /**
     * Get exam schedule sub category obtain marks
     * 
     * @return string|int
     */
    public function getExamScheduleSubCategoryObtainMarks($category)
    {
        $obtain_marks = $category->remarks->firstWhere('student_session_id', $this->student_session->id);

        if ($obtain_marks) {
            return $obtain_marks->remarks;
        }

        return $this->empty_cell_value;
    }

    /**
     * Get grade by total marks and obtain marks
     *
     * @param $total_marks   int
     * @param $obtain_marks  int
     */
    public function getGradeBy($total_marks, $obtain_marks)
    {
        $total_marks = (is_numeric($total_marks)) ? round($total_marks, 2) : 0;
        $obtain_marks = (is_numeric($obtain_marks)) ? round($obtain_marks, 2) : 0;
        $percentage = ($obtain_marks) ? ($obtain_marks * 100) / $total_marks : 0;

        return $this->getGradeByPercentage($percentage);
    }

    /**
     * Get grade by percentage
     * 
     * @param $percentage  int
     * @return \App\Models\Grade
     */
    public function getGradeByPercentage($percentage)
    {
        foreach ($this->gradings as $grade) {
            if ($percentage >= $grade->percentage_from &&
                $percentage <= $grade->percentage_to) {
                return $grade;
            }    
        }
    }

    /**
     * Check student is fail
     *
     * @param $marks_subjects       array
     * @param $grading_subjects     array
     * @return                      boolean
     */
    public function checkStudentIsFail($marks_subjects, $grading_subjects)
    {
        $subjects_failures = collect($marks_subjects)->pluck('is_fail')->toArray();
        $is_fail_in_marks = in_array(true, $subjects_failures);

        $grading_subjects_failures = collect($grading_subjects)->pluck('is_fail')->toArray();
        $is_fail_in_grading_subjects = in_array(true, $grading_subjects_failures);

        return $is_fail_in_marks || $is_fail_in_grading_subjects;
    }

    /**
     * Set student result card ranking
     *
     * @return void
     */
    public function setStudentResultCardRanking()
    {
        $rank = 1;
        $previous_obtain = null;

        $this->result_cards
            ->pluck('result')
            ->sortByDesc('obtain_grand_total')
            ->map(function($result_card) use(&$rank, &$previous_obtain) {
                // Set default empty value
                $result_card->rank = $this->empty_cell_value;

                // Student is not fail apply ranking
                if (!$result_card->is_fail) {
                    if ($result_card->obtain_grand_total !== $previous_obtain) {
                        $result_card->rank = $this->suffix($rank++);
                        $previous_obtain = $result_card->obtain_grand_total;
                    } else {
                        $result_card->rank = $this->suffix($rank - 1);
                    }
                }

                return $result_card;
            });
    }

    /**
     * Where conditions
     * 
     * @param $for  string
     * @return array
     */
    public function where($for)
    {
        if ($for == 'exam_schedule') 
        {
            $where = [
                'exam_id' => $this->exam_id,
                'class_id' => $this->class_id
            ];

            // Add Group when exists
            if ($this->group_id) $where['group_id'] = $this->group_id;
        }

        if ($for == 'student')
        {
            $where = [
                'class_id' => $this->class_id,
                'session_id' => $this->session_id,
                'section_id' => $this->section_id
            ];

            // Add Group when exists
            if ($this->group_id) $where['groupId'] = $this->group_id;
        }

        return $where;
    }

    /**
     * Alert view
     *
     * @param $for  string
     */
    public function alert($for, $class)
    {
        $alert = "Something went wrong."; // Default Alert

        if ($for == 'exam_schedule') {
            $alert = "The exam schedules for class ( $class->name ) can not be prepared.";
        }

        if ($for == 'student') {
            $alert = "Students not found for class ( $class->name )";
        }

        return view('result-card.get-students-result-card', [
            'alert' => $alert
        ])->render();
    }

    /**
     * Number suffix
     * 
     * @param $number  int
     * @return string
     */
    public function suffix($number)
    {
        if (!is_numeric($number)) {
            return $number; // Return as is if it's not a number
        }

        $last_two_digits = $number % 100;

        if ($last_two_digits >= 11 && $last_two_digits <= 13) {
            $suffix = 'th';
        } else {
            $last_digit = $number % 10;

            switch ($last_digit) {
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
                    break;
            }
        }

        return $number . $suffix;
    }
}
