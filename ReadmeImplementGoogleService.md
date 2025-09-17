
# Implementación de Login con Google (Laravel Socialite)

Este documento detalla todos los pasos y el código utilizado para implementar el inicio de sesión y registro de usuarios a través de Google.

---

### Paso 1: Instalar Laravel Socialite

Se añadió el paquete oficial de Laravel para OAuth al proyecto.

```bash
composer require laravel/socialite
```

### Paso 2: Modificar la Base de Datos

Para asociar la cuenta de Google con un usuario, se modificó la tabla `users`.

1.  **Se creó una nueva migración** para añadir la columna `google_id` y hacer que la contraseña sea opcional.
    ```bash
    php artisan make:migration add_google_id_to_users_table --table=users
    ```

2.  **Se definió el esquema** en el archivo de migración:
    ```php
    // database/migrations/xxxx_xx_xx_xxxxxx_add_google_id_to_users_table.php
    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('google_id')->nullable()->unique()->after('id');
                $table->string('password')->nullable()->change();
            });
        }

        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('google_id');
                $table->string('password')->nullable(false)->change();
            });
        }
    };
    ```

3.  **Se ejecutó la migración específica**:
    ```bash
    php artisan migrate --path=database/migrations/2025_09_15_195808_add_google_id_to_users_table.php
    ```

### Paso 3: Configurar Credenciales de Servicio

1.  **Se actualizó `config/services.php`** para que Socialite pueda leer las credenciales de Google desde el archivo `.env`.
    ```php
    // config/services.php
    return [
        // ... otros servicios
        'google' => [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect' => env('GOOGLE_REDIRECT_URI'),
        ],
    ];
    ```

2.  **Se instruyó al usuario** para que obtenga sus credenciales de la Consola de Google Cloud y las añada a su archivo `.env`.
    ```env
    # .env
    GOOGLE_CLIENT_ID=your-google-client-id-from-console
    GOOGLE_CLIENT_SECRET=your-google-client-secret-from-console
    GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
    ```
    También se le indicó configurar los **Orígenes de JavaScript autorizados** (`http://127.0.0.1:8000`) y los **URIs de redireccionamiento autorizados** (`http://127.0.0.1:8000/auth/google/callback`) en la consola de Google.

### Paso 4: Crear el Controlador de Lógica

Se creó un controlador para manejar la redirección a Google y el procesamiento de la respuesta (callback).

**Controlador:** `app/Http/Controllers/AuthManagement/Auth/GoogleLoginController.php`
```php
<?php

namespace App\Http\Controllers\AuthManagement\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Si el usuario ya existe por google_id, lo logueamos
            $user = User::where('google_id', $googleUser->id)->first();
            if ($user) {
                Auth::login($user);
                return redirect()->intended('/');
            }

            // Si no, buscamos si existe por email para enlazar la cuenta
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                $user->update(['google_id' => $googleUser->id]);
                Auth::login($user);
                return redirect()->intended('/');
            }
            
            // Si no existe de ninguna forma, lo creamos
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make(Str::random(24)), // Contraseña aleatoria
                'slug' => Str::random(22),
                'photo' => $googleUser->avatar,
            ]);

            Auth::login($newUser);
            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Algo salió mal o rechazaste la aplicación.');
        }
    }
}
```

### Paso 5: Añadir las Rutas

Se añadieron las rutas en `routes/web.php` para el flujo de autenticación de Google.

```php
// routes/web.php

// Se añadió la declaración 'use'
use App\Http\Controllers\AuthManagement\Auth\GoogleLoginController;

// ...

// Google Login Routes
Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
```

### Paso 6: Actualizar la Vista de Login

Se modificó el botón "Login con Google" en `resources/views/auth_management/auth/login.blade.php` para que apunte a la nueva ruta de redirección.

```html
<a href="{{ route('auth.google.redirect') }}" class="btn btn-block btn-secondary">
  <i class="fab fa-google mr-2"></i> {{ __('login.login_google') }}
</a>
```

### Paso 7: Limpiar la Caché

Finalmente, se limpió la caché de la aplicación para asegurar que todas las nuevas configuraciones y rutas se cargaran correctamente.

```bash
php artisan optimize:clear
```