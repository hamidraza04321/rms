<?php

namespace App\Traits;
use App\Models\Scopes\ActiveScope;

trait ActiveScopeTrait
{
	/**
     * The "booted" method of the model.
     *
     * @return void
     */
	public static function bootActiveScopeTrait()
	{
	    static::addGlobalScope(new ActiveScope);
	}
}