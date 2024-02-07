<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Traits\CustomValidationTrait;

class GradeRequest extends FormRequest
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
            'grade.store' => $this->store(),
            'grade.update' => $this->update()
        };
    }

    /**
     * Validate Rules for store grade Request
     */
    public function store()
    {
        return [
            'is_default' => 'required|in:0,1',
            'class_id' => $this->classRule('required_if:is_default,0'),
            'grade' => [ 'required', 'max:4', Rule::unique('grades')->whereNull('deleted_at')->where('class_id', $this->class_id) ],
            'percentage_from' => 'required|numeric',
            'percentage_to' => 'required|numeric|gt:percentage_from',
            'remarks' => 'required|max:120',
            'color' => 'required|string',
            'is_fail' => 'required|in:0,1'
        ];
    }

    /**
     * Validate Rules for update grade Request
     */
    public function update()
    {
        return [
            'is_default' => 'required|in:0,1',
            'class_id' => $this->classRule('required_if:is_default,0'),
            'grade' => [ 'required', 'max:4', Rule::unique('grades')->whereNull('deleted_at')->where('class_id', $this->class_id)->ignore(Route::getCurrentRoute()->parameters['grade']) ],
            'percentage_from' => 'required|numeric',
            'percentage_to' => 'required|numeric|gt:percentage_from',
            'remarks' => 'required|max:120',
            'color' => 'required|string',
            'is_fail' => 'required|in:0,1'
        ];
    }
}
