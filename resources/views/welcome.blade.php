
@extends('layouts.app')
@section('title', 'Blunderr')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection
@section('content')
    <nav id="navbar">
        <div id="logo">
            Blunderr
        </div>
        <div id="auth-links">
            @guest
                <a href="{{ url('/login') }}" class='btn btn-secondary'>Login</a>
                <a href="{{ url('/register') }}" class='btn btn-primary'>Register</a>
            @else
                <a href="{{ route('dashboard.home') }}" class='btn btn-primary'>Enter Dashboard</a>
            @endguest
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class='display-1'>Blunderr</h1>
        <section id="about" class='mt-4'> 
            <h2>What is Blunderr?</h2>
            <p>
                Blunderr is a bug-tracking system built to make submitting help tickets easier for your clients. 
                When you register a project with Blunderr, you will have the ability to send their help tickets directly from their application 
                to your dashboard. From your dashboard you can edit the ticket, assign it to an agent, add comments a whole lot more! 
            </p>
        </section>
    </div>
@endsection