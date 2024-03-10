<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRequest;
use App\Models\Scopes\ActiveScope;
use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\ClassGroup;
use App\Models\Section;
use App\Models\Group;
use App\Models\Subject;
use App\Models\ClassSubject;

class ClassController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-class', [ 'only' => 'index' ]);
        $this->middleware('permission:create-class', [ 'only' => [ 'create', 'store' ]]);
        $this->middleware('permission:edit-class',   [ 'only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:delete-class', [ 'only' => 'destroy' ]);
        $this->middleware('permission:update-class-status', [ 'only' => 'updateClassStatus' ]);
        $this->middleware('permission:view-class-trash', [ 'only' => 'trash' ]);
        $this->middleware('permission:restore-class', [ 'only' => 'restore' ]);
        $this->middleware('permission:permanent-delete-class', [ 'only' => 'delete' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::withoutGlobalScope(ActiveScope::class)->get();

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
        $sections = Section::get($selected);
        $groups = Group::get($selected);
        $subjects = Subject::get($selected);

        $data = [
            'sections' => $sections,
            'groups' => $groups,
            'subjects' => $subjects,
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
        // Create class
        $class = Classes::create([ 'name' => $request->name ]);

        // Attach class: sections, groups, subjects
        $class->sections()->attach($request->section_id);
        $class->groups()->attach($request->group_id);
        $class->subjects()->attach($request->subject_id);

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
        $class = Classes::withoutGlobalScope(ActiveScope::class)->findOrFail($id);

        $section_ids = ClassSection::where('class_id', $class->id)->pluck('section_id')->toArray();
        $group_ids = ClassGroup::where('class_id', $class->id)->pluck('group_id')->toArray();
        $subject_ids = ClassSubject::where('class_id', $class->id)->pluck('subject_id')->toArray();

        $selected = [ 'id', 'name' ];
        $sections = Section::get($selected);
        $groups = Group::get($selected);
        $subjects = Subject::get($selected);

        $data = [
            'class' => $class,
            'sections' => $sections,
            'groups' => $groups,
            'subjects' => $subjects,
            'section_ids' => $section_ids,
            'group_ids' => $group_ids,
            'subject_ids' => $subject_ids,
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
        $class = Classes::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($class) {
            $class->update([
                'name' => $request->name
            ]);

            // Sync class: sections, groups, subjects
            $class->sections()->sync($request->section_id);
            $class->groups()->sync($request->group_id);
            $class->subjects()->sync($request->subject_id);

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
        $class = Classes::withoutGlobalScope(ActiveScope::class)->find($id);

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
        $classes = Classes::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

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
        $class = Classes::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($class) {
            // Check if class exists with this name
            $exists = Classes::withoutGlobalScope(ActiveScope::class)
                ->where('name', $class->name)
                ->exists();

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
        $class = Classes::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

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
        $class = Classes::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($class) {
            $data['is_active'] = ($class->is_active == 1) ? 0 : 1;
            $class->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Class not Found !');
    }

    /**
     * Get sections and groups of class.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClassSectionsAndGroups(ClassRequest $request)
    {
        $class = Classes::find($request->class_id);
        $sections = ClassSection::where('class_id', $request->class_id)->with('section')->get()->pluck('section');
        $groups = ClassGroup::where('class_id', $request->class_id)->with('group')->get()->pluck('group');

        return response()->success([
            'sections' => $sections,
            'groups' => $groups
        ]);
    }

    /**
     * Get sections, groups and subjects of class.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getClassSectionsGroupsAndSubjects(ClassRequest $request)
    {
        $class = Classes::find($request->class_id);
        $sections = ClassSection::where('class_id', $request->class_id)->with('section')->get()->pluck('section');
        $groups = ClassGroup::where('class_id', $request->class_id)->with('group')->get()->pluck('group');
        $subjects = ClassSubject::where('class_id', $request->class_id)->with('subject')->get()->pluck('subject');

        return response()->success([
            'sections' => $sections,
            'groups' => $groups,
            'subjects' => $subjects
        ]);
    }
}
