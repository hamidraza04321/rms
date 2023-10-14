<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamScheduleRequest;
use App\Models\ExamSchedule;
use App\Models\ExamScheduleCategory;
use App\Models\Exam;
use App\Models\ExamClass;
use App\Models\Session;
use App\Models\ClassSubject;
use App\Models\Subject;
use DB;

class ExamScheduleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-exam-schedule', [ 'only' => 'index' ]);
        $this->middleware('permission:create-exam-schedule', [ 'only' => [ 'create', 'save' ]]);
        $this->middleware('permission:edit-exam-schedule', [ 'only' => [ 'save' ]]);
        $this->middleware('permission:delete-exam-schedule', [ 'only' => [ 'destroy' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam_schedules = ExamClass::has('examSchedule')
            ->with('exam', 'class', 'examSchedule')
            ->get();

        $data = [
            'exam_schedules' => $exam_schedules,
            'page_title' => 'Manage Exam Schedules',
            'menu' => 'Exam Schedule'
        ];

        return view('exam-schedule.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = Session::get();
        $exams = Exam::currentSession()->get();

        $data = [
            'exams' => $exams,
            'sessions' => $sessions,
            'page_title' => 'Create Exam Schedule',
            'menu' => 'Exam Schedule'
        ];

        return view('exam-schedule.create', compact('data'));
    }

    /**
     * Save Exam Schedule.
     *
     * @param  \App\Http\Requests\ExamScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function save(ExamScheduleRequest $request)
    {
        $where = $request->except('session_id', 'exam_schedule');
        $exam_class_id = ExamClass::where($where)->value('id');
        $subject_ids = collect($request->exam_schedule)->keys()->all();
        $subjects = Subject::whereIn('id', $subject_ids)->get(['id']);

        // If Exam Class Not Exists
        if (!$exam_class_id) {
            $class = Classes::find($request->class_id)->name;
            return response()->errorMessage("The Class ( {$class} ) does'nt exists in exam.");
        }

        // Store Creatings Exam Schedule Categories
        $creating_categories = [];

        DB::transaction(function() use($request, $subjects, $exam_class_id, &$creating_categories) {

            foreach ($request->exam_schedule as $subject_id => $exam_schedule) {

                // If subject not exists
                $subject = $subjects->where('id', $subject_id);
                if ($subject->isEmpty()) {
                    continue;
                }

                $schedule = ExamSchedule::updateOrCreate(
                    [
                        'exam_class_id' => $exam_class_id,
                        'subject_id' => $subject_id
                    ], [
                        'date' => date('Y-m-d', strtotime($exam_schedule['date'])),
                        'type' => $exam_schedule['type'],
                        'marks' => ($exam_schedule['type'] == 'marks') ? $exam_schedule['marks'] : null
                    ]);

                if ($exam_schedule['type'] == 'categories') {
                    $categories = $schedule->categories;
                    $undelete_category_ids = [];

                    foreach ($exam_schedule['categories'] as $categoryKey => $category) {
                        $data = [
                            'exam_schedule_id' => $schedule->id,
                            'name' => $category['name'],
                            'marks' => (isset($category['marks'])) ? $category['marks'] : null,
                            'is_grade' => isset($category['is_grade']) ? 1 : 0
                        ];

                        // If Category Id exists update it
                        if (isset($category['category_id'])) {
                            $update_category = $categories->where('id', $category['category_id'])->first();
                            $update_category->update($data);
                            $undelete_category_ids[] = $update_category->id;
                            continue;
                        }
                        
                        // When category_id key not exists create category
                        $create_category = ExamScheduleCategory::create($data);
                        $undelete_category_ids[] = $create_category->id;
                        $creating_categories[] = [
                            'category_id' => $create_category->id,
                            'key' => $categoryKey,
                            'subject_id' => $subject_id 
                        ];
                    }

                    $categories->whereNotIn('id', $undelete_category_ids)->each->delete();
                    continue;
                }

                // Delete previous saved catgories
                if ($schedule->categories()) {
                    $schedule->categories()->delete();
                }
            }
        });

        return response()->success([
            'creating_categories' => $creating_categories,
            'message' => 'Exam Schedule Saved Successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam_class = ExamClass::find($id);

        if ($exam_class) {
            $exam_class->examSchedule()->delete();
            return response()->successMessage('Exam Schedule Deleted Successfully!');
        }

        return response()->errorMessage('Exam Schedule not Found!');
    }

    /**
     * Get Exam Schedule Table.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Http\Requests\ExamScheduleRequest  $request
     */
    public function getExamScheduleTable(ExamScheduleRequest $request)
    {
        // Get Exam Class
        $where = $request->except('session_id');
        $exam_class_id = ExamClass::where($where)->value('id');

        if ($exam_class_id) {
            // Get Exam Schedules
            $exam_schedules = ExamSchedule::where('exam_class_id', $exam_class_id)
                ->with('categories')
                ->get();

            // Get Class Subjects
            $subjects = ClassSubject::where('class_id', $request->class_id)
                ->with('subject')
                ->get()
                ->pluck('subject')
                ->map(function($subject) use($exam_schedules) {
                    $subject['exam_schedule'] = $exam_schedules->where('subject_id', $subject->id)->first();
                    return $subject;
                });

            $data = [
                'subjects' => $subjects,
                'exam_schedules' => $exam_schedules,
                'session_id' => $request->session_id,
                'exam_id' => $request->exam_id,
                'class_id' => $request->class_id,
                'group_id' => $request->group_id
            ];

            $view = view('exam-schedule.get-exam-schedule-table', compact('data'))->render();

            return response()->success([
                'view' => $view
            ]);
        }

        // Exam Class Not Exists
        $class = Classes::find($request->class_id)->name;
        return response()->errorMessage("The Class ( {$class} ) does'nt exists in exam.");
    }
}
