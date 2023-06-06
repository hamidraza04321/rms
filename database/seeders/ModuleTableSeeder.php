<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = collect([
            [ 'name' => 'Session' ],
            [ 'name' => 'Class' ],
            [ 'name' => 'Section' ],
            [ 'name' => 'Group' ],
            [ 'name' => 'Subject' ],
            [ 'name' => 'Student' ]
        ]);

        $modules->each(function($module) {
	        Module::create($module);
        });
    }
}
