<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Classes;
use App\Models\UserClass;

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

        // Attach Class section, subject, group to user
        $user->classes()->attach($request->class_id);
        $user->classSections()->attach($request->class_section_id);
        $user->classSubjects()->attach($request->class_subject_id);
        $user->classGroups()->attach($request->class_group_id);

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

        // Get user Class section, subject and group id
        $user_classes = $user->classes()->get()->pluck('pivot.class_id')->toArray();
        $user_class_sections = $user->classSections()->get()->pluck('pivot.class_section_id')->toArray();
        $user_class_subjects = $user->classSubjects()->get()->pluck('pivot.class_subject_id')->toArray();
        $user_class_groups = $user->classGroups()->get()->pluck('pivot.class_group_id')->toArray();

        // Check user has all Classses
        $class_id = $classes->pluck('id')->toArray();
        $class_section_id = $classes->pluck('sections')->collapse()->pluck('id')->toArray();
        $class_subject_id = $classes->pluck('subjects')->collapse()->pluck('id')->toArray();
        $class_group_id = $classes->pluck('groups')->collapse()->pluck('id')->toArray();

        // Check user ha all permission
        $has_all_permission[] = empty(array_diff($class_id, $user_classes));
        $has_all_permission[] = empty(array_diff($class_section_id, $user_class_sections));
        $has_all_permission[] = empty(array_diff($class_subject_id, $user_class_subjects));
        $has_all_permission[] = empty(array_diff($class_group_id, $user_class_groups));
        $has_all_permissions = !in_array(false, $has_all_permission);

        $data = [
            'user' => $user,
            'role_id' => $role_id,
            'roles' => $roles,
            'classes' => $classes,
            'user_classes' => $user_classes,
            'user_class_sections' => $user_class_sections,
            'user_class_subjects' => $user_class_subjects,
            'user_class_groups' => $user_class_groups,
            'has_all_permissions' => $has_all_permissions,
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
        $user = User::find($id);

        if ($user) {
            $data = [
                'name' => $request->name,
                'email' => $request->email
            ];

            // If password exists in request update password
            if ($request->password) $data['password'] = bcrypt($request->password);

            // Update User
            $user->update($data);

            // Sync User Role
            $user->syncRoles($request->role_id);

            // Sync Class section, subject, group to user
            $user->classes()->sync($request->class_id);
            $user->classSections()->sync($request->class_section_id);
            $user->classSubjects()->sync($request->class_subject_id);
            $user->classGroups()->sync($request->class_group_id);

            return response()->successMessage('User Updated Successfully!');
        }

        return response()->errorMessage('User not Found !');
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
