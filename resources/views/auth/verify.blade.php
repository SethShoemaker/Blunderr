@extends('layouts.app')
@section('title', 'Verify Email')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id='auth-container'>
        <h1>Verify Email</h1>
        <p>
            Click the link sent to {{ Auth::user()->email }}
        </p>

        <div class="form-group" id="form-buttons">
            <a class="btn btn-secondary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            <a class="btn btn-primary" href="{{ route('verification.send') }}" onclick="event.preventDefault(); document.getElementById('verify-form').submit();">Resend Email</a>
                <form id="verify-form" action="{{ route('verification.send') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </div>
@endsection