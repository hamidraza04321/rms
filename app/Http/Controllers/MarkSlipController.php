<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkSlipRequest;
use App\Models\Session;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\ExamClass;
use App\Services\MarkSlipService;

class MarkSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'page_title' => 'Manage Mark Slip',
            'menu' => 'Mark Slip'
        ];

        return view('markslip.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = Session::get();
        $exams = Exam::where('session_id', $this->current_session_id)->get();

        $data = [
            'sessions' => $sessions,
            'exams' => $exams,
            'page_title' => 'Create Mark Slip',
            'menu' => 'Mark Slip'
        ];

        return view('markslip.create', compact('data'));
    }

    /**
     * Get Mark Slip.
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */    
    public function getMarkSlip(MarkSlipRequest $request)
    {
        $markslips = (new MarkSlipService)->getMarkSlips($request);
        
        if (!count($markslips)) {
            $class = Classes::find($request->class_id);
            return response()->errorMessage("The exam schedule for class ( $class->name ) is not prepared !");
        }

        $view = view('markslip.get-markslip', compact('markslips'))->render();
        return response()->success([
            'view' => $view
        ]);
    }

    /**
     * Save Markslip.
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function save(MarkSlipRequest $request)
    {
        // Four type of remarks
        $grades = [];
        $marks = [];
        $categories = [];
        $grading_categories = [];

        foreach ($request->student_remarks as $student_id => $remarks) {
            
            // If the grades key are exists
            if (isset($remarks['grades'])) {
                foreach ($remarks['grades'] as $exam_schedule_id => $grade_id) {
                    $grades[] = [
                        'student_id' => $student_id,
                        ''
                    ];
                }
            }

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarkSlipRequest $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
}
