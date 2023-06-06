<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Settings\GeneralSettings;

class Controller extends BaseController
{
	public function __construct()
	{
		$this->current_session_id = (new GeneralSettings)->current_session_id;
	}

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
