<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [ 'name' => 'Computer' ], 
            [ 'name' => 'Biology' ], 
            [ 'name' => 'General Science' ], 
            [ 'name' => 'Commerce' ]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($groups as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Group::insert($data);
    }
}
