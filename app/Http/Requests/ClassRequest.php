<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ClassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match(Route::currentRouteName()) {
            'class.store' => $this->store(),
            'class.update' => $this->update()
        };
    }

    /**
     * Validate Rules for store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('classes')->whereNull('deleted_at') ]
        ];
    }

    /**
     * Validate Rules for update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('classes')->whereNull('deleted_at')->ignore($this->class) ]
        ];
    }

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
