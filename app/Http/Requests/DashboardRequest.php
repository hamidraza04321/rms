<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
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
            'dashboard.profile.update' => $this->updateProfile()
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
            //
        ];
    }
}
