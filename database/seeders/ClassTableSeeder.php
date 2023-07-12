<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            [ 'name' => 'Class I' ],
            [ 'name' => 'Class II' ],
            [ 'name' => 'Class III' ],
            [ 'name' => 'Class IV' ],
            [ 'name' => 'Class V' ],
            [ 'name' => 'Class VI' ],
            [ 'name' => 'Class VII' ],
            [ 'name' => 'Class VIII' ],
            [ 'name' => 'Class IX' ],
            [ 'name' => 'Class X' ]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($classes as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Classes::insert($data);
    }
}
