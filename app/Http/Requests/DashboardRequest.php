<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class DashboardRequest extends FormRequest
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
            'dashboard.get.attendance.graph.data' => $this->getAttendanceGraphData(),
            'dashboard.profile.update' => $this->updateProfile(),
            'dashboard.profile.change.password' => $this->changePassword()
        };
    }

    /**
     * Validate Rules for get attendance graph Request
     */
    public function getAttendanceGraphData()
    {
        return [
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ];
    }

    /**
     * Validate Rules for update profile Request
     */
    public function updateProfile()
    {
        return [
            'name' => [ 'required', 'string', 'max:60', Rule::unique('users')->whereNull('deleted_at')->ignore(auth()->id()) ],
            'username' => [ 'nullable', 'string', Rule::unique('users')->whereNull('deleted_at')->ignore(auth()->id()) ],
            'email' => [ 'nullable', 'string', 'email', Rule::unique('users')->whereNull('deleted_at')->ignore(auth()->id()) ],
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
            'youtube_link' => 'nullable|url'
        ];
    }

    /**
     * Validate Rules for change password Request
     */
    public function changePassword()
    {
        return [
            'old_password' => [ 'required', new MatchOldPassword() ],
            'new_password' => 'required|min:6',
            'retype_password' => 'required|same:new_password'
        ];
    }
}
