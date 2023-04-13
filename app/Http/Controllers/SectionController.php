<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::get();

        $data = [
            'sections' => $sections,
            'page_title' => 'Manage Sections',
            'menu' => 'Section'
        ];

        return view('section.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Section',
            'menu' => 'Section'
        ];

        return view('section.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        Section::create($request->validated()); 
        return response()->successMessage('Section Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::findOrFail($id);

        $data = [
            'section' => $section,
            'page_title' => 'Edit Section',
            'menu' => 'Section'
        ];

        return view('section.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SectionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, $id)
    {
        $section = Section::find($id);

        if ($section) {
            $section->update($request->validated());
            return response()->successMessage('Section Updated Successfully !');
        }

        return response()->successMessage('Section not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);

        if ($section) {
            $section->delete();
            return response()->successMessage('Section Deleted Successfully !');
        }

        return response()->errorMessage('Section not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $sections = Section::onlyTrashed()->get();

        $data = [
            'sections' => $sections,
            'page_title' => 'Section Trash',
            'menu' => 'Section'
        ];

        return view('section.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $section = Section::withTrashed()->find($id);

        if ($section) {
            // Check if section exists with this name
            $exists = Section::where('name', $section->name)->exists();

            if (!$exists) {
                $section->restore();
                return response()->successMessage('Section Restored Successfully !');
            }

            return response()->errorMessage("The Section {$section->name} has already exists !");
        }

        return response()->errorMessage('Section not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $section = Section::onlyTrashed()->find($id);

        if ($section) {
            $section->forceDelete();
            return response()->successMessage('Section Deleted Successfully !');
        }

        return response()->errorMessage('Section not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSectionStatus($id)
    {
        $section = Section::find($id);

        if ($section) {
            $data['is_active'] = ($section->is_active == 1) ? 0 : 1;
            $section->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Section not Found !');
    }
}