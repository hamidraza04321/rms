<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'role.store' => $this->store(),
            'role.update' => $this->update()
        };
    }

    /**
     * Validate Rules for Store Role Request
     */
    public function store()
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ];
    }

    /**
     * Validate Rules for Update Role Request
     */
    public function update()
    {
        return [
            'name' => 'required|string|unique:roles,name,'.$this->role,
            'permissions' => 'required|array'
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
