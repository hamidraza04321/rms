<?php

namespace App\Observers;

use App\Models\ExamScheduleCategory;
use Auth;

class ExamScheduleCategoryObserver
{
    /**
     * Handle the ExamScheduleCategory "creating" event.
     *
     * @param  \App\Models\ExamScheduleCategory  $examScheduleCategory
     * @return void
     */
    public function creating(ExamScheduleCategory $examScheduleCategory)
    {
        $examScheduleCategory->created_by = Auth::id();
    }

    /**
     * Handle the ExamScheduleCategory "updating" event.
     *
     * @param  \App\Models\ExamScheduleCategory  $examScheduleCategory
     * @return void
     */
    public function updating(ExamScheduleCategory $examScheduleCategory)
    {
        $examScheduleCategory->updated_by = Auth::id();
    }

    /**
     * Handle the ExamScheduleCategory "deleted" event.
     *
     * @param  \App\Models\ExamScheduleCategory  $examScheduleCategory
     * @return void
     */
    public function deleted(ExamScheduleCategory $examScheduleCategory)
    {
        //
    }

    /**
     * Handle the ExamScheduleCategory "restored" event.
     *
     * @param  \App\Models\ExamScheduleCategory  $examScheduleCategory
     * @return void
     */
    public function restored(ExamScheduleCategory $examScheduleCategory)
    {
        //
    }

    /**
     * Handle the ExamScheduleCategory "force deleted" event.
     *
     * @param  \App\Models\ExamScheduleCategory  $examScheduleCategory
     * @return void
     */
    public function forceDeleted(ExamScheduleCategory $examScheduleCategory)
    {
        //
    }
}
