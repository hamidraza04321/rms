<?php

namespace App\Observers;

use App\Models\Session;
use Auth;

class SessionObserver
{
    /**
     * Handle the Session "creating" event.
     *
     * @param  \App\Models\Session  $session
     * @return void
     */
    public function creating(Session $session)
    {
        $session->created_by = Auth::id();
    }

    /**
     * Handle the Session "updating" event.
     *
     * @param  \App\Models\Session  $session
     * @return void
     */
    public function updating(Session $session)
    {
        $session->updated_by = Auth::id();
    }

    /**
     * Handle the Session "deleted" event.
     *
     * @param  \App\Models\Session  $session
     * @return void
     */
    public function deleted(Session $session)
    {
        //
    }

    /**
     * Handle the Session "restored" event.
     *
     * @param  \App\Models\Session  $session
     * @return void
     */
    public function restored(Session $session)
    {
        //
    }

    /**
     * Handle the Session "force deleted" event.
     *
     * @param  \App\Models\Session  $session
     * @return void
     */
    public function forceDeleted(Session $session)
    {
        //
    }
}
