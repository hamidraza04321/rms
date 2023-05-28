<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\StudentSession;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use App\Traits\CustomValidationTrait;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable, CustomValidationTrait;

    private $rows = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        ++$this->rows;

        $row['dob'] = $row['date_of_birth'];
        unset($row['date_of_birth']);

        $student = Student::create($row);

        StudentSession::create([
            'student_id' => $student->id,
            'session_id' => $this->request['session_id'],
            'class_id' => $this->request['class_id'],
            'section_id' => $this->request['section_id'],
            'group_id' => $this->request['group_id'] ?? null
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'admission_no' => $this->uniqueAdmissionNoRule(),
            'roll_no' => $this->uniqueRollNoRule($this->request['class_id'], $this->request['session_id']),
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|max:50',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'religion' => 'nullable|max:50',
            'caste' => 'nullable|max:50',
            'mobile_no' => 'nullable|max:20',
            'email' => 'nullable|email',
            'admission_date' => 'nullable|date',
            'father_name' => 'nullable|max:50',
            'father_email' => 'nullable|email',
            'father_cnic' => 'nullable|max:20',
            'father_phone' => 'nullable|max:20',
            'father_occupation' => 'nullable|max:60',
            'mother_name' => 'nullable|max:50',
            'mother_email' => 'nullable|email',
            'mother_cnic' => 'nullable|max:20',
            'mother_phone' => 'nullable|max:20',
            'mother_occupation' => 'nullable|max:60',
            'guardian_is' => 'required|in:father,mother,other',
            'guardian_image' => 'nullable|mimes:png,jpg,jpeg',
            'guardian_name' => 'required|max:50',
            'guardian_email' => 'nullable|email',
            'guardian_cnic' => 'nullable|max:20',
            'guardian_phone' => 'nullable|max:20',
            'guardian_relation' => 'nullable|max:60',
            'guardian_occupation' => 'nullable|max:60',
            'current_address' => 'nullable',
            'permenent_address' => 'nullable'
        ];
    }
}
