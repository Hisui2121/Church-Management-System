<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Policies\MemberPolicy;
use App\Policies\MemberStatusPolicy;

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

        //Gates
        Gate::define('view_dashboard', function ($user) {
            return $user->hasPermission('view_dashboard');
        });

        Gate::define('view_audit_logs', function ($user) {
            return $user->hasPermission('view_audit_logs');
        });
    }
}
