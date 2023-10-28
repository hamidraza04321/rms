<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Traits\CustomValidationTrait;

class ExamRequest extends FormRequest
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
            'exam.store' => $this->store(),
            'exam.update' => $this->update(),
            'get.exams.by.session' => $this->getExamsBySession(),
            'get.exam.classes' => $this->getExamClasses()
        };
    }

    /**
     * Validate Rules for store Request
     */
    public function store()
    {
        return [
            'session_id' => $this->sessionRule(),
            'name' => $this->examNameRule($this->session_id),
            'class_id.*' => 'required|exists:classes,id',
            'datesheet_note' => 'nullable|string',
            'description' => 'nullable'
        ];
    }

    /**
     * Validate Rules for update Request
     */
    public function update()
    {
        return [
            'session_id' => $this->sessionRule(),
            'name' => $this->examNameRule($this->session_id, $this->exam),
            'class_id.*' => 'required|exists:classes,id',
            'datesheet_note' => 'nullable|string',
            'description' => 'nullable'
        ];
    }

    /**
     * Validate Rules for Get Exams By Session Request
     */
    public function getExamsBySession()
    {
        return [
            'session_id' => $this->sessionRule()
        ];
    }

    /**
     * Validate Rules for Get Exam Classes Request
     */
    public function getExamClasses()
    {
        return [
            'exam_id' => $this->examRule()
        ];
    }
}
