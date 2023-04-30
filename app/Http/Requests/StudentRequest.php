<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
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
            'student.export' => $this->export()
        };
    }

    /**
     * Validate Rules for Filter Student Request
     */
    public function search()
    {
        return [
            'class_id' => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'group_id' => 'nullable|exists:groups,id',
            'gender' => 'nullable|in:male,female',
            'is_active' => 'nullable|in:active,deactive'
        ];
    }

    /**
     * Validate Rules for Export Student Request
     */
    public function export()
    {
        return [
            'class_id' => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'group_id' => 'nullable|exists:groups,id',
            'gender' => 'nullable|in:male,female',
            'is_active' => 'nullable|in:active,deactive'
        ];
    }

    /**
     * Validate Rules for Student Store Request
     */
    public function store()
    {
        return [
            'student_image' => 'nullable|mimes:png,jpg,jpeg',
            'admission_no' => 'required|string|max:20|unique:students,admission_no',
            'roll_no' => 'required|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'group_id' => 'nullable|exists:groups,id',
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
     * Validate Rules for Student Update Request
     */
    public function update()
    {
        return [
            'student_image' => 'nullable|mimes:png,jpg,jpeg',
            'admission_no' => 'required|string|max:20|unique:students,admission_no,'.$this->student,
            'roll_no' => 'required|string|max:20',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'group_id' => 'nullable|exists:groups,id',
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->errors($validator->errors())); 
    }
}
