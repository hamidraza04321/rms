<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use App\Traits\CustomValidationTrait;
use Illuminate\Validation\Rule;

class ClassRequest extends FormRequest
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
            'class.store' => $this->store(),
            'class.update' => $this->update(),
            'get.class.sections.and.groups' => $this->getClassSectionsAndGroups(),
            'get.class.sections.groups.and.subjects' => $this->getClassSectionsGroupsAndSubjects()
        };
    }

    /**
     * Validate Rules for store Request
     */
    public function store()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('classes')->whereNull('deleted_at') ],
            'section_id.*' => 'required|exists:sections,id',
            'group_id.*' => 'nullable|exists:groups,id',
            'subject_id.*' => 'required|exists:subjects,id'
        ];
    }

    /**
     * Validate Rules for update Request
     */
    public function update()
    {
        return [
            'name' => [ 'required', 'string', Rule::unique('classes')->whereNull('deleted_at')->ignore($this->class) ],
            'section_id.*' => 'required|exists:sections,id',
            'group_id.*' => 'nullable|exists:groups,id',
            'subject_id.*' => 'required|exists:subjects,id'
        ];
    }

    /**
     * Validate Rules for get class sections and groups Request
     */
    public function getClassSectionsAndGroups()
    {
        return [
            'class_id' => $this->classRule()
        ];
    }

    /**
     * Validate Rules for get class sections, groups and subjects Request
     */
    public function getClassSectionsGroupsAndSubjects()
    {
        return [
            'class_id' => $this->classRule()
        ];
    }
}
