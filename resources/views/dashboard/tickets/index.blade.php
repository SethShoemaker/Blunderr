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
                <h1>Tickets</h1>
                <p>List of all tickets</p>
            </div>
            <div class="dashboard-body body-table">
                @if ($isClient)
                    <div class="dashboard-button">
                        <a href="{{ route('dashboard.tickets.create') }}" class='btn btn-primary'>Submit Ticket</a>    
                    </div>
                @endif
                <div class="search-container">
                    <form action="{{ route('dashboard.tickets.index')}}" method="GET">
                        <input placeholder='search' type="text" name="search" id="search" role='search' value='{{ $search }}'>
                        <button class="btn btn-primary"><img src="{{ asset('images/icons/search.svg') }}" alt="Search"></button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Subject</th>
                            <th>Body</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr class='org-row' data-href='{{ route('dashboard.tickets.show', $ticket->id)}}'>
                                <td>{{ $ticket->project }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>{{ Str::limit($ticket->body, 20) }}</td>
                                <td class='{{ $ticket->status_id === 1 || $ticket->status_id === 3 ? 'highlight' : ' ' }}{{ $ticket->status_id === 4 ? 'success' : ' ' }}'>{{ $ticket->status }}</td>
                                <td>{{ date('m-d-Y', strtotime($ticket->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No tickets match this search</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection