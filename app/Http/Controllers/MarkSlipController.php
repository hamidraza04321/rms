<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkSlipRequest;
use App\Models\Session;
use App\Models\Exam;

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
        //
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
