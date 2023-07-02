<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamScheduleRequest;
use App\Models\ExamSchedule;
use App\Models\ExamScheduleCategory;
use App\Models\Exam;
use App\Models\ExamClass;
use App\Models\Session;
use App\Models\ClassSubject;

class ExamScheduleController extends Controller
{
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
        // Get Exam Class
        $where = $request->except('session_id', 'exam_schedule');
        $exam_class_id = ExamClass::where($where)->value('id');

        if ($exam_class_id) {
            // Store Creatings Exam Schedule Categories 
            $creating_categories = [];

            foreach ($request->exam_schedule as $subject_id => $exam_schedule) {
                // Where If Record Exists
                $where = [
                    'exam_class_id' => $exam_class_id,
                    'subject_id' => $subject_id
                ];

                $data = [
                    'date' => date('Y-m-d', strtotime($exam_schedule['date'])),
                    'type' => $exam_schedule['type'],
                    // If Exam Schedule Type is Marks
                    'marks' => ($exam_schedule['type'] == 'marks') ? $exam_schedule['marks'] : null
                ];

                // If Exam Schedule Exists Update it Otherwise create.
                $schedule = ExamSchedule::updateOrCreate($where, $data);

                // If Exam Schedule Categories
                if ($exam_schedule['type'] == 'categories') {
                    $categories = $schedule->categories; // Get From Exam Schedule Category Relation
                    $undelete_category_ids = []; // Store Un Delete Category

                    foreach ($exam_schedule['categories'] as $categoryKey => $category) {
                        $data = [
                            'exam_schedule_id' => $schedule->id,
                            'name' => $category['name'],
                            'marks' => (isset($category['marks'])) ? $category['marks'] : null,
                            'is_grade' => isset($category['is_grade']) ? 1 : 0
                        ];

                        // If Category Id exists
                        if (isset($category['category_id'])) {
                            // Get category from exam schedule categories and update it
                            $update_category = $categories->where('id', $category['category_id'])->first();
                            $update_category->update($data);
                            // Save in to un delete ids
                            $undelete_category_ids[] = $update_category->id;
                        } else {
                            // When category_id key not exists create category
                            $create_category = ExamScheduleCategory::create($data);
                            // Save in to un delete ids
                            $undelete_category_ids[] = $create_category->id;
                            // Save creating categories
                            $creating_categories[] = [
                                'category_id' => $create_category->id,
                                'key' => $categoryKey, // From Which key of category 
                                'subject_id' => $subject_id 
                            ];
                        }
                    }

                    // Delete Categories
                    $categories->whereNotIn('id', $undelete_category_ids)->each->delete();

                } elseif($schedule->categories()) {
                    // Delete All Previous Saved Categories
                    $schedule->categories()->delete();
                }
            }

            return response()->success([
                'creating_categories' => $creating_categories,
                'message' => 'Exam Schedule Saved Successfully!'
            ]);
        }

        // Exam Class Not Exists
        $class = Classes::find($request->class_id)->name;
        return response()->errorMessage("The Class ( {$class} ) does'nt exists in exam.");
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
        //
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
