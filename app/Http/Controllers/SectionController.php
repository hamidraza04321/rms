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
        $section = Section::findOrFail($id);
        $section->update($request->validated());
        return response()->successMessage('Section Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->successMessage('Section Deleted Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSectionStatus($id)
    {
        $section = Section::findOrFail($id);
        $data['is_active'] = ($section->is_active == 1) ? 0 : 1;
        $section->update($data);
        return response()->success($data);
    }
}