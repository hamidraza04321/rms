<?php

namespace App\Observers;

use App\Models\StudentSession;
use Auth;

class StudentSessionObserver
{
    /**
     * Handle the Student "creating" event.
     *
     * @param  \App\Models\StudentSession  $student_session
     * @return void
     */
    public function creating(StudentSession $student_session)
    {
        $student_session->created_by = Auth::id();
    }

    /**
     * Handle the Student "updating" event.
     *
     * @param  \App\Models\StudentSession  $student_session
     * @return void
     */
    public function updating(StudentSession $student_session)
    {
        $student_session->updated_by = Auth::id();
    }

    /**
     * Handle the Student "deleted" event.
     *
     * @param  \App\Models\StudentSession  $student_session
     * @return void
     */
    public function deleted(StudentSession $student_session)
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     *
     * @param  \App\Models\StudentSession  $student_session
     * @return void
     */
    public function restored(StudentSession $student_session)
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     *
     * @param  \App\Models\StudentSession  $student_session
     * @return void
     */
    public function forceDeleted(StudentSession $student_session)
    {
        //
    }
}
