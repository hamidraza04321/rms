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
        $menus = [

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
	        ],

	        // ATTENDANCE STATUS MODULE
	        [
	        	'module_id' => 7,
	        	'name' => 'View',
	        	'permission' => 'view-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Create',
	        	'permission' => 'create-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Edit',
	        	'permission' => 'edit-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Delete',
	        	'permission' => 'delete-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Update Status',
	        	'permission' => 'update-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'View Trash',
	        	'permission' => 'view-attendance-status-trash'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Restore',
	        	'permission' => 'restore-attendance-status'
	        ], [
	        	'module_id' => 7,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-attendance-status'
	        ],

	        // STUDENT ATTENDANCE MODULE
	        [
	        	'module_id' => 8,
	        	'name' => 'Mark Attendance',
	        	'permission' => 'mark-attendance'
	        ], [
	        	'module_id' => 8,
	        	'name' => 'Attendance Report',
	        	'permission' => 'attendance-report'
	        ],

	        // EXAM MODULE
	        [
	        	'module_id' => 9,
	        	'name' => 'View',
	        	'permission' => 'view-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Create',
	        	'permission' => 'create-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Edit',
	        	'permission' => 'edit-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Delete',
	        	'permission' => 'delete-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Update Status',
	        	'permission' => 'update-exam-status'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'View Trash',
	        	'permission' => 'view-exam-trash'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Restore',
	        	'permission' => 'restore-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-exam'
	        ], [
	        	'module_id' => 9,
	        	'name' => 'Print Datesheet',
	        	'permission' => 'print-datesheet'
	        ],

	        // GRADE MODULE
	        [
	        	'module_id' => 10,
	        	'name' => 'View',
	        	'permission' => 'view-grade'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Create',
	        	'permission' => 'create-grade'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Edit',
	        	'permission' => 'edit-grade'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Delete',
	        	'permission' => 'delete-grade'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Update Status',
	        	'permission' => 'update-grade-status'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'View Trash',
	        	'permission' => 'view-grade-trash'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Restore',
	        	'permission' => 'restore-grade'
	        ], [
	        	'module_id' => 10,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-grade'
	        ],

	        // EXAM SCHEDULE MODULE
	        [
	        	'module_id' => 11,
	        	'name' => 'View',
	        	'permission' => 'view-exam-schedule'
	        ], [
	        	'module_id' => 11,
	        	'name' => 'Create',
	        	'permission' => 'create-exam-schedule'
	        ], [
	        	'module_id' => 11,
	        	'name' => 'Edit',
	        	'permission' => 'edit-exam-schedule'
	        ], [
	        	'module_id' => 11,
	        	'name' => 'Delete',
	        	'permission' => 'delete-exam-schedule'
	        ],

	        // MARK SLIP MODULE
	        [
	        	'module_id' => 12,
	        	'name' => 'View',
	        	'permission' => 'view-mark-slip'
	        ], [
	        	'module_id' => 12,
	        	'name' => 'Create',
	        	'permission' => 'create-mark-slip'
	        ], [
	        	'module_id' => 12,
	        	'name' => 'Edit',
	        	'permission' => 'edit-mark-slip'
	        ], [
	        	'module_id' => 12,
	        	'name' => 'Delete',
	        	'permission' => 'delete-mark-slip'
	        ], [
	        	'module_id' => 12,
	        	'name' => 'Print',
	        	'permission' => 'print-mark-slip'
	        ], [
	        	'module_id' => 12,
	        	'name' => 'Tabulation Sheet',
	        	'permission' => 'tabulation-sheet'
	        ],

	        // RESULT CARD MODULE
	        [
	        	'module_id' => 13,
	        	'name' => 'Print',
	        	'permission' => 'print-result-card'
	        ],

	        // ROLE MODULE
	        [
	        	'module_id' => 14,
	        	'name' => 'View',
	        	'permission' => 'view-role'
	        ], [
	        	'module_id' => 14,
	        	'name' => 'Create',
	        	'permission' => 'create-role'
	        ], [
	        	'module_id' => 14,
	        	'name' => 'Edit',
	        	'permission' => 'edit-role'
	        ], [
	        	'module_id' => 14,
	        	'name' => 'Delete',
				'permission' => 'delete-role'
	        ],

	        // USER MODULE
        	[
	        	'module_id' => 15,
	        	'name' => 'View',
	        	'permission' => 'view-user'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Create',
	        	'permission' => 'create-user'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Edit',
	        	'permission' => 'edit-user'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Delete',
	        	'permission' => 'delete-user'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Update Status',
	        	'permission' => 'update-user-status'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'View Trash',
	        	'permission' => 'view-user-trash'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Restore',
	        	'permission' => 'restore-user'
	        ], [
	        	'module_id' => 15,
	        	'name' => 'Permanent Delete',
	        	'permission' => 'permanent-delete-user'
	        ], 

	        // SETTINGS MODULE
	        [
	        	'module_id' => 16,
	        	'name' => 'View General Settings',
	        	'permission' => 'general-settings-view'
	        ],
	        [
	        	'module_id' => 16,
	        	'name' => 'Edit General Settings',
	        	'permission' => 'general-settings-edit'
	        ],

	        // USER PROFILE
	        [
	        	'module_id' => 17,
	        	'name' => 'View',
	        	'permission' => 'view-profile'
	        ],
	        [
	        	'module_id' => 17,
	        	'name' => 'Edit Profile',
	        	'permission' => 'edit-profile'
	        ],
	        [
	        	'module_id' => 17,
	        	'name' => 'Change Password',
	        	'permission' => 'profile-change-password'
	        ],
	        [
	        	'module_id' => 17,
	        	'name' => 'Update Credentials',
	        	'permission' => 'profile-update-credentials'
	        ],

	        // DASHBOARD
	        [
	        	'module_id' => 18,
	        	'name' => 'Dashbaord Widgets',
	        	'permission' => 'dashboard-widgets'
	        ],
	        [
	        	'module_id' => 18,
	        	'name' => 'Attendance Graph',
	        	'permission' => 'dashboard-attendance-graph'
	        ],
	        [
	        	'module_id' => 18,
	        	'name' => 'Total Students Graph',
	        	'permission' => 'dashboard-total-students-graph'
	        ]
    	];

		// TIMESTAMPS
        $data = [];
        foreach ($menus as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

		Menu::insert($data);
    }
}
