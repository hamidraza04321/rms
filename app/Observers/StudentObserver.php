<?php

namespace App\Observers;

use App\Models\Student;
use Auth;

class StudentObserver
{
    /**
     * Handle the Student "creating" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function creating(Student $student)
    {
        $student->created_by = Auth::id();
    }

    /**
     * Handle the Student "updating" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function updating(Student $student)
    {
        $student->updated_by = Auth::id();
    }

    /**
     * Handle the Student "deleted" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function deleted(Student $student)
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function restored(Student $student)
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function forceDeleted(Student $student)
    {
        //
    }
}
