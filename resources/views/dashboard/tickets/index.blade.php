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
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>
                            Organization
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Owner
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class='org-row' data-href='{{ route('dashboard.ticket.show', $ticket->id)}}'>
                            <td>
                                {{ $ticket->name }}
                            </td>
                            <td>
                                {{ $ticket->description }}
                            </td>
                            <td>
                                {{ $ticket->owner }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">There are no tickets</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection