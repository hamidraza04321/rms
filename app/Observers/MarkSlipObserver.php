<?php

namespace App\Observers;

use App\Models\MarkSlip;
use Auth;

class MarkSlipObserver
{
    /**
     * Handle the MarkSlip "creating" event.
     *
     * @param  \App\Models\MarkSlip  $markslip
     * @return void
     */
    public function creating(MarkSlip $markslip)
    {
        $markslip->created_by = Auth::id();
    }

    /**
     * Handle the MarkSlip "updating" event.
     *
     * @param  \App\Models\MarkSlip  $markslip
     * @return void
     */
    public function updating(MarkSlip $markslip)
    {
        $markslip->updated_by = Auth::id();
    }

    /**
     * Handle the MarkSlip "deleted" event.
     *
     * @param  \App\Models\MarkSlip  $markslip
     * @return void
     */
    public function deleted(MarkSlip $markslip)
    {
        //
    }

    /**
     * Handle the MarkSlip "restored" event.
     *
     * @param  \App\Models\MarkSlip  $markslip
     * @return void
     */
    public function restored(MarkSlip $markslip)
    {
        //
    }

    /**
     * Handle the MarkSlip "force deleted" event.
     *
     * @param  \App\Models\MarkSlip  $markslip
     * @return void
     */
    public function forceDeleted(MarkSlip $markslip)
    {
        //
    }
}
