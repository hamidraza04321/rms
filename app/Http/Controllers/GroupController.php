<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::get();

        $data = [
            'groups' => $groups,
            'page_title' => 'Manage Groups',
            'menu' => 'Group'
        ];

        return view('group.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Group',
            'menu' => 'Group'
        ];

        return view('group.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        Group::create($request->validated()); 
        return response()->successMessage('Group Created Successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);

        $data = [
            'group' => $group,
            'page_title' => 'Edit Group',
            'menu' => 'Group'
        ];

        return view('group.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {
        $group = Group::find($id);

        if ($group) {
            $group->update($request->validated());
            return response()->successMessage('Group Updated Successfully !');
        }

        return response()->successMessage('Group not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if ($group) {
            $group->delete();
            return response()->successMessage('Group Deleted Successfully !');
        }

        return response()->errorMessage('Group not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $groups = Group::onlyTrashed()->get();

        $data = [
            'groups' => $groups,
            'page_title' => 'Group Trash',
            'menu' => 'Group'
        ];

        return view('group.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $group = Group::withTrashed()->find($id);

        if ($group) {
            // Check if group exists with this name
            $exists = Group::where('name', $group->name)->exists();

            if (!$exists) {
                $group->restore();
                return response()->successMessage('Group Restored Successfully !');
            }

            return response()->errorMessage("The Group {$group->name} has already exists !");
        }

        return response()->errorMessage('Group not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $group = Group::onlyTrashed()->find($id);

        if ($group) {
            $group->forceDelete();
            return response()->successMessage('Group Deleted Successfully !');
        }

        return response()->errorMessage('Group not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGroupStatus($id)
    {
        $group = Group::find($id);

        if ($group) {
            $data['is_active'] = ($group->is_active == 1) ? 0 : 1;
            $group->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Group not Found !');
    }
}
