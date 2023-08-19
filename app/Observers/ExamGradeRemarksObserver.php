<?php

namespace App\Observers;

use App\Models\ExamGradeRemarks;
use Auth;

class ExamGradeRemarksObserver
{
    /**
     * Handle the ExamGradeRemarks "creating" event.
     *
     * @param  \App\Models\ExamGradeRemarks  $examGradeRemarks
     * @return void
     */
    public function creating(ExamGradeRemarks $examGradeRemarks)
    {
        $examGradeRemarks->created_by = Auth::id();
    }

    /**
     * Handle the ExamGradeRemarks "updating" event.
     *
     * @param  \App\Models\ExamGradeRemarks  $examGradeRemarks
     * @return void
     */
    public function updating(ExamGradeRemarks $examGradeRemarks)
    {
        $examGradeRemarks->updated_by = Auth::id();
    }

    /**
     * Handle the ExamGradeRemarks "deleted" event.
     *
     * @param  \App\Models\ExamGradeRemarks  $examGradeRemarks
     * @return void
     */
    public function deleted(ExamGradeRemarks $examGradeRemarks)
    {
        //
    }

    /**
     * Handle the ExamGradeRemarks "restored" event.
     *
     * @param  \App\Models\ExamGradeRemarks  $examGradeRemarks
     * @return void
     */
    public function restored(ExamGradeRemarks $examGradeRemarks)
    {
        //
    }

    /**
     * Handle the ExamGradeRemarks "force deleted" event.
     *
     * @param  \App\Models\ExamGradeRemarks  $examGradeRemarks
     * @return void
     */
    public function forceDeleted(ExamGradeRemarks $examGradeRemarks)
    {
        //
    }
}
