<?php

namespace App\Observers;

use App\Models\Exam;
use Auth;

class ExamObserver
{
    /**
     * Handle the Exam "creating" event.
     *
     * @param  \App\Models\Exam  $exam
     * @return void
     */
    public function creating(Exam $exam)
    {
        $exam->created_by = Auth::id();
    }

    /**
     * Handle the Exam "updating" event.
     *
     * @param  \App\Models\Exam  $exam
     * @return void
     */
    public function updating(Exam $exam)
    {
        $exam->updated_by = Auth::id();
    }

    /**
     * Handle the Exam "deleted" event.
     *
     * @param  \App\Models\Exam  $exam
     * @return void
     */
    public function deleted(Exam $exam)
    {
        //
    }

    /**
     * Handle the Exam "restored" event.
     *
     * @param  \App\Models\Exam  $exam
     * @return void
     */
    public function restored(Exam $exam)
    {
        //
    }

    /**
     * Handle the Exam "force deleted" event.
     *
     * @param  \App\Models\Exam  $exam
     * @return void
     */
    public function forceDeleted(Exam $exam)
    {
        //
    }
}
