<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkSlipRequest;
use App\Services\MarkSlipService;
use App\Services\TabulationService;
use App\Models\ExamSchedule;
use App\Models\ExamScheduleCategory;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\MarkSlip;
use Auth;
use DB;

class MarkSlipController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->middleware('permission:view-mark-slip', [ 'only' => [ 'index', 'search' ] ]);
        $this->middleware('permission:create-mark-slip', [ 'only' => [ 'create', 'getMarkSlip', 'save' ]]);
        $this->middleware('permission:edit-mark-slip', [ 'only' => [ 'edit', 'save' ]]);
        $this->middleware('permission:print-mark-slip', [ 'only' => [ 'print' ]]);
        $this->middleware('permission:delete-mark-slip', [ 'only' => [ 'destroy' ]]);
        $this->middleware('permission:tabulation-sheet', [ 'only' => [ 'tabulation', 'getTabulationSheet' ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::get();
        $exams = Exam::where('session_id', $this->current_session_id)->get();
        $markslips = MarkSlip::with([
            'examClass' => [ 
                'exam' => [ 'session' ], 
                'class', 
                'group' 
            ], 
            'subject', 
            'section' 
        ])->get();

        $data = [
            'sessions' => $sessions,
            'exams' => $exams,
            'markslips' => $markslips,
            'page_title' => 'Manage Mark Slip',
            'menu' => 'Mark Slip'
        ];

        return view('markslip.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(MarkSlipRequest $request)
    {
        $markslips = MarkSlip::with([
                'examClass' => [ 
                    'exam' => [ 'session' ], 
                    'class', 
                    'group' 
                ], 
                'subject', 
                'section' 
            ])->when($request->session_id, function($query) use($request) {
                if ($request->exam_id) {
                    $query->whereHas('examClass', function($query) use($request){
                        $query->where('exam_id', $request->exam_id)
                            ->whereHas('exam', fn($query) => $query->where('session_id', $request->session_id))
                            ->when($request->class_id, fn($query) => $query->where('class_id', $request->class_id));
                    });
                } else {
                    $query->whereHas('examClass', function($query) use($request){
                        $query->whereHas('exam', fn($query) => $query->where('session_id', $request->session_id));
                    });
                }
            })
            ->when($request->section_id, fn($query) => $query->where('section_id', $request->section_id))
            ->when($request->subject_id, fn($query) => $query->where('subject_id', $request->subject_id))
            ->get()
            ->map(function($markslip){
                $markslip->session = $markslip->examClass->exam->session->name;
                $markslip->exam = $markslip->examClass->exam->name;
                $markslip->class = $markslip->examClass->class->name;
                $markslip->group = $markslip->examClass->group?->name ?? '-';

                return $markslip;
            });

        return response()->json($markslips);
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
        $view = (new MarkSlipService)->getMarkSlipView($request);
        return response()->success([ 'view' => $view ]);
    }

    /**
     * Save Markslip.
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function save(MarkSlipRequest $request)
    {
        try {
            DB::transaction(function() use($request) {
                (new MarkSlipService)->saveMarkSlip($request);
            });

            return response()->successMessage('Markslip Saved Successfully!');
        } catch(\Exception $e) {
            return response()->errorMessage('Check your input fields and try again!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $markslip = MarkSlip::with('examClass.exam')->findOrFail($id);
        
        $ids = new \stdClass;
        $ids->session_id = $markslip->examClass->exam->session_id;
        $ids->exam_id = $markslip->examClass->exam_id;
        $ids->class_id = $markslip->examClass->class_id;
        $ids->group_id = $markslip->examClass->group_id;
        $ids->section_id = [ $markslip->section_id ];
        $ids->subject_id = [ $markslip->subject_id ];
        $markslip = (new MarkSlipService)->getMarkSlipView($ids);

        $data = [
            'markslip' => $markslip,
            'page_title' => 'Edit Mark Slip',
            'menu' => 'Mark Slip'
        ];

        return view('markslip.edit', compact('data'));
    }

    /**
     * Print markslip
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $markslip = MarkSlip::with('examClass.exam')->findOrFail($id);

        $ids = new \stdClass;
        $ids->session_id = $markslip->examClass->exam->session_id;
        $ids->exam_id = $markslip->examClass->exam_id;
        $ids->class_id = $markslip->examClass->class_id;
        $ids->group_id = $markslip->examClass->group_id;
        $ids->section_id = [ $markslip->section_id ];
        $ids->subject_id = [ $markslip->subject_id ];
        $markslip = (new MarkSlipService)->getMarkSlipView($ids, false)[0];

        $data = [
            'markslip' => $markslip,
            'page_title' => 'Print Mark Slip'
        ];

        return view('markslip.print', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $markslip = MarkSlip::find($id);

        if ($markslip) {
            // Delete Marks
            $markslip->examRemarks()->delete();
            $markslip->examGradeRemarks()->delete();
            $markslip->delete();

            return response()->successMessage('Markslip Deleted Successfully !');
        }

        return response()->errorMessage('Markslip Not Found !');
    }

    /**
     * Markslip tabulation sheet
     *
     * @return \Illuminate\Http\Response
     */
    public function tabulation()
    {
        $sessions = Session::get();
        $exams = Exam::where('session_id', $this->current_session_id)->get();

        $data = [
            'sessions' => $sessions,
            'exams' => $exams,
            'page_title' => 'Tabulation Sheet',
            'menu' => 'Mark Slip'
        ];

        return view('markslip.tabulation', compact('data'));
    }

    /**
     * Get markslip tabulation sheet
     *
     * @param \App\Http\Requests\MarkSlipRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getTabulationSheet(MarkSlipRequest $request)
    {
        $view = (new TabulationService)->getTabulationSheetView($request);
        return response()->success([ 'view' => $view ]);
    }
}
