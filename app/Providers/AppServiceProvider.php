<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Section;
use App\Models\Session;
use App\Models\Group;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use App\Models\StudentSession;
use App\Models\AttendanceStatus;
use App\Observers\SectionObserver;
use App\Observers\SessionObserver;
use App\Observers\GroupObserver;
use App\Observers\ClassObserver;
use App\Observers\SubjectObserver;
use App\Observers\UserObserver;
use App\Observers\StudentObserver;
use App\Observers\StudentSessionObserver;
use App\Observers\AttendanceStatusObserver;
use Illuminate\Support\Facades\View;
use App\Settings\GeneralSettings;

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
        Session::observe(SessionObserver::class);
        Classes::observe(ClassObserver::class);
        Section::observe(SectionObserver::class);
        Group::observe(GroupObserver::class);
        Subject::observe(SubjectObserver::class);
        User::observe(UserObserver::class);
        StudentSession::observe(StudentSessionObserver::class);
        AttendanceStatus::observe(AttendanceStatusObserver::class);

        // GENERAL SETTINGS TO ALL VIEW
        $settings = new GeneralSettings;
        View::share([ 'settings' => $settings ]);
    }
}
