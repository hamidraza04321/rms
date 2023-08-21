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
use App\Models\StudentAttendance;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\ExamScheduleCategory;
use App\Models\ExamRemarks;
use App\Models\ExamGradeRemarks;
use App\Models\MarkSlip;
use App\Observers\SectionObserver;
use App\Observers\SessionObserver;
use App\Observers\GroupObserver;
use App\Observers\ClassObserver;
use App\Observers\SubjectObserver;
use App\Observers\UserObserver;
use App\Observers\StudentObserver;
use App\Observers\StudentSessionObserver;
use App\Observers\AttendanceStatusObserver;
use App\Observers\StudentAttendanceObserver;
use App\Observers\ExamObserver;
use App\Observers\ExamScheduleObserver;
use App\Observers\ExamScheduleCategoryObserver;
use App\Observers\ExamGradeRemarksObserver;
use App\Observers\ExamRemarksObserver;
use App\Observers\MarkSlipObserver;
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
        StudentAttendance::observe(StudentAttendanceObserver::class);
        Exam::observe(ExamObserver::class);
        ExamSchedule::observe(ExamScheduleObserver::class);
        ExamScheduleCategory::observe(ExamScheduleCategoryObserver::class);
        ExamRemarks::observe(ExamRemarksObserver::class);
        ExamGradeRemarks::observe(ExamGradeRemarksObserver::class);
        MarkSlip::observe(MarkSlipObserver::class);

        // GENERAL SETTINGS TO ALL VIEW
        $settings = new GeneralSettings;
        View::share([ 'settings' => $settings ]);
    }
}
