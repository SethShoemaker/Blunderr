@extends('layouts.app')
@section('title', 'Login')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <form method="POST" action="{{ route('login') }}">
            <h1>Login</h1>
            @csrf
            <div class="form-group">
                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <span>Remember Me</span>
                    </label>
                </div>
            </div>

            <div class="form-group mb-4" id="form-buttons">
                <a href="{{ route('welcome') }}" class='btn btn-secondary'>Cancel</a>
                <div>
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Reset Password
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection