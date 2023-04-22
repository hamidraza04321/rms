<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'user.store' => $this->store(),
            'user.update' => $this->update()
        };
    }

    /**
     * Validate Rules for Store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at') ],
            'email' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at') ],
            'password' => 'required|min:6|string',
            'role_id' => 'required|exists:roles,id|not_in:1', // Ignore Super Admin
            'class_id.*' => 'nullable|exists:classes,id',
            'class_section_id.*' => 'nullable|exists:class_sections,id',
            'class_subject_id.*' => 'nullable|exists:class_subjects,id',
            'class_group_id.*' => 'nullable|exists:class_groups,id'
        ];
    }

    /**
     * Validate Rules for Update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user) ],
            'email' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user) ],
            'password' => 'nullable|min:6|string',
            'role_id' => 'required|exists:roles,id|not_in:1', // Ignore Super Admin
            'class_id.*' => 'nullable|exists:classes,id',
            'class_section_id.*' => 'nullable|exists:class_sections,id',
            'class_subject_id.*' => 'nullable|exists:class_subjects,id',
            'class_group_id.*' => 'nullable|exists:class_groups,id'
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
