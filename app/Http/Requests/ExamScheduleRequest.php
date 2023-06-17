<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Traits\CustomValidationTrait;

class ExamScheduleRequest extends FormRequest
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
            'get.exam.schedule.table' => $this->getExamScheduleTable(),
            'exam-schedule.save' => $this->save()
        };
    }

    /**
     * Validate Rules for Get Exam Schedule Table Request
     */
    public function getExamScheduleTable()
    {
        return [
            'session_id' => $this->sessionRule(),
            'exam_id' => $this->examRule(),
            'class_id' => $this->classRule(),
            'group_id' => $this->groupRule($this->class_id)
        ];
    }

    /**
     * Validate Rules for Save Exam Schedule Request
     */
    public function save()
    {
        return [
            'session_id' => $this->sessionRule(),
            'exam_id' => $this->examRule(),
            'class_id' => $this->classRule(),
            'group_id' => $this->groupRule($this->class_id),
            'exam_schedule.*' => 'required'
        ];
    }
}
