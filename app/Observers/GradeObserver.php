<?php

namespace App\Observers;

use App\Models\Grade;
use Auth;

class GradeObserver
{
    /**
     * Handle the Grade "creating" event.
     *
     * @param  \App\Models\Grade  $grade
     * @return void
     */
    public function creating(Grade $grade)
    {
        $grade->created_by = Auth::id();
    }

    /**
     * Handle the Grade "updating" event.
     *
     * @param  \App\Models\Grade  $grade
     * @return void
     */
    public function updating(Grade $grade)
    {
        $grade->updated_by = Auth::id();
    }

    /**
     * Handle the Grade "deleted" event.
     *
     * @param  \App\Models\Grade  $grade
     * @return void
     */
    public function deleted(Grade $grade)
    {
        //
    }

    /**
     * Handle the Grade "restored" event.
     *
     * @param  \App\Models\Grade  $grade
     * @return void
     */
    public function restored(Grade $grade)
    {
        //
    }

    /**
     * Handle the Grade "force deleted" event.
     *
     * @param  \App\Models\Grade  $grade
     * @return void
     */
    public function forceDeleted(Grade $grade)
    {
        //
    }
}
