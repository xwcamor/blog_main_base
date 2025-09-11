<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Call Paginate Style from Bootstrap
use Illuminate\Pagination\Paginator;


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
    }
}
