@extends('layouts.app')
@section('title', 'Register')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <h1>Await Assignemnt</h1>
        <p>Please wait for your organization owners to assign you a role</p>
        <div id="form-buttons">
            <a href="{{ route('logout') }}" class='btn btn-secondary' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            <a href="{{ route('dashboard.home') }}" class='btn btn-primary'>Enter Dashboard</a>
        </div>
    </div>
@endsection