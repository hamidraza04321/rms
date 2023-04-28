<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Section;
use App\Models\Group;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Observers\SectionObserver;
use App\Observers\GroupObserver;
use App\Observers\ClassObserver;
use App\Observers\SubjectObserver;
use App\Observers\UserObserver;
use App\Observers\StudentObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // OBSERVERS
        Classes::observe(ClassObserver::class);
        Section::observe(SectionObserver::class);
        Group::observe(GroupObserver::class);
        Subject::observe(SubjectObserver::class);
        User::observe(UserObserver::class);
        Student::observe(StudentObserver::class);
    }
}
