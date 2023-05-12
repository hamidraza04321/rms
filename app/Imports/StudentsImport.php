<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

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

        dd($row);
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
            'admission_no' => [ 'required', 'max:20', Rule::unique('students')->whereNull('deleted_at') ],
            'roll_no' => [ 'required', 'max:20', Rule::unique('students')->whereNull('deleted_at')->where('class_id', $this->request['class_id']) ],
            'first_name' => 'required|max:50',
            'last_name' => 'nullable|string|max:50',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'admission_date' => 'nullable|date',
            'father_name' => 'nullable|string|max:50',
            'father_email' => 'nullable|email',
            'father_cnic' => 'nullable|string|max:20',
            'father_phone' => 'nullable|string|max:20',
            'father_occupation' => 'nullable|string|max:60',
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
}
