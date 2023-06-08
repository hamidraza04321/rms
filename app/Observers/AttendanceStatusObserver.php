<?php

namespace App\Observers;

use App\Models\AttendanceStatus;
use Auth;

class AttendanceStatusObserver
{
    /**
     * Handle the AttendanceStatus "creating" event.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return void
     */
    public function creating(AttendanceStatus $attendanceStatus)
    {
        $attendanceStatus->created_by = Auth::id();
    }

    /**
     * Handle the AttendanceStatus "updating" event.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return void
     */
    public function updating(AttendanceStatus $attendanceStatus)
    {
        $attendanceStatus->updated_by = Auth::id();
    }

    /**
     * Handle the AttendanceStatus "deleted" event.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return void
     */
    public function deleted(AttendanceStatus $attendanceStatus)
    {
        //
    }

    /**
     * Handle the AttendanceStatus "restored" event.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return void
     */
    public function restored(AttendanceStatus $attendanceStatus)
    {
        //
    }

    /**
     * Handle the AttendanceStatus "force deleted" event.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return void
     */
    public function forceDeleted(AttendanceStatus $attendanceStatus)
    {
        //
    }
}
