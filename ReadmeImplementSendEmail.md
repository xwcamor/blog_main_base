# Implementación de Envío de Correos y Reseteo de Contraseña en Laravel 11

Este documento detalla todos los pasos y el código utilizado para implementar la funcionalidad de "Olvidé mi contraseña".

---

### Paso 1: Creación de la Tabla de Tokens

Laravel necesita una tabla para almacenar los tokens de reseteo de contraseña. 

1.  **Se creó la migración** con el siguiente comando:
    ```bash
    php artisan make:migration create_password_reset_tokens_table
    ```

2.  **Se escribió el esquema** en el archivo de migración resultante:
    ```php
    // database/migrations/xxxx_xx_xx_xxxxxx_create_password_reset_tokens_table.php
    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('password_reset_tokens');
        }
    };
    ```

3.  **Se ejecutó la migración**:
    ```bash
    php artisan migrate
    ```

### Paso 2: Implementación de Rutas (Enfoque Laravel 11)

Para Laravel 11, en lugar de usar controladores completos, se optó por una implementación moderna usando closures en el archivo de rutas y la fachada `Password`.

1.  **Se eliminaron los controladores** `ForgotPasswordController` y `ResetPasswordController` que se crearon inicialmente.

2.  **Se actualizaron las rutas** en `routes/web.php` para manejar la lógica directamente:

    ```php
    // routes/web.php

    // Se añadieron estas declaraciones 'use' al inicio del archivo:
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Support\Facades\Hash;

    // ... (otras rutas)

    // Forgot password
    Route::get('password/reset', function () {
        return view('auth_management.auth.passwords.email');
    })->middleware('guest')->name('password.request');

    Route::post('password/email', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.email');

    Route::get('password/reset/{token}', function ($token, Request $request) {
        return view('auth_management.auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    })->middleware('guest')->name('password.reset');

    Route::post('password/reset', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.update');
    ```

### Paso 3: Creación de las Vistas

Se crearon dos vistas de Blade para la interfaz de usuario.

1.  **Vista para solicitar el enlace** (`resources/views/auth_management/auth/passwords/email.blade.php`):
    ```blade
    @extends('layouts.login')
    @section('title', __('passwords.request_title'))
    @section('content')
    <div class="card shadow-lg">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <a href="{{ url('/') }}"><b>{{ config('app.name', 'Laravel') }}</b></a>
            </div>
            <p class="login-box-msg">{{ __('passwords.request_message') }}</p>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="POST" autocomplete="off" data-parsley-validate>
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('users.email') }}" required autofocus data-parsley-type="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('passwords.send_reset_link') }}</button>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1 text-center">
                <a href="{{ route('login') }}">{{ __('login.login') }}</a>
            </p>
        </div>
    </div>
    @endsection
    ```

2.  **Vista para restablecer la contraseña** (`resources/views/auth_management/auth/passwords/reset.blade.php`):
    ```blade
    @extends('layouts.login')
    @section('title', __('passwords.reset_title'))
    @section('content')
    <div class="card shadow-lg">
        <div class="card-body login-card-body">
            <div class="login-logo">
                <a href="{{ url('/') }}"><b>{{ config('app.name', 'Laravel') }}</b></a>
            </div>
            <p class="login-box-msg">{{ __('passwords.reset_message') }}</p>
            <form action="{{ route('password.update') }}" method="POST" autocomplete="off" data-parsley-validate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" placeholder="{{ __('users.email') }}" required autofocus data-parsley-type="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('users.password') }}" required data-parsley-minlength="8">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('users.password_confirmation') }}" required data-parsley-equalto="#password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('passwords.reset_password_button') }}</button>
                    </div>
                </div>
            </form>
            <p class="mt-3 mb-1 text-center">
                <a href="{{ route('login') }}">{{ __('login.login') }}</a>
            </p>
        </div>
    </div>
    @endsection
    ```

### Paso 4: Integración y Archivos de Idioma

1.  **Se actualizó el enlace** en `resources/views/auth_management/auth/login.blade.php`:
    ```html
    <a href="{{ route('password.request') }}">{{ __('login.forgot_password') }}</a>
    ```

2.  **Se crearon los archivos de idioma** para los nuevos textos en `resources/lang/en/passwords.php` y `resources/lang/es/passwords.php`.
    ```php
    // resources/lang/es/passwords.php
    <?php
    return [
        'reset' => '¡Tu contraseña ha sido restablecida!',
        'sent' => '¡Hemos enviado por correo electrónico el enlace para restablecer tu contraseña!',
        'throttled' => 'Por favor, espera antes de volver a intentarlo.',
        'token' => 'Este token de restablecimiento de contraseña no es válido.',
        'user' => "No podemos encontrar un usuario con esa dirección de correo electrónico.",
        // Líneas personalizadas
        'request_title' => 'Olvidé mi Contraseña',
        'request_message' => 'Ingresa tu correo para recibir un enlace de restablecimiento de contraseña.',
        'send_reset_link' => 'Enviar Enlace de Restablecimiento',
        'reset_title' => 'Restablecer Contraseña',
        'reset_message' => 'Ingresa tu nueva contraseña.',
        'reset_password_button' => 'Restablecer Contraseña',
    ];
    ```

### Paso 5: Configuración del Entorno (`.env`)

Se le indicó al usuario que para enviar correos reales (en lugar de solo registrarlos en el log), debe configurar las variables de correo en su archivo `.env`.

**Ejemplo para Gmail:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo@gmail.com
MAIL_PASSWORD=tu_contraseña_de_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu_correo@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```
