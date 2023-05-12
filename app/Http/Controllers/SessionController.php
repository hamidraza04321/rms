<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Models\Session;
use App\Models\Scopes\ActiveScope;

class SessionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-session', [ 'only' => 'index' ]);
        $this->middleware('permission:create-session', [ 'only' => [ 'create', 'store' ]]);
        $this->middleware('permission:edit-session',   [ 'only' => [ 'edit', 'update' ]]);
        $this->middleware('permission:delete-session', [ 'only' => 'destroy' ]);
        $this->middleware('permission:update-session-status', [ 'only' => 'updateSessionStatus' ]);
        $this->middleware('permission:view-session-trash', [ 'only' => 'trash' ]);
        $this->middleware('permission:restore-session', [ 'only' => 'restore' ]);
        $this->middleware('permission:permanent-delete-session', [ 'only' => 'delete' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = Session::withoutGlobalScope(ActiveScope::class)->get();

        $data = [
            'sessions' => $sessions,
            'page_title' => 'Manage Sessions',
            'menu' => 'Session'
        ];

        return view('session.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'page_title' => 'Create Session',
            'menu' => 'Session'
        ];

        return view('session.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SessionRequest $request)
    {
        Session::create($request->validated()); 
        return response()->successMessage('Session Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)->findOrFail($id);

        $data = [
            'session' => $session,
            'page_title' => 'Edit Session',
            'menu' => 'Session'
        ];

        return view('session.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SessionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SessionRequest $request, $id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($session) {
            $session->update($request->validated());
            return response()->successMessage('Session Updated Successfully !');
        }

        return response()->successMessage('Session not Found !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($session) {
            $session->delete();
            return response()->successMessage('Session Deleted Successfully !');
        }

        return response()->errorMessage('Session not Found !');
    }

    /**
     * Display a listing of the Trash resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $sessions = Session::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->get();

        $data = [
            'sessions' => $sessions,
            'page_title' => 'Session Trash',
            'menu' => 'Session'
        ];

        return view('session.trash', compact('data'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)
            ->withTrashed()
            ->find($id);

        if ($session) {
            // Check if session exists with this name
            $exists = Session::withoutGlobalScope(ActiveScope::class)
                ->where('name', $session->name)
                ->exists();

            if (!$exists) {
                $session->restore();
                return response()->successMessage('Session Restored Successfully !');
            }

            return response()->errorMessage("The Session {$session->name} has already exists !");
        }

        return response()->errorMessage('Session not Found !');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)
            ->onlyTrashed()
            ->find($id);

        if ($session) {
            $session->forceDelete();
            return response()->successMessage('Session Deleted Successfully !');
        }

        return response()->errorMessage('Session not Found !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSessionStatus($id)
    {
        $session = Session::withoutGlobalScope(ActiveScope::class)->find($id);

        if ($session) {
            $data['is_active'] = ($session->is_active == 1) ? 0 : 1;
            $session->update($data);
            return response()->success($data);
        }

        return response()->errorMessage('Session not Found !');
    }
}
