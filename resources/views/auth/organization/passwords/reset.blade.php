@extends('layouts.app')
@section('title', 'Register')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <form method="POST" action="{{ route('organization.password.update') }}">
            <h1>Reset Password</h1>
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-right">New Organization Password</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm New Organization Password</label>
                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}" name="password-confirm" required>
                @if ($errors->has('password-confirm'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password-confirm') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group mb-4" id="form-buttons">
                <a href='{{ route('organization.edit') }}'class='btn btn-secondary'>Back</a>
                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
    
@endsection