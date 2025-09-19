<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Using Bootstrap Paginate
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


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

        // Compartir tenant_name en todas las vistas
        View::composer('*', function ($view) {
            $tenantName = null;

            if (Auth::check()) {
                // Cargar tenant solo si falta
                $user = Auth::user()->loadMissing('tenant');
                $tenantName = $user->tenant ? $user->tenant->name : null;
            }

            $view->with('tenant_name', $tenantName);
        });
    }

}
