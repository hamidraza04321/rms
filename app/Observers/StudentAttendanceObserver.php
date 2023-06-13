<?php

namespace App\Observers;

use App\Models\StudentAttendance;
use Auth;

class StudentAttendanceObserver
{
    /**
     * Handle the StudentAttendance "creating" event.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return void
     */
    public function creating(StudentAttendance $studentAttendance)
    {
        $studentAttendance->created_by = Auth::id();
    }

    /**
     * Handle the StudentAttendance "updating" event.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return void
     */
    public function updating(StudentAttendance $studentAttendance)
    {
        $studentAttendance->updated_by = Auth::id();
    }

    /**
     * Handle the StudentAttendance "deleted" event.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return void
     */
    public function deleted(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Handle the StudentAttendance "restored" event.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return void
     */
    public function restored(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Handle the StudentAttendance "force deleted" event.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return void
     */
    public function forceDeleted(StudentAttendance $studentAttendance)
    {
        //
    }
}
