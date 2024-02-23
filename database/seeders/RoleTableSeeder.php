<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pluck Permissions
        $menus = Menu::get();

        // Create roles
        $super_admin = Role::create([ 'name' => 'Super Admin' ]);
        $admin = Role::create([ 'name' => 'Admin' ]);
        $examiner = Role::create([ 'name' => 'Examiner' ]);
        $teacher = Role::create([ 'name' => 'Teacher' ]);

         // all permission for admin
        $admin->syncPermissions($menus->pluck('permission')->toArray());

        // Examiner permissions
        $examiner->syncPermissions(
            $menus
                ->whereIn('module_id', [ 9, 10, 11, 12, 13 ])
                ->pluck('permission')
                ->toArray()
        );

        // Teacher Permissions
        $teacher->syncPermissions(
            $menus
                ->whereIn('module_id', [ 6, 8 ])
                ->pluck('permission')
                ->toArray()
        );        
    }
}
