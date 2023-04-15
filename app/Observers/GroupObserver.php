<?php

namespace App\Observers;

use App\Models\Group;
use Auth;

class GroupObserver
{
    /**
     * Handle the Group "creating" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function creating(Group $group)
    {
        $group->created_by = Auth::id();
    }

    /**
     * Handle the Group "updating" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function updating(Group $group)
    {
        $group->updated_by = Auth::id();
    }

    /**
     * Handle the Group "deleting" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function deleting(Group $group)
    {
        //
    }

    /**
     * Handle the Group "restored" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function restored(Group $group)
    {
        //
    }

    /**
     * Handle the Group "force deleted" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function forceDeleted(Group $group)
    {
        //
    }
}
