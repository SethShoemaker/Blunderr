@extends('layouts.app')
@section('title', 'Verify Email')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id='auth-container'>
        <h1>Verify Email</h1>
        <p class="auth-details">
            You must verify your email to proceed, check your email for verfication email.
        </p>
        <div id='test-verification'>
            <a href="{{ url('/dashboard') }}" class='btn btn-primary'>Test Verifcation</a>
        </div>
    </div>
@endsection