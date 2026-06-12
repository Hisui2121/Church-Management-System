<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\User;
use App\Models\Ministry;
use App\Models\Announcement;
use App\Policies\MemberPolicy;
use App\Policies\MemberStatusPolicy;
use App\Observers\UserObserver;
use App\Observers\MinistryObserver;
use App\Observers\AnnouncementObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Register Policies
        Gate::policy(Member::class, MemberPolicy::class);
        Gate::policy(MemberStatus::class, MemberStatusPolicy::class);

        //Register Model Observers
        User::observe(UserObserver::class);
        Ministry::observe(MinistryObserver::class);
        Announcement::observe(AnnouncementObserver::class);
    }
}
