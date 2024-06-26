<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
        	[ 'name' => 'English' ],
        	[ 'name' => 'Urdu' ],
        	[ 'name' => 'Mathematics' ],
        	[ 'name' => 'Islamiat' ],
        	[ 'name' => 'General Science' ],
        	[ 'name' => 'Computer' ],
            [ 'name' => 'Physics' ],
        	[ 'name' => 'Chemistry' ]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($subjects as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Subject::insert($data);
    }
}
