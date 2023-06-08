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

            // SESSION
            [ 'name' => 'view-session' ],
            [ 'name' => 'create-session' ],
            [ 'name' => 'edit-session' ],
            [ 'name' => 'delete-session' ],
            [ 'name' => 'update-session-status' ],
            [ 'name' => 'view-session-trash' ],
            [ 'name' => 'restore-session' ],
            [ 'name' => 'permanent-delete-session' ],

            // CLASS
            [ 'name' => 'view-class' ],
            [ 'name' => 'create-class' ],
            [ 'name' => 'edit-class' ],
            [ 'name' => 'delete-class' ],
            [ 'name' => 'update-class-status' ],
            [ 'name' => 'view-class-trash' ],
            [ 'name' => 'restore-class' ],
            [ 'name' => 'permanent-delete-class' ],

            // SECTION
            [ 'name' => 'view-section' ],
            [ 'name' => 'create-section' ],
            [ 'name' => 'edit-section' ],
            [ 'name' => 'delete-section' ],
            [ 'name' => 'update-section-status' ],
            [ 'name' => 'view-section-trash' ],
            [ 'name' => 'restore-section' ],
            [ 'name' => 'permanent-delete-section' ],

            // GROUP
            [ 'name' => 'view-group' ],
            [ 'name' => 'create-group' ],
            [ 'name' => 'edit-group' ],
            [ 'name' => 'delete-group' ],
            [ 'name' => 'update-group-status' ],
            [ 'name' => 'view-group-trash' ],
            [ 'name' => 'restore-group' ],
            [ 'name' => 'permanent-delete-group' ],

            // SUBJECT
            [ 'name' => 'view-subject' ],
            [ 'name' => 'create-subject' ],
            [ 'name' => 'edit-subject' ],
            [ 'name' => 'delete-subject' ],
            [ 'name' => 'update-subject-status' ],
            [ 'name' => 'view-subject-trash' ],
            [ 'name' => 'restore-subject' ],
            [ 'name' => 'permanent-delete-subject' ],

            // STUDENT
            [ 'name' => 'view-student' ],
            [ 'name' => 'create-student' ],
            [ 'name' => 'edit-student' ],
            [ 'name' => 'delete-student' ],
            [ 'name' => 'update-student-status' ],
            [ 'name' => 'view-student-trash' ],
            [ 'name' => 'restore-student' ],
            [ 'name' => 'permanent-delete-student' ],
            [ 'name' => 'import-student' ],
            [ 'name' => 'export-student' ],

            // ATTENDANCE STATUS
            [ 'name' => 'view-attendance-status' ],
            [ 'name' => 'create-attendance-status' ],
            [ 'name' => 'edit-attendance-status' ],
            [ 'name' => 'delete-attendance-status' ],
            [ 'name' => 'update-attendance-status' ],
            [ 'name' => 'view-attendance-status-trash' ],
            [ 'name' => 'restore-attendance-status' ],
            [ 'name' => 'permanent-delete-attendance-status' ],

        ]);

        $permissions->each(function($permission) {
        	Permission::create($permission);
        });
    }
}
