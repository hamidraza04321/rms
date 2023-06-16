<?php

namespace App\Http\Controllers;

use App\Models\Scopes\ActiveScope;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\ExamClass;

class ExamController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->middleware('permission:view-exam', [ 'only' => 'index' ]);
        $this->middleware('permission:create-exam', [ 'only' => [ 'create', 'store' ]]);
        $this->middleware('permission:edit-exam',   [ 'only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:delete-exam', [ 'only' => 'destroy' ]);
        $this->middleware('permission:update-exam-status', [ 'only' => 'updateExamStatus' ]);
        $this->middleware('permission:view-exam-trash', [ 'only' => 'trash' ]);
        $this->middleware('permission:restore-exam', [ 'only' => 'restore' ]);
        $this->middleware('permission:permanent-delete-exam', [ 'only' => 'delete' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::withoutGlobalScope(ActiveScope::class)->get();

        $data = [
            'exams' => $exams,
            'page_title' => 'Manage Exams',
            'menu' => 'Exams'
        ];

        return view('exam.index', compact('data'));
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
            'page_title' => 'Create Exam',
            'menu' => 'Exams'
        ];

        return view('exam.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamRequest $request)
    {
        $data = $request->safe()->except('class_id');
        $data['session_id'] = $this->current_session_id;
        $exam = Exam::create($data);

        // Save Exam Classes
        $exam_classes = [];
        foreach ($request->class_id as $class_id) {
            $exam_classes[] = [
                'exam_id' => $exam->id,
                'class_id' => $class_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        ExamClass::insert($exam_classes);

        return response()->successMessage('Exam Created Successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        $class_ids = $exam->classes->pluck('class_id')->toArray();
        $classes = Classes::get();

        $data = [
            'exam' => $exam,
            'classes' => $classes,
            'class_ids' => $class_ids,
            'page_title' => 'Edit Exam',
            'menu' => 'Exams'
        ];

        return view('exam.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ExamRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamRequest $request, $id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($exam) {
            $data = $request->safe()->except('class_id');
            $exam->update($data);

            // Delete where class id not exists in request
            $exam->classes->whereNotIn('class_id', $request->class_id)->each->delete();

            // Save exam classes
            collect($request->class_id)
                ->each(function($class_id) use($exam) {
                    ExamClass::withTrashed()->firstOrCreate([
                        'exam_id' => $exam->id,
                        'class_id' => $class_id
                    ])->restore();
                });

            return response()->successMessage('Exam Updated Successfully !');
        }

        return response()->successMessage('Exam not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($exam) {
            $exam->delete();
            return response()->successMessage('Exam Deleted Successfully !');
        }

        return response()->errorMessage('Exam not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $exams = Exam::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

        $data = [
            'exams' => $exams,
            'page_title' => 'Exam Trash',
            'menu' => 'Exams'
        ];

        return view('exam.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($exam) {
            // Check if exam exists with this name
            $exists = Exam::withoutGlobalScope(ActiveScope::class)
                ->where('name', $exam->name)
                ->exists();

            if (!$exists) {
                $exam->restore();
                return response()->successMessage('Exam Restored Successfully !');
            }

            return response()->errorMessage("The Exam {$exam->name} has already exists !");
        }

        return response()->errorMessage('Exam not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->find($id);

        if ($exam) {
            $exam->forceDelete();
            return response()->successMessage('Exam Deleted Successfully !');
        }

        return response()->errorMessage('Exam not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateExamStatus($id)
    {
        $exam = Exam::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($exam) {
            $data['is_active'] = ($exam->is_active == 1) ? 0 : 1;
            $exam->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Exam not Found !');
    }
}