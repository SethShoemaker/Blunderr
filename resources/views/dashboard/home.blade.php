@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
        </div>
        <div class="dashboard-body">
            <h2>{{ $organization->name }}</h2>
            <p>{{ $organization->description }}</p> 
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection