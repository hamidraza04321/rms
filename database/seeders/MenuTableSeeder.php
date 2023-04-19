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

        	// CLASS MODULE
        	[
	        	'module_id' => 1,
	        	'name' => 'View',
	        	'permission' => 'view-class'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Create',
	        	'permission' => 'create-class'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Edit',
	        	'permission' => 'edit-class'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Delete',
	        	'permission' => 'delete-class'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'View Trash',
	        	'permission' => 'view-class-trash'
	        ], [
	        	'module_id' => 1,
	        	'name' => 'Restore',
	        	'permission' => 'restore-class'
	        ],

	        // SECTION MODULE
	        [
	        	'module_id' => 2,
	        	'name' => 'View',
	        	'permission' => 'view-section'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Create',
	        	'permission' => 'create-section'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Edit',
	        	'permission' => 'edit-section'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Delete',
	        	'permission' => 'delete-section'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'View Trash',
	        	'permission' => 'view-section-trash'
	        ], [
	        	'module_id' => 2,
	        	'name' => 'Restore',
	        	'permission' => 'restore-section'
	        ],

	        // GROUP MODULE
	        [
	        	'module_id' => 3,
	        	'name' => 'View',
	        	'permission' => 'view-group'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Create',
	        	'permission' => 'create-group'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Edit',
	        	'permission' => 'edit-group'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Delete',
	        	'permission' => 'delete-group'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'View Trash',
	        	'permission' => 'view-group-trash'
	        ], [
	        	'module_id' => 3,
	        	'name' => 'Restore',
	        	'permission' => 'restore-group'
	        ],

	        // SUBJECT MODULE
	        [
	        	'module_id' => 4,
	        	'name' => 'View',
	        	'permission' => 'view-subject'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Create',
	        	'permission' => 'create-subject'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Edit',
	        	'permission' => 'edit-subject'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Delete',
	        	'permission' => 'delete-subject'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'View Trash',
	        	'permission' => 'view-subject-trash'
	        ], [
	        	'module_id' => 4,
	        	'name' => 'Restore',
	        	'permission' => 'restore-subject'
	        ]

    	]);

    	$menus->each(function($menu){
    		Menu::create($menu);
    	});
    }
}
