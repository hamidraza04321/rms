<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRequest;
use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\ClassGroup;
use App\Models\Section;
use App\Models\Group;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::get();

        $data = [
            'classes' => $classes,
            'page_title' => 'Manage Classes',
            'menu' => 'Class'
        ];

        return view('class.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selected = [ 'id', 'name' ];
        $sections = Section::active()->get($selected);
        $groups = Group::active()->get($selected);

        $data = [
            'sections' => $sections,
            'groups' => $groups,
            'page_title' => 'Create Class',
            'menu' => 'Class'
        ];

        return view('class.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        // CREATE CLASS
        $class = Classes::create([ 'name' => $request->name ]);
        
        // Save class section
        collect($request->section_id)->each(function($section_id) use($class) {
            ClassSection::create([
                'class_id' => $class->id,
                'section_id' => $section_id
            ]);
        });

        // Svae class groups
        collect($request->group_id)->each(function($group_id) use($class) {
            ClassGroup::create([
                'class_id' => $class->id,
                'group_id' => $group_id
            ]);
        });

        return response()->successMessage('Class Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        $section_ids = $class->sections->pluck('section_id')->toArray();
        $group_ids = $class->groups->pluck('group_id')->toArray();

        $selected = [ 'id', 'name' ];
        $sections = Section::active()->get($selected);
        $groups = Group::active()->get($selected);

        $data = [
            'class' => $class,
            'sections' => $sections,
            'groups' => $groups,
            'section_ids' => $section_ids,
            'group_ids' => $group_ids,
            'page_title' => 'Edit Class',
            'menu' => 'Class'
        ];

        return view('class.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassRequest $request, $id)
    {
        $class = Classes::find($id);

        if ($class) {
            $class->update([ 'name' => $request->name ]);

            // Delete where id not exists in request
            $class->sections->whereNotIn('section_id', $request->section_id)->each->delete();
            $class->groups->whereNotIn('group_id', $request->group_id)->each->delete();

            // Save class section
            collect($request->section_id)->each(function($section_id) use($class) {
                ClassSection::withTrashed()->firstOrCreate([
                    'class_id' => $class->id,
                    'section_id' => $section_id
                ])->restore();
            });

            // Svae class groups
            collect($request->group_id)->each(function($group_id) use($class) {
                ClassGroup::withTrashed()->firstOrCreate([
                    'class_id' => $class->id,
                    'group_id' => $group_id
                ])->restore();
            });

            return response()->successMessage('Class Updated Successfully !');
        }

        return response()->errorMessage('Class not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classes::find($id);
        
        if ($class) {
            $class->delete();
            return response()->successMessage('Class Deleted Successfully !');
        }

        return response()->errorMessage('Class not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $classes = Classes::onlyTrashed()->get();

        $data = [
            'classes' => $classes,
            'page_title' => 'Class Trash',
            'menu' => 'Class'
        ];

        return view('class.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $class = Classes::withTrashed()->find($id);

        if ($class) {
            // Check if class exists with this name
            $exists = Classes::where('name', $class->name)->exists();

            if (!$exists) {
                $class->restore();
                return response()->successMessage('Class Restored Successfully !');
            }

            return response()->errorMessage("The Class {$class->name} has already exists !");
        }

        return response()->errorMessage('Class not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $class = Classes::withTrashed()->find($id);

        if ($class) {
            $class->forceDelete();
            return response()->successMessage('Class Deleted Successfully !');
        }

        return response()->errorMessage('Class not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateClassStatus($id)
    {
        $class = Classes::findOrFail($id);
        $data['is_active'] = ($class->is_active == 1) ? 0 : 1;
        $class->update($data);
        return response()->success($data);
    }
}
