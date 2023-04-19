<?php

namespace App\Observers;

use App\Models\Subject;
use Auth;

class SubjectObserver
{
    /**
     * Handle the Subject "creating" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function creating(Subject $subject)
    {
        $subject->created_by = Auth::id();
    }

    /**
     * Handle the Subject "updating" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function updating(Subject $subject)
    {
        $subject->updated_by = Auth::id();
    }

    /**
     * Handle the Subject "deleted" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function deleted(Subject $subject)
    {
        $subject->subjectClasses->each->delete();
    }

    /**
     * Handle the Subject "restored" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function restored(Subject $subject)
    {
        $subject->subjectClasses()->withTrashed()->restore();
    }

    /**
     * Handle the Subject "force deleted" event.
     *
     * @param  \App\Models\Subject  $subject
     * @return void
     */
    public function forceDeleted(Subject $subject)
    {
        $subject->subjectClasses->each->forceDelete(); 
    }
}
