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
        	'Class',
        	'Section',
            'Group',
            'Subject'
        ]);

        $modules->each(function($name) {
	        Module::create([
	        	'name' => $name
	        ]);
        });
    }
}
