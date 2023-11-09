<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultCardRequest;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Group;
use App\Models\StudentSession;

class ResultCardController extends Controller
{
	/**
	 * Print result card
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function print()
    {
    	$sessions = Session::get();
    	$classes = Classes::get();

    	$data = [
    		'sessions' => $sessions,
    		'classes' => $classes,
            'page_title' => 'Print Result Card',
            'menu' => 'Result Card'
        ];

    	return view('result-card.print', compact('data'));
    }

    /**
     * Get search student table
     *
     * @param  \App\Http\Requests\ResultCardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function searchStudent(ResultCardRequest $request)
    {
        $session = Session::find($request->session_id, [ 'id', 'name' ]);
        $class = Classes::find($request->class_id, [ 'id', 'name' ]);
        $section = Section::find($request->section_id, [ 'id', 'name' ]);
        $group = ($request->group_id) ? Group::find($request->group_id, [ 'id', 'name' ]) : null;

        $students = StudentSession::where($request->validated())
            ->with([
                'student' => function($query) {
                    $query->select(
                        'id',
                        'admission_no',
                        'roll_no',
                        'first_name',
                        'last_name',
                        'father_name'
                    );
                }
            ])
            ->get()
            ->map(function($student_session){
                $student_session->student->student_session_id = $student_session->id;
                return $student_session;
            })
            ->pluck('student');

        $data = [
            'session' => $session,
            'class' => $class,
            'section' => $section,
            'group' => $group,
            'students' => $students
        ];

        $view = view('result-card.get-search-students-table', compact('data'))->render();
        return response()->success([ 'view' => $view ]);
    }

    /**
	 * Result card preset
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function preset()
    {
    	$data = [
            'page_title' => 'Preset Selection',
            'menu' => 'Result Card'
        ];

    	return view('result-card.preset', compact('data'));
    }
}
