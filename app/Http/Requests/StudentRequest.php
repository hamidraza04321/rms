<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use App\Traits\FailedValidationTrait;
use App\Traits\CustomValidationTrait;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            'student.search' => $this->search(),
            'student.store' => $this->store(),
            'student.update' => $this->update(),
            'student.export' => $this->export(),
            'student.import' => ($this->method() == 'POST') ? $this->import() : [],
        };
    }

    /**
     * Validate Rules for Filter Student Request
     *
     * @return array
     */
    public function search()
    {
        return [
            'session_id' => $this->sessionRule('nullable'),
            'class_id' => $this->classRule('nullable'),
            'section_id' => $this->sectionRule($this->class_id, 'nullable'),
            'group_id' => $this->groupRule($this->class_id),
            'gender' => 'nullable|in:male,female',
            'is_active' => 'nullable|in:active,deactive',
            'action' => 'nullable|in:from_trash'
        ];
    }

    /**
     * Validate Rules for Export Student Request
     *
     * @return array
     */
    public function export()
    {
        return [
            'session_id' => $this->sessionRule(),
            'class_id' => $this->classRule(),
            'section_id' => $this->sectionRule($this->class_id),
            'group_id' => $this->groupRule($this->class_id),
            'gender' => 'nullable|in:male,female',
            'is_active' => 'nullable|in:active,deactive'
        ];
    }

    /**
     * Validate Rules for Import Student Request
     *
     * @return array
     */
    public function import()
    {
        return [
            'session_id' => $this->sessionRule(),
            'class_id' => $this->classRule('nullable'),
            'section_id' => $this->sectionRule($this->class_id, 'nullable'),
            'group_id' => $this->groupRule($this->class_id),
            'import_file' => 'required|mimes:csv,xlxs,xls'
        ];
    }

    /**
     * Validate Rules for Student Store Request
     *
     * @return array
     */
    public function store()
    {
        return [
            'student_image' => 'nullable|mimes:png,jpg,jpeg||max:500000',
            'admission_no' => 'required|max:20|unique:students,admission_no',
            'roll_no' => $this->uniqueRollNoRule($this->class_id),
            'class_id' => $this->classRule(),
            'section_id' => $this->sectionRule($this->class_id),
            'group_id' => $this->groupRule($this->class_id),
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|string|max:50',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'admission_date' => 'nullable|date',
            'father_image' => 'nullable|mimes:png,jpg,jpeg|max:500000',
            'father_name' => 'nullable|string|max:50',
            'father_email' => 'nullable|email',
            'father_cnic' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'father_occupation' => 'nullable|string|max:60',
            'mother_image' => 'nullable|mimes:png,jpg,jpeg|max:500000',
            'mother_name' => 'nullable|string|max:50',
            'mother_email' => 'nullable|email',
            'mother_cnic' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'mother_occupation' => 'nullable|string|max:60',
            'guardian_is' => 'required|in:father,mother,other',
            'guardian_image' => 'nullable|mimes:png,jpg,jpeg|max:500000',
            'guardian_name' => 'required|string|max:50',
            'guardian_email' => 'nullable|email',
            'guardian_cnic' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_relation' => 'nullable|string|max:60',
            'guardian_occupation' => 'nullable|string|max:60',
            'current_address' => 'nullable',
            'permenent_address' => 'nullable'
        ];
    }

    /**
     * Validate Rules for Student Update Request
     *
     * @return array
     */
    public function update()
    {
        return [
            'student_image' => 'nullable|mimes:png,jpg,jpeg',
            'admission_no' => 'required|max:20|unique:students,admission_no,'.$this->student,
            'roll_no' => $this->uniqueRollNoRule($this->class_id, $this->student),
            'class_id' => $this->classRule(),
            'section_id' => $this->sectionRule($this->class_id),
            'group_id' => $this->groupRule($this->class_id),
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|string|max:50',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'admission_date' => 'nullable|date',
            'father_image' => 'nullable|mimes:png,jpg,jpeg',
            'father_name' => 'nullable|string|max:50',
            'father_email' => 'nullable|email',
            'father_cnic' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'father_occupation' => 'nullable|string|max:60',
            'mother_image' => 'nullable|mimes:png,jpg,jpeg',
            'mother_name' => 'nullable|string|max:50',
            'mother_email' => 'nullable|email',
            'mother_cnic' => 'nullable|string|max:20',
            'mother_phone' => 'nullable|string|max:20',
            'mother_occupation' => 'nullable|string|max:60',
            'guardian_is' => 'required|in:father,mother,other',
            'guardian_image' => 'nullable|mimes:png,jpg,jpeg',
            'guardian_name' => 'required|string|max:50',
            'guardian_email' => 'nullable|email',
            'guardian_cnic' => 'nullable|string|max:20',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_relation' => 'nullable|string|max:60',
            'guardian_occupation' => 'nullable|string|max:60',
            'current_address' => 'nullable',
            'permenent_address' => 'nullable'
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation()
    {
        if (in_array(Route::currentRouteName(), [ 'student.store', 'student.update' ])) {
            $this->merge([
                'dob' => date('Y-m-d', strtotime($this->input('dob'))),
                'admission_date' => date('Y-m-d', strtotime($this->input('admission_date'))),
            ]);
        }
    }
}
