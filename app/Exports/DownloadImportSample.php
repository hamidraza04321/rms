<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DownloadImportSample implements WithHeadings, ShouldAutoSize
{
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
