<?php

namespace App\Observers;

use App\Models\Section;
use Auth;

class SectionObserver
{
    /**
     * Handle the Section "creating" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function creating(Section $section)
    {
        $section->created_by = Auth::id();
    }

    /**
     * Handle the Section "updating" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function updating(Section $section)
    {
        $section->updated_by = Auth::id();
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleted(Section $section)
    {
        $section->sectionClasses->each->delete();
    }

    /**
     * Handle the Section "restored" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function restored(Section $section)
    {
        //
    }

    /**
     * Handle the Section "force deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function forceDeleted(Section $section)
    {
        //
    }
}
