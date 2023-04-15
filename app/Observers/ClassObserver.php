<?php

namespace App\Observers;

use App\Models\Classes;
use Auth;

class ClassObserver
{
    /**
     * Handle the Classes "creating" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function creating(Classes $class)
    {
        $class->created_by = Auth::id();
    }

    /**
     * Handle the Classes "updating" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function updating(Classes $class)
    {
        $class->updated_by = Auth::id();
    }

    /**
     * Handle the Classes "deleted" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function deleted(Classes $class)
    {
        $class->sections()->delete();   
        $class->groups()->delete();
    }

    /**
     * Handle the Classes "restored" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function restored(Classes $class)
    {
        //
    }

    /**
     * Handle the Classes "force deleted" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function forceDeleted(Classes $class)
    {
        //
    }
}
