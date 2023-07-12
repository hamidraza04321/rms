<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\Classes;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::withoutGlobalScope(ActiveScope::class)
            ->with('class')
            ->get();

        $data = [
            'grades' => $grades,
            'page_title' => 'Manage Grade',
            'menu' => 'Grade'
        ];

        return view('grade.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::get();

        $data = [
            'classes' => $classes,
            'page_title' => 'Create Grade',
            'menu' => 'Grade'
        ];

        return view('grade.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GradeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeRequest $request)
    {
        Grade::create($request->safe()->all());
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
        $grade = Grade::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        $classes = Classes::get();

        $data = [
            'classes' => $classes,
            'grade' => $grade,
            'page_title' => 'Edit Grade',
            'menu' => 'Grade'
        ];

        return view('grade.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GradeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GradeRequest $request, $id)
    {
        $grade = Grade::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($grade) {
            $grade->update($request->safe()->all());
            return response()->successMessage('Grade Updated Successfully !');
        }

        return response()->errorMessage('Grade not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade = Grade::withoutGlobalScope(ActiveScope::class)->find($id);
        
        if ($grade) {
            $grade->delete();
            return response()->successMessage('Grade Deleted Successfully !');
        }

        return response()->errorMessage('Grade not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $grades = Grade::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

        $data = [
            'grades' => $grades,
            'page_title' => 'Grade Trash',
            'menu' => 'Grade'
        ];

        return view('grade.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $grade = Grade::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($grade) {
            // Check if class exists with this name
            $exists = Grade::withoutGlobalScope(ActiveScope::class)
                ->where([
                    'class_id' => $grade->class_id,
                    'grade' => $grade->grade
                ])
                ->exists();

            if (!$exists) {
                $grade->restore();
                return response()->successMessage('Grade Restored Successfully !');
            }

            return response()->errorMessage("The Grade ( {$grade->grade} ) has already exists in class ( {$grade->class->name} ) !");
        }

        return response()->errorMessage('Grade not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $grade = Grade::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($grade) {
            $grade->forceDelete();
            return response()->successMessage('Grade Deleted Successfully !');
        }

        return response()->errorMessage('Grade not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGradeStatus($id)
    {
        $grade = Grade::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($grade) {
            $data['is_active'] = ($grade->is_active == 1) ? 0 : 1;
            $grade->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Grade not Found !');
    }
}
