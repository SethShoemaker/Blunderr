@extends('layouts.app')
@section('title', 'Forgot Password')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <form method="POST" action="{{ route('password.email') }}">   
            @if(session('status'))
                {{ session('status')}}
            @endif 
            <h1>Forgot Password</h1>
            @csrf
            <div class="form-group">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group" id='form-buttons'>
                <a href="{{ url('/login') }}" class='btn btn-secondary'>Back</a>
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
@endsection