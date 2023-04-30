<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentsExport implements FromQuery, WithMapping, WithHeadings, WithHeadingRow, ShouldAutoSize
{
	public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
    	$where = collect($this->request)
            ->filter()
            ->toArray();
        
        if (isset($where['is_active'])) {
            $where['is_active'] = ($request->is_active == 'active') ? 1 : 0;
        }

        return Student::query()
            ->where($where);
    }

    public function map($student): array
    {
        return [
            $student->admission_no,
            $student->roll_no,
            $student->first_name,
            $student->last_name,
            $student->gender,
            $student->dob,
            $student->religion,
            $student->caste,
            $student->mobile_no,
            $student->email,
            $student->admission_date,
            $student->father_name,
            $student->father_email,
            $student->father_cnic,
            $student->father_phone,
            $student->father_occupation,
            $student->mother_name,
            $student->mother_email,
            $student->mother_cnic,
            $student->mother_phone,
            $student->mother_occupation,
            $student->guardian_is,
            $student->guardian_name,
            $student->guardian_email,
            $student->guardian_cnic,
            $student->guardian_phone,
            $student->guardian_relation,
            $student->guardian_occupation,
            $student->current_address,
            $student->permenant_address
        ];
    }

    public function headings(): array
    {
        return [
            'Admission No',
            'Roll No',
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
            'Religion',
            'Caste',
            'Mobile No',
            'Email',
            'Admission Date',
            'Father Name',
            'Father Email',
            'Father CNIC',
            'Father Phone',
            'Father Occupation',
            'Mother Name',
            'Mother Email',
            'Mother CNIC',
            'Mother Phone',
            'Mother Occupation',
            'Guardian Is',
            'Guardian Name',
            'Guardian Email',
            'Guardian CNIC',
            'Guardian Phone',
            'Guardian Relation',
            'Guardian Occupation',
            'Current Address',
            'Permenant Address'
        ];
    }
}
