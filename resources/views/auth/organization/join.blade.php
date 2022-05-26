@extends('layouts.app')
@section('title', 'Register')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <form method="POST" action="{{ route('organization.join') }}">
            <h1>Join Organization</h1>
            <h2>Step 3 of 3</h2>
            @csrf

            <div class="form-group">
                <label for="name" class="col-md-4 col-form-label text-md-right">Organization Name</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-right">Organization Password</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group mb-4" id="form-buttons">
                <a href="{{ route('logout') }}" class='btn btn-secondary' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <div>
                    <a href="{{ route('organization.create') }}" class='btn btn-link'>Create new organization</a>
                    <button type="submit" class="btn btn-primary">
                        Join Organization
                    </button>
                </div>
            </div>
        </form>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form> 
    </div>
@endsection