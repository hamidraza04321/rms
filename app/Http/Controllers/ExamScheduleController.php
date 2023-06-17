<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamScheduleRequest;
use App\Models\ExamSchedule;
use App\Models\Exam;
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
        //
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
        dd($request->all());
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
        $subjects = ClassSubject::where('class_id', $request->class_id)
            ->with('subject')
            ->get()
            ->pluck('subject');

        $data = [
            'subjects' => $subjects,
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
}
