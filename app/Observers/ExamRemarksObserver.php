<?php

namespace App\Observers;

use App\Models\ExamRemarks;
use Auth;

class ExamRemarksObserver
{
    /**
     * Handle the ExamRemarks "creating" event.
     *
     * @param  \App\Models\ExamRemarks  $examRemarks
     * @return void
     */
    public function creating(ExamRemarks $examRemarks)
    {
        $examRemarks->created_by = Auth::id();
    }

    /**
     * Handle the ExamRemarks "updating" event.
     *
     * @param  \App\Models\ExamRemarks  $examRemarks
     * @return void
     */
    public function updating(ExamRemarks $examRemarks)
    {
        $examRemarks->updated_by = Auth::id();
    }

    /**
     * Handle the ExamRemarks "deleted" event.
     *
     * @param  \App\Models\ExamRemarks  $examRemarks
     * @return void
     */
    public function deleted(ExamRemarks $examRemarks)
    {
        //
    }

    /**
     * Handle the ExamRemarks "restored" event.
     *
     * @param  \App\Models\ExamRemarks  $examRemarks
     * @return void
     */
    public function restored(ExamRemarks $examRemarks)
    {
        //
    }

    /**
     * Handle the ExamRemarks "force deleted" event.
     *
     * @param  \App\Models\ExamRemarks  $examRemarks
     * @return void
     */
    public function forceDeleted(ExamRemarks $examRemarks)
    {
        //
    }
}
