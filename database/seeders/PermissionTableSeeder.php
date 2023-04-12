<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([

            // CLASS
            'view-class',
            'create-class',
            'edit-class',
            'delete-class',
            'view-class-trash',
            'restore-class',

        	// SECTION
        	'view-section',
        	'create-section',
        	'edit-section',
        	'delete-section',
        	'view-section-trash',
        	'restore-section'

        ]);

        $permissions->each(function($name) {
        	Permission::create([
        		'name' => $name
        	]);
        });
    }
}
