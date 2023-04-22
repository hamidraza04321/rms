<?php

namespace App\Http\Controllers;

use App\Models\Scopes\ActiveScope;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;

class SubjectController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-subject', [ 'only' => 'index' ]);
        $this->middleware('permission:create-subject', [ 'only' => [ 'create', 'store' ]]);
        $this->middleware('permission:edit-subject',   [ 'only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:delete-subject', [ 'only' => 'destroy' ]);
        $this->middleware('permission:update-subject-status', [ 'only' => 'updateSubjectStatus' ]);
        $this->middleware('permission:view-subject-trash', [ 'only' => 'trash' ]);
        $this->middleware('permission:restore-subject', [ 'only' => 'restore' ]);
        $this->middleware('permission:permanent-delete-subject', [ 'only' => 'delete' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::withoutGlobalScope(ActiveScope::class)->get();

        $data = [
            'subjects' => $subjects,
            'page_title' => 'Manage Subjects',
            'menu' => 'Subject'
        ];

        return view('subject.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Subject',
            'menu' => 'Subject'
        ];

        return view('subject.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {
        Subject::create($request->validated()); 
        return response()->successMessage('Subject Created Successfully !');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)->findOrFail($id);

        $data = [
            'subject' => $subject,
            'page_title' => 'Edit Subject',
            'menu' => 'Subject'
        ];

        return view('subject.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, $id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($subject) {
            $subject->update($request->validated());
            return response()->successMessage('Subject Updated Successfully !');
        }

        return response()->successMessage('Subject not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($subject) {
            $subject->delete();
            return response()->successMessage('Subject Deleted Successfully !');
        }

        return response()->errorMessage('Subject not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $subjects = Subject::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

        $data = [
            'subjects' => $subjects,
            'page_title' => 'Subject Trash',
            'menu' => 'Subject'
        ];

        return view('subject.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($subject) {
            // Check if subject exists with this name
            $exists = Subject::withoutGlobalScope(ActiveScope::class)
                ->where('name', $subject->name)
                ->exists();

            if (!$exists) {
                $subject->restore();
                return response()->successMessage('Subject Restored Successfully !');
            }

            return response()->errorMessage("The Subject {$subject->name} has already exists !");
        }

        return response()->errorMessage('Subject not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->find($id);

        if ($subject) {
            $subject->forceDelete();
            return response()->successMessage('Subject Deleted Successfully !');
        }

        return response()->errorMessage('Subject not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSubjectStatus($id)
    {
        $subject = Subject::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($subject) {
            $data['is_active'] = ($subject->is_active == 1) ? 0 : 1;
            $subject->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Subject not Found !');
    }
}
