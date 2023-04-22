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
            'update-class-status',
            'view-class-trash',
            'restore-class',
            'permanent-delete-class',

        	// SECTION
        	'view-section',
        	'create-section',
        	'edit-section',
        	'delete-section',
            'update-section-status',
        	'view-section-trash',
        	'restore-section',
            'permanent-delete-section',

            // GROUP
            'view-group',
            'create-group',
            'edit-group',
            'delete-group',
            'update-group-status',
            'view-group-trash',
            'restore-group',
            'permanent-delete-group',

            // SUBJECT
            'view-subject',
            'create-subject',
            'edit-subject',
            'delete-subject',
            'update-subject-status',
            'view-subject-trash',
            'restore-subject',
            'permanent-delete-subject'

        ]);

        $permissions->each(function($name) {
        	Permission::create([
        		'name' => $name
        	]);
        });
    }
}
