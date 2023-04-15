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
        $class->sections->each->delete();   
        $class->groups->each->delete();
    }

    /**
     * Handle the Classes "restored" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function restored(Classes $class)
    {
        $class->sections()->withTrashed()->restore();   
        $class->groups()->withTrashed()->restore();
    }

    /**
     * Handle the Classes "force deleted" event.
     *
     * @param  \App\Models\Classes  $class
     * @return void
     */
    public function forceDeleted(Classes $class)
    {
        $class->sections->each->forceDelete();   
        $class->groups->each->forceDelete();
    }
}
