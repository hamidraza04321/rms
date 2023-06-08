<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class AttendanceStatusRequest extends FormRequest
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
            'attendance-status.store' => $this->store(),
            'attendance-status.update' => $this->update()
        };
    }

    /**
     * Validate Rules for Attendance Status Store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('attendance_statuses')->whereNull('deleted_at') ],
            'short_code' => [ 'required', 'string', 'max:5', Rule::unique('attendance_statuses')->whereNull('deleted_at') ],
            'show_in_result_card' => 'nullable|in:1'
        ];
    }

    /**
     * Validate Rules for Attendance Status Update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', 'max:30', Rule::unique('attendance_statuses')->whereNull('deleted_at')->ignore($this->attendance_status) ],
            'short_code' => [ 'required', 'string', 'max:5', Rule::unique('attendance_statuses')->whereNull('deleted_at')->ignore($this->attendance_status) ],
            'show_in_result_card' => 'nullable|in:1'
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        if (Route::currentRouteName() == 'attendance-status.update') {
            $this->merge([
                'show_in_result_card' => ($this->input('show_in_result_card') == 1) ? 1 : 0
            ]);
        }
    }
}
