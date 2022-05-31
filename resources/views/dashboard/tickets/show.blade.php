@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>Ticket</h1>
                <p>Submitted on {{ date('m-d-Y', strtotime($ticket->created_at)) }}</p>
            </div>
            <div class="dashboard-body">
                <h2>Subject: {{ $ticket->subject }}</h2>
                <h3>Client: {{ $ticket->client }}</h3>
                <p>{{ $ticket->body }}</p>
            </div> 
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection