@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/tickets/show.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>Ticket: {{ $ticket->subject }}</h1>
                <p>Project: {{ $ticketProjectName }}</p>
            </div>
            <div class="dashboard-body">
                <p>Status: {{ $ticketStatus }}</p>
                @if ($canAssign)
                    <form action="{{ route('dashboard.tickets.assign', $ticket->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="agent">Agent:</label>
                            <select name="agent" id="agent">
                                <option value=''{{ $ticket->assigned_agent_id ? '' : 'selected'}}>None</option>
                                @forelse ($agents as $agent)
                                    <option value='{{ $agent->id }}' {{ $ticket->assigned_agent_id === $agent->id ? 'selected' : ' '}}>{{ $agent->name }}</option>
                                @empty
                                    <option disabled>No Agents</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" class='btn btn-secondary'>Save Changes</button>
                        </div>
                    </form>
                    @if ($ticketStatus === 'under review')
                        <form action="{{ route('dashboard.tickets.approve', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-buttons">
                                <button type="submit" class='btn btn-primary'>Approve Ticket</button>
                            </div>
                        </form>
                    @endif
                @elseif ($canSubmit)
                    <p>Agent: {{ $ticketAgentName }}</p>
                    @if ($ticketStatus !== 'under review')
                        <form action="{{ route('dashboard.tickets.submit', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-buttons mb-2">
                                <button type="submit" class='btn btn-primary'>Submit Ticket</button>
                            </div>
                        </form>
                    @else
                        <p><strong>Ticket is under review</strong></p>
                    @endif
                @else
                    <p>Agent: {{ $ticketAgentName }}</p>
                @endif
                <p>Body: {{ $ticket->body }}</p>
                <p>Client: {{ $ticketClientName }}</p>
                <p>Submitted: {{ date('m-d-Y', strtotime($ticket->created_at)) }}</p>
            </div> 
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection