@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/home.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>{{ $organization->name }}</h1>
        </div>
        <div class="dashboard-body">
            @if ($canEdit)
                <div class="dashboard-button">
                    <a href="{{ route('organization.edit')}}" class='btn btn-primary'>Update Organization</a>
                </div>
            @endif
            <p>{{ $organization->description }}</p>
            <div class="home-panels">
                <div class="home-panel">
                    
                </div>
            </div>
            <h2>{{ $numProjects }} Projects</h2>
            <h2>{{ $numTickets }} Tickets</h2>
            <h2>{{ $numMembers }} Members</h2>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection