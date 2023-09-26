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
            'search.markslip' => $this->search(),
            'get.markslip' => $this->getMarkSlip(),
            'save.markslip' => $this->save(),
            'get.tabulation.sheet' => $this->getTabulationSheet()
        };
    }

    /**
     * Validate rules for search markslip request
     */
    public function search()
    {
        return [
            'session_id' => $this->sessionRule('nullable'),
            'exam_id' => $this->examRule($this->session_id, 'nullable'),
            'class_id' => $this->classRule('nullable'),
            'group_id' => $this->groupRule($this->class_id),
            'section_id' => $this->sectionRule($this->class_id, 'nullable'),
            'subject_id' => $this->subjectRule($this->class_id, 'nullable')
        ];
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
            'exam_class_id' => 'required|exists:exam_classes,id',
            'student_remarks' => 'required|array'
        ];
    }

    /**
     * Validate rules for get tabulation sheet
     */
    public function getTabulationSheet()
    {
        return [
            'session_id' => $this->sessionRule(),
            'exam_id' => $this->examRule($this->session_id),
            'class_id' => $this->classRule(),
            'group_id' => $this->groupRule($this->class_id),
            'section_id' => $this->sectionRule($this->class_id)
        ];
    }
}
