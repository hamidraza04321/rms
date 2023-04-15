<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Section;
use App\Models\Group;
use App\Models\Classes;
use App\Observers\SectionObserver;
use App\Observers\GroupObserver;
use App\Observers\ClassObserver;

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
    }
}
