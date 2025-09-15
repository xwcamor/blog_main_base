@extends('layouts.login')

@section('title', __('login.login'))

@section('content')
<div class="card shadow-lg">
  <div class="row no-gutters">
    <div class="col-12 text-center bg-info text-white py-3" >
      <b>{{ config('app.name') }}</b>
    </div>

    {{-- Left Side: login --}}
    <div class="col-md-8 p-4">
      <div class="text-center mb-3">
        <a class="h1 text-dark"><b>{{ __('global.app_name') }}</b></a>
      </div>

      <form id="form-save" action="{{ route('login.post') }}" method="POST" autocomplete="off" data-parsley-validate>
        @csrf
        {{-- Email --}}
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" data-parsley-errors-container="#email-error" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('users.email')]) }}" required data-parsley-type="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div id="email-error"></div>

        {{-- Password --}}
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" data-parsley-errors-container="#password-error" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('users.password')]) }}" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="password-error"></div>

        {{-- Remember + Submit --}}
        <div class="row">
          <div class="col-6">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember"> {{ __('login.rememberme') }} </label>
            </div>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block btn_submit"><i class="fas fa-sign-in-alt"></i>  {{ __('login.login') }}</button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center mt-3 mb-2">
        <a href="#" class="btn btn-block btn-secondary">
          <i class="fab fa-google mr-2"></i> {{ __('login.login_google') }}
        </a>
      </div>

      <p class="mb-1 text-center pt-2">
        <a href="forgot-password.html">{{ __('login.forgot_password') }}</a>
      </p>

      <p class="text-center text-sm mt-3">
        {!! __('global.disclosure', [
          'terms' => '<a href="' . route('terms') . '" target="_blank">' . __('global.terms') . '</a>',
          'privacy' => '<a href="' . route('privacy') . '" target="_blank">' . __('global.privacy') . '</a>',
        ]) !!}
      </p>

    </div>

    {{-- Right Side: image --}}
    <div class="col-md-4 d-none d-md-block">
      <img id="login-avatar"
          src="{{ asset('adminlte/img/login_avatar.gif') }}"
          data-default="{{ asset('adminlte/img/login_avatar.gif') }}"
          data-email="{{ asset('adminlte/img/login_avatar_email.png') }}"
          data-pass="{{ asset('adminlte/img/login_avatar_password.png') }}"
          alt="Imagen de login"
          class="img-fluid h-100 w-100"
          style="object-fit: cover; border-top-right-radius: .25rem; border-bottom-right-radius: .25rem;">
    </div>

  </div>
  <div class="card-footer small text-muted py-1">
    <p class="mb-0 text-start" style="font-size: 0.65rem;">
      {{ __('login.disclaimer_affiliation', ['app' => config('app.name')]) }}
    </p>

    <p class="mb-0 text-start" style="font-size: 0.65rem;">
      {{ __('login.client_content_responsibility') }}
    </p>

    <p class="mb-0 text-center">
      © {{ now()->year }} {{ config('app.name') }} – {{ __('login.all_rights_reserved') }}
    </p>    
  </div>
</div>

{{-- Language Selector --}}
<div class="text-center my-2">
  <select onchange="location = this.value;" class="form-select form-select-sm w-auto d-inline-block">
    <option value="{{ LaravelLocalization::getLocalizedURL('es', null, [], true) }}" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>Español</option>
    <option value="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
    <option value="{{ LaravelLocalization::getLocalizedURL('pt', null, [], true) }}" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>Português</option>
  </select>
</div>

@endsection 