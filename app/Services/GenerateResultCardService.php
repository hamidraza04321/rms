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
     * @var $sessionId int
     */
    private $sessionId;

    /**
     * @var $examId int
     */
    private $examId;

    /**
     * @var $classId int
     */
    private $classId;

    /**
     * @var $sectionId int
     */
    private $sectionId;

    /**
     * @var $groupId int|null
     */
    private $groupId;

    /**
     * @var $gradings
     */
    private $gradings;

    /**
     * @var $examSchedules
     */
    private $examSchedules;

    /**
     * @var $examScheduleCategories
     */
    private $examScheduleCategories;

    /**
     * @var $resultCards
     */
    private $resultCards;

    /**
     * Generate result cards render view.
     *
     * @param \App\Http\Requests\ResultCardRequest  $request
     */
    public function __construct($request)
    {
        $this->sessionId = $request->session_id;
        $this->examId = $request->exam_id;
        $this->classId = $request->class_id;
        $this->sectionId = $request->section_id;
        $this->groupId = $request->group_id;
    }

	/**
	 * Get result cards view
	 */
	public function getResultCardsView()
	{
		$exam = Exam::with('session')->find($this->examId, [ 'id', 'name', 'session_id' ]);
        $class = Classes::with('grades')->find($this->classId, [ 'id', 'name' ]);
        $group = Group::find($this->groupId, [ 'id', 'name' ]);
        $section = Section::find($this->sectionId, [ 'id', 'name' ]);

        $this->setGradings($class); // Gradings
        $this->setExamSchedules(); // Exam Schedules

        // Alert on exam schedules not found
        if (!count($this->examSchedules)) {
            return $this->alert('examSchedule', $class);
        }

        $this->setExamScheduleCategories(); // Exam Schedules Categories
        $this->setStudentResultCards();

        // Alert on students not found
        if (!count($this->resultCards)) {
            return $this->alert('student', $class);
        }

		$data = [
			'exam' => $exam,
			'class' => $class,
			'section' => $section,
			'group' => $group,
            'result_cards' => $this->resultCards
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
       $this->examSchedules = ExamClass::where($this->where('examSchedule'))
            ->with([
                'examSchedule' => function($query) {
                    $query->select('id', 'exam_class_id', 'subject_id', 'group_id', 'date', 'type', 'marks')
                        ->with([
                            'categories' => [ 'remarks', 'gradeRemarks' ],
                            'remarks', 
                            'gradeRemarks'
                        ]);
                }
            ])
            ->first()
            ?->examSchedule ?? [];
    }

    /**
     * Set exam schedules categories of class.
     *
     * @return void
     */
    public function setExamScheduleCategories()
    {
        $this->examScheduleCategories = $this->examSchedules
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
		$this->resultCards = StudentSession::where($this->where('student'))
			->with([
				'student' => function($query) {
                    $query->select('id', 'admission_no', 'first_name', 'last_name');
                }
			])
            ->withCount([
                'attendances as total_attendances',
                'attendances as total_present_attendances' => function($query) {
                    $query->whereHas([
                        'attendanceStatus' => function($query) {
                            $query->where('type', 'present');
                        }
                    ]);
                }
            ])
			->get();

        $this->mapStudentResultCardDetails();
    }

    /**
     * Get exam schedule dates
     *
     * @return array
     */    
    public function getExamDates()
    {
        $dates = [];
        foreach ($this->examSchedules as $examSchedule) {
            $dates[] = $examSchedule->date->format('Y-m-d');
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
     * Map student result card details
     *
     * @return void
     */
    public function mapStudentResultCardDetails()
    {
        $this->resultCards->map(function($studentSession){
            $studentSession->gr_no = $studentSession->student->admission_no;
            $studentSession->student_name = $studentSession->student->fullName();
            return $studentSession;
        });

        dd($this->resultCards);
    }

    /**
     * Where conditions
     * 
     * @param $for  string
     * @return array
     */
    public function where($for)
    {
        if ($for == 'examSchedule') 
        {
            $where = [
                'exam_id' => $this->examId,
                'class_id' => $this->classId
            ];

            // Add Group when exists
            if ($this->groupId) $where['group_id'] = $this->groupId;
        }

        if ($for == 'student')
        {
            $where = [
                'class_id' => $this->classId,
                'session_id' => $this->sessionId,
                'section_id' => $this->sectionId
            ];

            // Add Group when exists
            if ($this->groupId) $where['groupId'] = $this->groupId;
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

        if ($for == 'examSchedule') {
            $alert = "The exam schedules for class ( $class->name ) can not be prepared.";
        }

        if ($for == 'student') {
            $alert = "Students not found for class ( $class->name )";
        }

        return view('result-card.get-students-result-card', [
            'alert' => $alert
        ])->render();
    }
}
