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
     * Get result cards
     *
     * @param  \App\Http\Requests\ResultCardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getResultCards(ResultCardRequest $request)
    {
        return response()->json([ 'view' => $view ]);
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
