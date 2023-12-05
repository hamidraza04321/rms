<?php

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use App\Traits\CustomValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ResultCardRequest extends FormRequest
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
            'get.result.cards' => $this->getResultCards()
        };
    }

    /**
     * Validate Rules for get result card Request
     */
    public function getResultCards()
    {
        return [
            'session_id' => $this->sessionRule(),
            'class_id' => $this->classRule(),
            'section_id' => $this->sectionRule($this->class_id),
            'group_id' => $this->groupRule($this->class_id)
        ];
    }
}
