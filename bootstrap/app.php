<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Laravel Plugin Languages
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
        ],
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
 
        // Laravel default middleware aliases
        $middleware->alias([
            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localizationRedirect'  => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeViewPath'        => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'api.key' => \App\Http\Middleware\ApiKeyMiddleware::class,
            'api.language' => \App\Http\Middleware\ApiLanguageMiddleware::class,
            'api.response.wrapper' => \App\Http\Middleware\ApiResponseWrapperMiddleware::class,
            'update.user.language' => \App\Http\Middleware\UpdateUserLanguageMiddleware::class,
        ]);
 
    })
    ->withProviders([
        LaravelLocalizationServiceProvider::class, // Laravel Localization Service Provider
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();