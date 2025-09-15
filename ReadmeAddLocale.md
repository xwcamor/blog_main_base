# 🌐 Laravel 12 - Multilanguage System using Session and Middleware

This project implements dynamic language switching in Laravel 12 (v12.28+) using routes, middleware, and translation files in the `lang/` directory.

---

## 📁 Translation File Structure

Place your language files here:

```
/lang
  ├── en/global.php
  ├── es/global.php
  └── pt/global.php
```

Example content (`lang/en/global.php`):

```php
<?php
return [
    'app_name' => 'My Laravel System',
    'clear'    => 'Clear',
];
```

---

## 🧩 Using Translations in Views

To display translated text, use the `__()` helper in your Blade templates:

```blade
{{ __('global.app_name') }}
{{ __('global.clear') }}
```

This will automatically pull the text from the corresponding file in `lang/{locale}/global.php` based on the active locale.

---

## 🔁 Routes

In `routes/web.php`:

```php
use App\Http\Controllers\LocaleController;

Route::get('locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
```

---

## 🎮 Controller

File: `app/Http/Controllers/LocaleController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch($locale, Request $request)
    {
        Session::put('locale', $locale);
        App::setLocale($locale);

        // Redirects to the previous page without query string
        return redirect()->back();
    }
}
```

---

## 🧩 Custom Middleware

File: `app/Http/Middleware/SetLocale.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->has('locale')) {
            $locale = $request->get('locale');
            session(['locale' => $locale]);
        }

        $locale = session('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
```

---

## ⚙️ Register Global Middleware (Laravel 12 style)

Edit `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    // Apply SetLocale middleware to the "web" group
    $middleware->web([
        \App\Http\Middleware\SetLocale::class,
    ]);
})
```

---

## 🌍 Language Switch Links in Main Layout

In your Blade layout (`layouts/app.blade.php` or similar):

```blade
<a href="{{ request()->fullUrlWithQuery(['locale' => 'es']) }}">Español</a>
<a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}">English</a>
<a href="{{ request()->fullUrlWithQuery(['locale' => 'pt']) }}">Português</a>
```

This keeps the current URL and adds `?locale=xx` to trigger the middleware.

---

## 🧼 Cache Cleanup (optional)

```bash
php artisan optimize:clear
```

---

## ✅ Result

- Dynamic language switching without reloading routes.
- Language persists across requests via `session`.
- Fully compatible middleware with Laravel 12.