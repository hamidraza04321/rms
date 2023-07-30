<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use App\Traits\CustomValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class MarkSlipRequest extends FormRequest
{
    use FailedValidationTrait,
        CustomValidationTrait;

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
            'get.markslip' => $this->getMarkSlip(),
            'save.markslip' => $this->save()
        };
    }

    /**
     * Validate rules for get markslip request
     */
    public function getMarkSlip()
    {
        return [
            'session_id' => $this->sessionRule(),
            'exam_id' => $this->examRule($this->session_id),
            'class_id' => $this->classRule(),
            'group_id' => $this->groupRule($this->class_id),
            'section_id.*' => 'required|exists:sections,id',
            'subject_id.*' => 'required|exists:subjects,id'
        ];
    }

    /**
     * Validate rules for save markslip request
     */
    public function save()
    {
        return [
            'student_marks' => 'required|array'
        ];
    }
}
