@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>TICKETS</h1>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-button">
                @if ($isClient)
                    <a href="{{ route('dashboard.tickets.create') }}" class='btn btn-primary'>Submit Ticket</a>    
                @endif
            </div>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>
                            Project
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>
                            Body
                        </th>
                        <th>
                            Client
                        </th>
                        <th>
                            Date Submitted
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class='org-row' data-href='{{ route('dashboard.tickets.show', $ticket->id)}}'>
                            <td>
                                {{ $ticket->project }}
                            </td>
                            <td>
                                {{ $ticket->subject }}
                            </td>
                            <td>
                                {{ $ticket->body }}
                            </td>
                            <td>
                                {{ $ticket->client }}
                            </td>
                            <td>
                                {{ date('m-d-Y', strtotime($ticket->created_at)) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">There are no tickets</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection