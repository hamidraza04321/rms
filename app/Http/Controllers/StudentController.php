<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Scopes\ActiveScope;
use App\Exports\StudentsExport;
use App\Exports\DownloadImportSample;
use App\Imports\StudentsImport;
use App\Models\StudentSession;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Session;
use App\Models\Section;
use Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student_session = StudentSession::withoutGlobalScope(ActiveScope::class)
            ->where('session_id', $this->current_session_id)
            ->with([
                'student' => function($query){
                    $query->select(
                        'id',
                        'admission_no',
                        'roll_no',
                        'first_name',
                        'last_name',
                        'father_name'
                    );
                },
                'session',
                'section',
                'class',
                'group'
            ])
            ->get([
                'id',
                'student_id',
                'session_id',
                'class_id',
                'section_id',
                'group_id',
                'is_active'
            ]);

        $sessions = Session::get();
        $classes = Classes::get();

        $data = [
            'student_session' => $student_session,
            'sessions' => $sessions,
            'classes' => $classes,
            'page_title' => 'Manage Students',
            'menu' => 'Student'
        ];

        return view('student.index', compact('data'));
    }

    /**
     * Filter a listing of the resource.
     *
     * @param  \App\Http\Requests\StudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(StudentRequest $request)
    {
        $where = collect($request->all())
            ->filter()
            ->forget(['gender', 'action'])
            ->toArray();

        if (isset($where['is_active'])) {
            $where['is_active'] = ($request->is_active == 'active') ? 1 : 0;
        }

        $student_session = StudentSession::withoutGlobalScope(ActiveScope::class)
            ->when($request->action == 'from_trash', fn($query) => $query->onlyTrashed())
            ->where($where)
            ->with([
                'student' => function($query){
                    $query->select(
                        'id',
                        'admission_no',
                        'roll_no',
                        'first_name',
                        'last_name',
                        'father_name'
                    );
                },
                'session',
                'section',
                'class',
                'group'
            ])
            ->whereHas('student', function($query) use($request){
                $query->when($request->gender, fn($query) => $query->where('gender', $request->gender));
            })
            ->get([
                'id',
                'student_id',
                'session_id',
                'class_id',
                'section_id',
                'group_id',
                'is_active',
                'deleted_at'
            ])
            ->map(function($student_session){
                $student_session['delete_at'] = $student_session->deleted_at?->diffForHumans();
                return $student_session;
            });

        return response()->success([
            'student_session' => $student_session
        ]);
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
            'page_title' => 'Create Student',
            'menu' => 'Student'
        ];

        return view('student.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StudentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        // Remove images parameters from request
        $data = $request->except([
            'student_image',
            'father_image',
            'mother_image',
            'guardian_image',
            'class_id',
            'section_id',
            'group_id'
        ]);

        // Upload student image
        if ($request->student_image) {
            $file_name = time() . '1.' . $request->student_image->extension();
            $request->student_image->move(public_path('uploads/student'), $file_name);
            $data['student_image'] = $file_name;
        }

        // Upload father image
        if ($request->father_image) {
            $file_name = time() . '2.' . $request->father_image->extension();
            $request->father_image->move(public_path('uploads/student/father'), $file_name);
            $data['father_image'] = $file_name;
        }

        // Upload mother image
        if ($request->mother_image) {
            $file_name = time() . '3.' . $request->mother_image->extension();
            $request->mother_image->move(public_path('uploads/student/mother'), $file_name);
            $data['mother_image'] = $file_name;
        }

        // Upload guardian image
        if ($request->guardian_image) {
            $file_name = time() . '4.' . $request->guardian_image->extension();
            $request->guardian_image->move(public_path('uploads/student/guardian'), $file_name);
            $data['guardian_image'] = $file_name;
        }

        $student = Student::create($data);

        // Store student into current session
        StudentSession::create([
            'student_id' => $student->id,
            'session_id' => $this->current_session_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'group_id' => $request->group_id
        ]);

        return response()->successMessage('Student Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        $classes = Classes::get();

        $data = [
            'student' => $student,
            'classes' => $classes,
            'page_title' => 'Edit Student',
            'menu' => 'Student'
        ];

        return view('student.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StudentRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $student = Student::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($student) {
            // Remove images parameters from request
            $data = $request->except([
                'student_image',
                'father_image',
                'mother_image',
                'guardian_image'
            ]);

            // Upload student image
            if ($request->student_image) {
                // Unlink Image
                $image_path = public_path('uploads/student/'.$student->student_image);
                if (is_file($image_path)) unlink($image_path);

                $file_name = time() . '1.' . $request->student_image->extension();
                $request->student_image->move(public_path('uploads/student'), $file_name);
                $data['student_image'] = $file_name;
            }

            // Upload father image
            if ($request->father_image) {
                // Unlink Image
                $image_path = public_path('uploads/student/father/'.$student->father_image);
                if (is_file($image_path)) unlink($image_path);

                $file_name = time() . '2.' . $request->father_image->extension();
                $request->father_image->move(public_path('uploads/student/father'), $file_name);
                $data['father_image'] = $file_name;
            }

            // Upload mother image
            if ($request->mother_image) {
                // Unlink Image
                $image_path = public_path('uploads/student/mother/'.$student->mother_image);
                if (is_file($image_path)) unlink($image_path);

                $file_name = time() . '3.' . $request->mother_image->extension();
                $request->mother_image->move(public_path('uploads/student/mother'), $file_name);
                $data['mother_image'] = $file_name;
            }

            // Upload guardian image
            if ($request->guardian_image) {
                // Unlink Image
                $image_path = public_path('uploads/student/guardian/'.$student->guardian_image);
                if (is_file($image_path)) unlink($image_path);

                $file_name = time() . '4.' . $request->guardian_image->extension();
                $request->guardian_image->move(public_path('uploads/student/guardian'), $file_name);
                $data['guardian_image'] = $file_name;
            }

            $student->update($data);
            return response()->successMessage('Student Updated Successfully!');
        }

        return response()->errorMessage('Student Not Found!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = StudentSession::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($student) {
            $student->delete();
            return response()->successMessage('Student Deleted Successfully !');
        }

        return response()->errorMessage('Student not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStudentStatus($id)
    {
        $student = StudentSession::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($student) {
            $data['is_active'] = ($student->is_active == 1) ? 0 : 1;
            $student->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Student not Found!');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $student_session = StudentSession::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->where('session_id', $this->current_session_id)
            ->with([
                'student' => function($query){
                    $query->select(
                        'id',
                        'admission_no',
                        'roll_no',
                        'first_name',
                        'last_name',
                        'father_name'
                    );
                },
                'session',
                'section',
                'class',
                'group'
            ])
            ->get([
                'id',
                'student_id',
                'session_id',
                'class_id',
                'section_id',
                'group_id',
                'deleted_at'
            ]);

        $sessions = Session::get();
        $classes = Classes::get();

        $data = [
            'student_session' => $student_session,
            'sessions' => $sessions,
            'classes' => $classes,
            'page_title' => 'Student Trash',
            'menu' => 'Student'
        ];

        return view('student.trash', compact('data'));
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
        $student_session = StudentSession::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($student_session) {
            $student_sessions_count = StudentSession::withoutGlobalScopes()
                ->where('student_id', $student_session->student_id)
                ->count();

            if ($student_sessions_count == 1) {
                Student::find($student_session->student_id)->delete();
            }

            $student_session->forceDelete();
            return response()->successMessage('Student Deleted Successfully !');
        }

        return response()->errorMessage('Student not Found !');
    }

    /**
     * Export the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(StudentRequest $request)
    {
        $session = Session::find($request->session_id)->name;
        $class = Classes::find($request->class_id)->name;
        $section = Section::find($request->section_id)->name;

        $file_name = "students-{$session}-{$class}-{$section}.xlsx";
        return Excel::download(new StudentsExport($request->all()), $file_name);
    }

    /**
     * Import the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(StudentRequest $request)
    {
        if ($request->method() == 'GET')
        {
            $classes = Classes::get();

            $data = [
                'classes' => $classes,
                'page_title' => 'Import Students',
                'menu' => 'Student'
            ];

            return view('student.import', compact('data'));   
        }

        if ($request->method() == 'POST')
        {
            try {
                $import = new StudentsImport($request->all());
                Excel::import($import, $request->import_file);
                return response()->successMessage("The {$import->getRowCount()} Students Imported Successfully !");
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                return response()->errors($e->failures());
            }
        }
    }

    /**
     * Download Importing Sample file.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadImportSample()
    {
         return Excel::download(new DownloadImportSample, 'students_import_sample.xlsx');
    }
}
