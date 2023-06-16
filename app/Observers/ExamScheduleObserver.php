<?php

namespace App\Observers;

use App\Models\ExamSchedule;
use Auth;

class ExamScheduleObserver
{
    /**
     * Handle the ExamSchedule "creating" event.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return void
     */
    public function creating(ExamSchedule $examSchedule)
    {
        $examSchedule->created_by = Auth::id();
    }

    /**
     * Handle the ExamSchedule "updating" event.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return void
     */
    public function updating(ExamSchedule $examSchedule)
    {
        $examSchedule->updated_by = Auth::id();
    }

    /**
     * Handle the ExamSchedule "deleted" event.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return void
     */
    public function deleted(ExamSchedule $examSchedule)
    {
        //
    }

    /**
     * Handle the ExamSchedule "restored" event.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return void
     */
    public function restored(ExamSchedule $examSchedule)
    {
        //
    }

    /**
     * Handle the ExamSchedule "force deleted" event.
     *
     * @param  \App\Models\ExamSchedule  $examSchedule
     * @return void
     */
    public function forceDeleted(ExamSchedule $examSchedule)
    {
        //
    }
}
