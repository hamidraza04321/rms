<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
        	[
        		'grade' => 'A+',
        		'percentage_from' => '90',
        		'percentage_to' => '100',
        		'color' => '#0a7aff',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'A',
        		'percentage_from' => '80',
        		'percentage_to' => '89.99',
        		'color' => '#00c05b',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'B',
        		'percentage_from' => '70',
        		'percentage_to' => '79.99',
        		'color' => '#00b6ff',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'C',
        		'percentage_from' => '60',
        		'percentage_to' => '69.99',
        		'color' => '#ff9c0c',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'D',
        		'percentage_from' => '50',
        		'percentage_to' => '59.99',
        		'color' => '#d69b0e',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'E',
        		'percentage_from' => '40',
        		'percentage_to' => '49.99',
        		'color' => '#0ec1c6',
        		'is_default' => 1,
        		'is_fail' => 0
        	],
        	[
        		'grade' => 'F',
        		'percentage_from' => '0',
        		'percentage_to' => '39.99',
        		'color' => '#b21f2d',
        		'is_default' => 1,
        		'is_fail' => 1
        	]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($grades as $grade) {
            $data[] = array_merge($grade, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Grade::insert($data);
    }
}
