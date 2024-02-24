<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use FailedValidationTrait;

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
            'name' => [ 'required', 'string', 'max:60', Rule::unique('users')->whereNull('deleted_at') ],
            'username' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at') ],
            'email' => [ 'required', 'string', 'email', Rule::unique('users')->whereNull('deleted_at') ],
            'password' => 'required|min:6|string',
            'phone_no' => 'nullable|string',
            'designation' => 'nullable|string',
            'image' => 'nullable|image',
            'age' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'education' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'skills' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'role_id' => 'required|exists:roles,id',
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
            'name' => [ 'required', 'string', 'max:60', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user) ],
            'username' => [ 'required', 'string', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user) ],
            'email' => [ 'required', 'string', 'email', Rule::unique('users')->whereNull('deleted_at')->ignore($this->user) ],
            'phone_no' => 'nullable|string',
            'designation' => 'nullable|string',
            'image' => 'nullable|image',
            'age' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'education' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'skills' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'password' => 'nullable|min:6|string',
            'role_id' => 'required|exists:roles,id',
            'class_id.*' => 'nullable|exists:classes,id',
            'class_section_id.*' => 'nullable|exists:class_sections,id',
            'class_subject_id.*' => 'nullable|exists:class_subjects,id',
            'class_group_id.*' => 'nullable|exists:class_groups,id'
        ];
    }
}
