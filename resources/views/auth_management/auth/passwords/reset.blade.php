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
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" placeholder="{{ __('users.email') }}" required autofocus data-parsley-type="email" readonly>
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
            <a href="{{ route('login') }}">{{ __('global.cancel') }}</a>
        </p>
    </div>
</div>
@endsection