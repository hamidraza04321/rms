<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Models\Module;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();

        $data = [
            'roles' => $roles,
            'page_title' => 'Manage Role',
            'menu' => 'Role'
        ];

        return view('role.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::with('menus')->orderBy('order_level', 'asc')->get();

        $data = [
            'modules' => $modules,
            'page_title' => 'Create Role',
            'menu' => 'Role'
        ];

        return view('role.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([ 'name' => $request->name ]);   
        $role->syncPermissions($request->permissions);
        return response()->successMessage('Role Created Successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $modules = Module::with('menus')->orderBy('order_level', 'asc')->get();
        $permissions = $role->permissions->pluck('name')->toArray();
        $menus = $modules->pluck('menus')->collapse()->pluck('permission')->toArray();
        $has_all_permissions = ($permissions == $menus);

        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'has_all_permissions' => $has_all_permissions,
            'modules' => $modules,
            'page_title' => 'Edit Role',
            'menu' => 'Role'
        ];

        return view('role.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);

        if ($role->name != 'Super Admin') {
            $role->update([ 'name' => $request->name ]);   
            $role->syncPermissions($request->permissions);
            return response()->successMessage('Role Updated Successfully !');
        }

        return response()->errorMessage('The Super Admin role can not be Update !');
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
