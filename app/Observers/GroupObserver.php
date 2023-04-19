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
     * Handle the Group "deleted" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function deleted(Group $group)
    {
        $group->groupClasses->each->delete();
    }

    /**
     * Handle the Group "restored" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function restored(Group $group)
    {
        $group->groupClasses()->withTrashed()->restore();
    }

    /**
     * Handle the Group "force deleted" event.
     *
     * @param  \App\Models\Group  $group
     * @return void
     */
    public function forceDeleted(Group $group)
    {
        $group->groupClasses->each->forceDelete();
    }
}
