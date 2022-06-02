@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/home.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>{{ $heading }}</h1>
                <p>Registered on {{ date('m-d-Y', strtotime($created_at)) }}</p>
            </div>
            <div class="dashboard-body">
                @if ($canEdit)
                    <div class="dashboard-button">
                        <a href="{{ route('organization.edit')}}" class='btn btn-primary'>Update Organization</a>
                    </div>
                @endif
                <p>{{ $body }}</p>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection