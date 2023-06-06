<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = collect([

        	// SESSION MODULE
        	[
	        	'module_id' => 1,
	        	'name' => 'View',
	        	'permission' => 'view-session'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Create',
	        	'permission' => 'create-session'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Edit',
	        	'permission' => 'edit-session'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Delete',
	        	'permission' => 'delete-session'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Update Status',
	        	'permission' => 'update-session-status'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'View Trash',
	        	'permission' => 'view-session-trash'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Restore',
	        	'permission' => 'restore-session'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-session'
	        ],

        	// CLASS MODULE
        	[
	        	'module_id' => 2,
	        	'name' => 'View',
	        	'permission' => 'view-class'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Create',
	        	'permission' => 'create-class'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Edit',
	        	'permission' => 'edit-class'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Delete',
	        	'permission' => 'delete-class'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Update Status',
	        	'permission' => 'update-class-status'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'View Trash',
	        	'permission' => 'view-class-trash'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Restore',
	        	'permission' => 'restore-class'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-class'
	        ],

	        // SECTION MODULE
	        [
	        	'module_id' => 3,
	        	'name' => 'View',
	        	'permission' => 'view-section'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Create',
	        	'permission' => 'create-section'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Edit',
	        	'permission' => 'edit-section'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Delete',
	        	'permission' => 'delete-section'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Update Status',
	        	'permission' => 'update-section-status'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'View Trash',
	        	'permission' => 'view-section-trash'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Restore',
	        	'permission' => 'restore-section'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-section'
	        ],

	        // GROUP MODULE
	        [
	        	'module_id' => 4,
	        	'name' => 'View',
	        	'permission' => 'view-group'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Create',
	        	'permission' => 'create-group'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Edit',
	        	'permission' => 'edit-group'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Delete',
	        	'permission' => 'delete-group'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Update Status',
	        	'permission' => 'update-group-status'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'View Trash',
	        	'permission' => 'view-group-trash'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Restore',
	        	'permission' => 'restore-group'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-group'
	        ],

	        // SUBJECT MODULE
	        [
	        	'module_id' => 5,
	        	'name' => 'View',
	        	'permission' => 'view-subject'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Create',
	        	'permission' => 'create-subject'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Edit',
	        	'permission' => 'edit-subject'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Delete',
	        	'permission' => 'delete-subject'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Update Status',
	        	'permission' => 'update-subject-status'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'View Trash',
	        	'permission' => 'view-subject-trash'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Restore',
	        	'permission' => 'restore-subject'
	        ], [
	        	'module_id' => 5,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-subject'
	        ],

	        // STUDENT MODULE
	        [
	        	'module_id' => 6,
	        	'name' => 'View',
	        	'permission' => 'view-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Create',
	        	'permission' => 'create-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Edit',
	        	'permission' => 'edit-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Delete',
	        	'permission' => 'delete-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Update Status',
	        	'permission' => 'update-student-status'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'View Trash',
	        	'permission' => 'view-student-trash'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Restore',
	        	'permission' => 'restore-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Import',
	        	'permission' => 'import-student'
	        ], [
	        	'module_id' => 6,
	        	'name' => 'Export',
	        	'permission' => 'export-student'
	        ]

    	]);

    	$menus->each(function($menu){
    		Menu::create($menu);
    	});
    }
}
