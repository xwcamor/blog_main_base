<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Using Bootstrap Paginate
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

// Models and Observers
use App\Models\SystemModule;
use App\Observers\SystemModuleObserver;


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
        // Call Boostrap on paginate
        Paginator::useBootstrap();

        // Register Observers 
        SystemModule::observe(SystemModuleObserver::class);

        // Share tenant_name in all views
        View::composer('*', function ($view) {
            $tenantName = null;

            if (Auth::check()) {
                // Load and rescue tenant relationship
                $user = Auth::user()->loadMissing('tenant');
                $tenantName = $user->tenant ? $user->tenant->name : null;
            }

            $view->with('tenant_name', $tenantName);
        });
    }

}