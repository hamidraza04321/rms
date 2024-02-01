<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultCardRequest;
use App\Services\GenerateResultCardService;
use App\Models\StudentSession;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Group;
use App\Models\Exam;

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
    	$exams = Exam::where('session_id', $this->current_session_id)->get();

    	$data = [
    		'sessions' => $sessions,
            'exams' => $exams,
            'page_title' => 'Print Result Card',
            'menu' => 'Result Card'
        ];

    	return view('result-card.print', compact('data'));
    }

    /**
     * Get result cards
     *
     * @param  \App\Http\Requests\ResultCardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getResultCards(ResultCardRequest $request)
    {
        $view = (new GenerateResultCardService($request))->getResultCardsView();
        return response()->success([ 'view' => $view ]);
    }
}
