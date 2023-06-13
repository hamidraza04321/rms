<?php

namespace App\Http\Controllers;

use App\Models\Scopes\ActiveScope;
use App\Http\Requests\AttendanceStatusRequest;
use App\Models\AttendanceStatus;

class AttendanceStatusController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-attendance-status', [ 'only' => 'index' ]);
        $this->middleware('permission:create-attendance-status', [ 'only' => [ 'create', 'store' ]]);
        $this->middleware('permission:edit-attendance-status',   [ 'only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:delete-attendance-status', [ 'only' => 'destroy' ]);
        $this->middleware('permission:update-attendance-status', [ 'only' => 'updateSubjectStatus' ]);
        $this->middleware('permission:view-attendance-status-trash', [ 'only' => 'trash' ]);
        $this->middleware('permission:restore-attendance-status', [ 'only' => 'restore' ]);
        $this->middleware('permission:permanent-delete-attendance-status', [ 'only' => 'delete' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance_statuses = AttendanceStatus::withoutGlobalScope(ActiveScope::class)->get();

        $data = [
            'attendance_statuses' => $attendance_statuses,
            'page_title' => 'Manage Attendance Status',
            'menu' => 'Attendance Status'
        ];

        return view('attendance-status.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Attendance Status',
            'menu' => 'Attendance Status'
        ];

        return view('attendance-status.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AttendanceStatusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendanceStatusRequest $request)
    {
        AttendanceStatus::create($request->validated()); 
        return response()->successMessage('Attendance Status Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)->findOrFail($id);

        $data = [
            'attendance_status' => $attendance_status,
            'page_title' => 'Edit Attendance Status',
            'menu' => 'Attendance Status'
        ];

        return view('attendance-status.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AttendanceStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttendanceStatusRequest $request, $id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($attendance_status) {
            $data = $request->validated();
            $data['show_in_result_card'] = $request->show_in_result_card;
            $attendance_status->update($data);
            return response()->successMessage('Attendance Status Updated Successfully!');
        }

        return response()->successMessage('Attendance Status not Found!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($attendance_status) {
            $attendance_status->delete();
            return response()->successMessage('Attendance Status Deleted Successfully!');
        }

        return response()->errorMessage('Attendance Status not Found!');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $attendance_statuses = AttendanceStatus::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

        $data = [
            'attendance_statuses' => $attendance_statuses,
            'page_title' => 'Attendance Status Trash',
            'menu' => 'Attendance Status'
        ];

        return view('attendance-status.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($attendance_status) {
            // Check if attendance status exists with this name or short code
            $exists = AttendanceStatus::withoutGlobalScope(ActiveScope::class)
                ->where('name', $attendance_status->name)
                ->orWhere('short_code', $attendance_status->short_code)
                ->first();

            if (!$exists) {
                $attendance_status->restore();
                return response()->successMessage('Attendance Status Restored Successfully!');
            }

            if ($attendance_status->name == $exists->name) {
                return response()->errorMessage("The Attendance Status with name {$attendance_status->name} has already exists!");
            }

            if ($attendance_status->short_code == $exists->short_code) {
                return response()->errorMessage("The Attendance Status with short code {$attendance_status->short_code} has already exists!");
            }
        }

        return response()->errorMessage('Attendance Status not Found!');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->find($id);

        if ($attendance_status) {
            $attendance_status->forceDelete();
            return response()->successMessage('Attendance Status Deleted Successfully!');
        }

        return response()->errorMessage('Attendance Status not Found!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAttendanceStatus($id)
    {
        $attendance_status = AttendanceStatus::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($attendance_status) {
            $data['is_active'] = ($attendance_status->is_active == 1) ? 0 : 1;
            $attendance_status->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Attendance Status not Found!');
    }
}
