<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Settings\GeneralSettings;

class Controller extends BaseController
{
	public function __construct(GeneralSettings $settings)
	{
		$this->current_session_id = $settings->current_session_id;
	}

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
