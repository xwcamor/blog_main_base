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