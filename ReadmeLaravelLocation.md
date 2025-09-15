# 🌍 Laravel 12 Multilingual System with mcamara/laravel-localization

This guide documents how to fully implement a multilingual URL-based language system in **Laravel 12**, using the `mcamara/laravel-localization` package. It includes correct integration with modern Laravel 12 structure (no Kernel, all through `bootstrap/app.php`).

---

## 🧩 1. Install the Package

```bash
composer require mcamara/laravel-localization
```

---

## ⚙️ 2. Register the Service Provider in Laravel 12

In your `bootstrap/app.php`, inside the `->withProviders()` section:

```php
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(...)
    ->withMiddleware(...) // see below
    ->withProviders([
        LaravelLocalizationServiceProvider::class, //  Register here
    ])
    ->withExceptions(...)
    ->create();
```

---

## 🧱 3. Register Middleware Aliases (Laravel 12 style)

Also in `bootstrap/app.php`, inside `->withMiddleware(...)`:

```php
->withMiddleware(function (Middleware $middleware): void {
    // Register aliases required by the package
    $middleware->alias([
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localizationRedirect'  => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeViewPath'        => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);

})
```

---

## 📁 4. Create `config/laravellocalization.php` manually

Since Laravel 12 doesn't auto-publish config, manually create:

```
config/laravellocalization.php
```

With this content (includes `en`, `es`, `pt`):

```php
<?php

return [
    'supportedLocales' => [
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'regional' => 'en_GB',
            'iso_639_1' => 'en',
            'direction' => 'ltr',
            'plural_forms' => 'nplurals=2; plural=(n != 1);',
        ],
        'es' => [
            'name' => 'Spanish',
            'native' => 'Español',
            'regional' => 'es_ES',
            'iso_639_1' => 'es',
            'direction' => 'ltr',
            'plural_forms' => 'nplurals=2; plural=(n != 1);',
        ],
        'pt' => [
            'name' => 'Português',
            'native' => 'Português',
            'regional' => 'pt_BR',
            'iso_639_1' => 'pt',
            'direction' => 'ltr',
            'plural_forms' => 'nplurals=2; plural=(n != 1);',
        ],
    ],

    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,
    'defaultLocale' => 'en',
];
```

---

## 🌐 5. Modify `routes/web.php` to group routes by locale

```php
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ],
], function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('auth_management.users.index');
        });

        Route::prefix('setting_management')->name('setting_management.')->group(function () {
            Route::resource('countries', CountryController::class)->names('countries');
            Route::get('countries/{country}/delete',        [CountryController::class, 'delete'])->name('countries.delete');
            Route::delete('countries/{country}/deleteSave', [CountryController::class, 'deleteSave'])->name('countries.deleteSave');
        });

        Route::prefix('auth_management')->name('auth_management.')->group(function () {
            Route::resource('users', UserController::class)->names('users');
            Route::get('users/{user}/delete',        [UserController::class, 'delete'])->name('users.delete');
            Route::delete('users/{user}/deleteSave', [UserController::class, 'deleteSave'])->name('users.deleteSave');
        });
    });

    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'loginAccess'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
```

---

## 📝 6. Language Switcher in Layout

In any Blade layout file:

```blade
<a href="{{ LaravelLocalization::getLocalizedURL('es') }}">🇪🇸 Español</a>
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">🇺🇸 English</a>
<a href="{{ LaravelLocalization::getLocalizedURL('pt') }}">🇧🇷 Português</a>
```

---

## 📁 7. Translation Files Structure

```
lang/
├── en/global.php
├── es/global.php
└── pt/global.php
```

Each file returns key-value translations. Example:

```php
<?php
return [
    'app_name' => 'My Laravel System',
    'clear'    => 'Clear',
];
```

Use in Blade:

```blade
{{ __('global.clear') }}
{{ __('countries.name') }}
```

---

## ✅ Final Result

- `/en/setting_management/countries` → English UI  
- `/es/setting_management/countries` → Español  
- `/pt/setting_management/countries` → Português  

All URLs, routes, and translations are now localized and work with session, redirects, and view path detection.