<?php

namespace App\Http\Controllers;

use App\Models\Scopes\ActiveScope;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\Classes;
use App\Models\Session;
use App\Models\ExamClass;
use App\Models\ClassGroup;
use App\Services\ExamDatesheetService;

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
        $this->middleware('permission:print-datesheet', [ 'only' => 'datesheet' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::withoutGlobalScope(ActiveScope::class)
            ->with('session')
            ->get();

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
        $sessions = Session::get();

        $data = [
            'classes' => $classes,
            'sessions' => $sessions,
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
        $exam = Exam::create($data);

        // Get Class groups
        $class_groups = ClassGroup::whereIn('class_id', $request->class_id)->get();

        // Save Exam Classes
        $exam_classes = [];
        foreach ($request->class_id as $class_id) {
            $groups = $class_groups->where('class_id', $class_id);

            // Class Groups is exists
            if (count($groups)) {
                foreach ($groups as $group) {
                    $exam_classes[] = [
                        'exam_id' => $exam->id,
                        'class_id' => $class_id,
                        'group_id' => $group->group_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            } else {
                $exam_classes[] = [
                    'exam_id' => $exam->id,
                    'class_id' => $class_id,
                    'group_id' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
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

        $sessions = Session::get();
        $classes = Classes::get();

        $data = [
            'exam' => $exam,
            'classes' => $classes,
            'sessions' => $sessions,
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
        $exam = Exam::withoutGlobalScope(ActiveScope::class)
            ->with('classes')
            ->find($id);

        if ($exam) {
            $data = $request->safe()->except('class_id');
            $exam->update($data);

            // Delete where class id not exists in request
            $exam->classes->whereNotIn('class_id', $request->class_id)->each->delete();
            // Get exists class ids
            $exists_class_ids = $exam->classes->pluck('class_id')->toArray();
            // Merge Exists and delete class ids to get which ids to create
            $create_class_ids = array_diff($request->class_id, $exists_class_ids);
            // Get Class groups
            $class_groups = ClassGroup::whereIn('class_id', $create_class_ids)->get();

            // Save exam classes
            $exam_classes = [];

            foreach ($create_class_ids as $class_id) {
                $groups = $class_groups->where('class_id', $class_id);

                // Class Groups Exists
                if (count($groups)) {
                    foreach ($groups as $group) {
                        $exam_classes[] = [
                            'exam_id' => $exam->id,
                            'class_id' => $class_id,
                            'group_id' => $group->group_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                } else {
                    $exam_classes[] = [
                        'exam_id' => $exam->id,
                        'class_id' => $class_id,
                        'group_id' => null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            ExamClass::insert($exam_classes);

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
                ->where('session_id', $exam->session_id)
                ->exists();

            if (!$exists) {
                $exam->restore();
                return response()->successMessage('Exam Restored Successfully !');
            }

            return response()->errorMessage("The Exam ( {$exam->name} ) has already exists !");
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

    /**
     * Get Exams By session.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExamsBySession(ExamRequest $request)
    {
        $exams = Exam::where('session_id', $request->session_id)
            ->get([ 'id', 'name' ]);
        
        return response()->success([
            'exams' => $exams
        ]);
    }

    /**
     * Get Exam Classes.
     *
     * @return \Illuminate\Http\Response
     */
    public function getExamClasses(ExamRequest $request)
    {
        $classes = ExamClass::where('exam_id', $request->exam_id)
            ->groupBy('class_id')
            ->with('class')
            ->get()
            ->pluck('class');

        return response()->success([
            'classes' => $classes
        ]);
    }

    /**
     * Print the datesheet of exam.
     *
     * @param  $exam_id  int
     * @return \Illuminate\Http\Response
     */
    public function datesheet($exam_id)
    {
        $datesheet = (new ExamDatesheetService)->getDatesheet($exam_id);

        $data = [
            'page_title' => 'Print Datesheet',
            'datesheet' => $datesheet
        ];

        return view('exam.datesheet', compact('data'));
    }
}
