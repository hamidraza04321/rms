<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Classes;
use App\Models\UserClassPermission;
use App\Models\UserClassSectionPermission;
use App\Models\UserClassGroupPermission;
use App\Models\UserClassSubjectPermission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        $data = [
            'users' => $users,
            'page_title' => 'Manage Users',
            'menu' => 'User'
        ];

        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $classes = Classes::with('sections', 'groups', 'subjects')->get();

        $data = [
            'roles' => $roles,
            'classes' => $classes,
            'page_title' => 'Create User',
            'menu' => 'User'
        ];

        return view('user.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // Assign Role to User
        $role_name = Role::findById($request->role_id)->name;
        $user->assignRole($role_name);

        $sections = [];
        $groups = [];
        $subjects = [];

        // Save User Permissions
        foreach ((array)$request->permissions as $class_id => $permission) {
            // Assign class permission to user
            $class_permission = UserClassPermission::create([
                'class_id' => $class_id,
                'user_id' => $user->id
            ]);

            // Store section in sections array
            if (isset($permission['section_id'])) {
                foreach ($permission['section_id'] as $section_id) {
                    $sections[] = [
                        'class_permission_id' => $class_permission->id,
                        'section_id' => $section_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            // Store group in groups array
            if (isset($permission['group_id'])) {
                foreach ($permission['group_id'] as $group_id) {
                    $groups[] = [
                        'class_permission_id' => $class_permission->id,
                        'group_id' => $group_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            // Store subject in subjects array
            if (isset($permission['subject_id'])) {
                foreach ($permission['subject_id'] as $subject_id) {
                    $subjects[] = [
                        'class_permission_id' => $class_permission->id,
                        'subject_id' => $subject_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        // Assign Section, Group and subject permissions
        UserClassSectionPermission::insert($sections);
        UserClassGroupPermission::insert($groups);
        UserClassSubjectPermission::insert($subjects);

        return response()->successMessage('User Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role_id = $user->roles->first()->id;
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $classes = Classes::with('sections', 'groups', 'subjects')->get();

        $data = [
            'user' => $user,
            'role_id' => $role_id,
            'roles' => $roles,
            'classes' => $classes,
            'page_title' => 'Edit User',
            'menu' => 'User'
        ];

        return view('user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
