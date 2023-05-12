<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = collect([
            [ 'name' => 'A' ], 
            [ 'name' => 'B' ], 
            [ 'name' => 'C' ], 
            [ 'name' => 'D' ], 
            [ 'name' => 'E' ], 
            [ 'name' => 'F' ] 
        ]);

        $sections->each(function($section){
            Section::create($section);
        });
    }
}
