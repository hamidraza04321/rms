<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassRequest;
use App\Models\Classes;

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

        $data = array(
            'classes' => $classes,
            'page_title' => 'Manage Classes',
            'menu' => 'Class'
        );

        return view('class.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'page_title' => 'Create Class',
            'menu' => 'Class'
        );

        return view('class.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequest $request)
    {
        Classes::create($request->validated()); 
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

        $data = array(
            'class' => $class,
            'page_title' => 'Edit Class',
            'menu' => 'Class'
        );

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
        $class = Classes::findOrFail($id);
        $class->update($request->validated());
        return response()->successMessage('Class Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();
        return response()->successMessage('Class Deleted Successfully !');
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
