<?php 

namespace App\Services;

use App\Models\StudentSession;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Group;
use App\Models\ExamClass;
use App\Models\Grade;
use App\Models\MarkSlip;
use App\Models\ExamGradeRemarks;
use App\Models\ExamRemarks;
 
class MarkSlipService
{
	/**
     * Get markslips view
     *
     * @return \Illuminate\Http\Response
     */
	public function getMarkSlipView($request)
	{
        // Store marslips
        $markslips = [];

		$exam = Exam::with('session')->find($request->exam_id);
        $class = Classes::with('grades')->find($request->class_id);
        $group = Group::find($request->group_id);
        $sections = Section::whereIn('id', $request->section_id)->get();
        $subjects = Subject::whereIn('id', $request->subject_id)->get();

        // Apply Default Gradings where grade not exists in class
        if (!count($class->grades)) {
            $class->grades = Grade::withoutGlobalScopes()->where('is_default', 1)->get();
        }

        // Get exam schedules of class
        $exam_schedules = $this->getExamSchedules($request);

        // Pluck exam dates for attendance
        $exam_dates = $exam_schedules?->pluck('date')->toArray() ?? [];

        // Get Student according to group by section key
        $students = $this->getStudents($request, $exam_dates);

        // Loop in subject
        foreach ($subjects as $subject) {
            // Loop in sections
            foreach ($sections as $section) {
                // Check if the student exists in section by thier key in group by
                if (!isset($students[$section->id])) {
                    continue;
                }

                // Get new stdClass
                $markslip = new \stdClass;
                
                // Filter from collection
                $section = $sections->firstWhere('id', $section->id);
                $subject = $subjects->firstWhere('id', $subject->id);

                // Store Names
                $markslip->session = $exam->session->name;
                $markslip->exam = $exam->name;
                $markslip->class = $class->name;
                $markslip->section = $section->name;
                $markslip->subject = $subject->name;
                $markslip->group = $group->name ?? '---';

                // Class Gradeings
                $markslip->grades = $class->grades;

                // Get student by section key from collecion
                $markslip->students = $students[$section->id];

                // Exam Schedule by subject filter from exam schedules
                $markslip->exam_schedule = $exam_schedules->firstWhere('subject_id', $subject->id);

                // Push in to collection
                $markslips[] = $markslip;
            }
        }

        $data = [
            'markslips' => $markslips,
            'class' => $class,
            'has_all_students_absent' => $this->checkHasAllStudentsAbsent($markslips)
        ];

        return view('markslip.get-markslip', compact('data'))->render();
	}

	/**
     * Get students by session, class, section.
     *
     * @return \Illuminate\Http\Response
     */ 
	public function getStudents($request, $exam_dates)
	{
		$where = [
			'class_id' => $request->class_id,
            'session_id' => $request->session_id
		];

        if ($request->group_id) $where['group_id'] = $request->group_id;

		// Get students by group by section
		$students = StudentSession::where($where)
            ->whereIn('section_id', $request->section_id)
            ->with([
                'student' => function($query) {
                    $query->select('id', 'roll_no', 'first_name', 'last_name');
                },
                'attendances' => function($query) use($exam_dates) {
                    $query
                        ->select('id', 'student_session_id', 'attendance_status_id', 'attendance_date')
                        ->with('attendanceStatus')
                        ->whereIn('attendance_date', $exam_dates);
                }
            ])
            ->get([
                'id',
                'student_id',
                'section_id'
            ])
            ->map(function($student_session) {
                $student_session->student->section_id = $student_session->section_id;
                $student_session->student->student_session_id = $student_session->id;
            	$student_session->student->attendances = $this->arrangeAttendance($student_session);
            	return $student_session;
            })
            ->pluck('student')
            ->groupBy('section_id');

        return $students;
	}

