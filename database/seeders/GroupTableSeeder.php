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
        $groups = collect([
            [ 'name' => 'Computer' ], 
            [ 'name' => 'Biology' ], 
            [ 'name' => 'General Science' ], 
            [ 'name' => 'Commerce' ]
        ]);

        $groups->each(function($group){
            Group::create($group);
        });
    }
}
