<?php

namespace App\Traits;
use App\Models\Scopes\ActiveScope;
use App\Settings\GeneralSettings;

trait CurrentSessionTrait
{
	public function scopeCurrentSession($query)
	{
		$current_session_id = (new GeneralSettings)->current_session_id;
		return $query->where($this->getTable() . '.session_id', $current_session_id);
	}
}