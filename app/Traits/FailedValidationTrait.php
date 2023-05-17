<?php

namespace App\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

trait FailedValidationTrait
{
	/**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->errors($validator->errors())); 
    }
}