    /**
     * Arrange Attendance.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function arrangeAttendance($student_session)
    {
        return $student_session->attendances
            ->map(function($attendance) {
                $attendance->is_absent = $attendance->attendanceStatus->is_absent;
                $attendance->color = $attendance->attendanceStatus->color;
                $attendance->name = $attendance->attendanceStatus->name;
                return $attendance;
            });
    }

    /**
     * Check has all students are absent in markslips
     *
     * @return bool
     */
    public function checkHasAllStudentsAbsent($markslips)
    {
        if (!count($markslips)) {
            return false;
        }

        $absenties_markslips = [];
        
        foreach ($markslips as $markslip) {
            $students_count = $markslip->students->count();
            $exam_date = date('Y-m-d', strtotime($markslip->exam_schedule->date));
            
            $absent_students_count = $markslip->students
                ->filter(function($student) use($exam_date) {
                    return $student->attendances?->firstWhere('attendance_date', $exam_date)?->is_absent;
                })
                ->count();

            $absenties_markslips[] = ($students_count == $absent_students_count) ? true : false;
        }

        return in_array(true, $absenties_markslips) && !in_array(false, $absenties_markslips);
    }

    /**
     * Get exam schedules of class subjects.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function getExamSchedules($request)
    {
        $where = [
            'exam_id' => $request->exam_id,
            'class_id' => $request->class_id
        ];

        // Add Group when exists
        if ($request->group_id) $where['group_id'] = $request->group_id;

        // Get Exam schedules
        $exam_schedules = ExamClass::where($where)
            ->with([
                'examSchedule' => function($query) use($request) {
                    $query->select(
                            'id',
                            'exam_class_id',
                            'subject_id',
                            'group_id', 
                            'date',
                            'type',
                            'marks'
                        )
                        ->whereIn('subject_id', $request->subject_id)
                        ->with([
                            'categories' => [ 'remarks', 'gradeRemarks' ],
                            'remarks', 
                            'gradeRemarks'
                        ]);
                }
            ])
            ->first()
            ?->examSchedule;

        return $exam_schedules;
    }

    /**
     * Get exam schedules of class subjects.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMarkSlip($request)
    {
        // Get markslips from exam class id
        $markslips = MarkSlip::where('exam_class_id', $request->exam_class_id)->get();

        // Store Remarks
        $exam_remarks = [];
        $exam_grade_remarks = [];

        foreach ($request->student_remarks as $key => $student_remarks) {
            $key = explode('-', $key);
            $section_id = $key[0];
            $subject_id = $key[1];

            // Check if markslip exists
            $markslip = $markslips->where('section_id', $section_id)->where('subject_id', $subject_id)->first();

            // Create markslip where not exits
            if (!$markslip && !empty($student_remarks)) {
                $markslip = MarkSlip::create([
                    'exam_class_id' => $request->exam_class_id,
                    'section_id' => $section_id,
                    'subject_id' => $subject_id
                ]);
            }

            foreach ($student_remarks as $student_session_id => $remarks) {

                // If the grades key are exists
                if (isset($remarks['grades'])) {
                    foreach ($remarks['grades'] as $exam_schedule_id => $grade_id) {
                        $exam_grade_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamSchedule',
                            'remarkable_id' => $exam_schedule_id,
                            'student_session_id' => $student_session_id,
                            'grade_id' => $grade_id,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the grading categories key are exists
                if (isset($remarks['grading_categories'])) {
                    foreach ($remarks['grading_categories'] as $exam_schedule_category_id => $grade_id) {
                        $exam_grade_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamScheduleCategory',
                            'remarkable_id' => $exam_schedule_category_id,
                            'student_session_id' => $student_session_id,
                            'grade_id' => $grade_id,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the categories key are exists
                if (isset($remarks['categories'])) {
                    foreach ($remarks['categories'] as $exam_schedule_category_id => $marks) {
                        $exam_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamScheduleCategory',
                            'remarkable_id' => $exam_schedule_category_id,
                            'student_session_id' => $student_session_id,
                            'remarks' => $marks,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }

                // If the marks key are exists
                if (isset($remarks['marks'])) {
                    foreach ($remarks['marks'] as $exam_schedule_id => $marks) {
                        $exam_remarks[] = [
                            'mark_slip_id' => $markslip->id,
                            'remarkable_type' => 'App\Models\ExamSchedule',
                            'remarkable_id' => $exam_schedule_id,
                            'student_session_id' => $student_session_id,
                            'remarks' => $marks,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ];
                    }
                }
            }
        }

        // Upsert Remarks
        ExamGradeRemarks::upsert($exam_grade_remarks, ['remarkable_type', 'remarkable_id', 'student_session_id'], ['grade_id', 'updated_by']);
        ExamRemarks::upsert($exam_remarks, ['remarkable_type', 'remarkable_id', 'student_session_id'], ['remarks', 'updated_by']);
    }
}