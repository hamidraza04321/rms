<?php

namespace App\Traits;

trait ActiveRecords {

	public function scopeActive($query)
	{
		return $query->where($this->getTable() . '.is_active', 1);
	}
}