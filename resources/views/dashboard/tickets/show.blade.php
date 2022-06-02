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
                <p>Project: {{ $ticket->project }}</p>
            </div>
            <div class="dashboard-body">
                <p>Status: {{ $ticket->status }}</p>
                @if ($canAssign)
                    <form action="{{ route('dashboard.tickets.assign', $ticket->id)}}" method="POST" class='inline'>
                        @csrf
                        @method('PATCH')
                        <label for="agent">Agent:</label>
                        <select name="agent" id="agent">
                            <option value=''{{ $ticket->assigned_agent_id ? '' : 'selected'}}>None</option>
                            @forelse ($agents as $agent)
                                <option value='{{ $agent->id }}' {{ $ticket->assigned_agent_id === $agent->id ? 'selected' : ' '}}>{{ $agent->name }}</option>
                            @empty
                                <option disabled>No Agents</option>
                            @endforelse
                        </select>
                        <div class="form-buttons">
                            <button type="submit" class='btn btn-secondary'>Save Changes</button>
                        </div>
                    </form>
                    @if ($ticket->status === 'under review')
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
                    @if ($ticket->status !== 'under review')
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
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h2>Comments</h2>
                <p>Comments for ticket: {{ $ticket->subject }}</p>
            </div>
            <div class="dashboard-body">
                <form action="{{ route('dashboard.tickets.comment', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="body" class="col-md-4 col-form-label text-md-right">Comment</label>
                        <textarea name="body" rows='1' id="body" class='form-control'></textarea>
                    </div>
                    <div class='form-group' id="form-buttons" style='justify-content:flex-end;'>
                        <button class="btn btn-primary">Post</button>
                    </div>
                </form>
                @if ($hasComments)
                    <div class="comments-container">
                        <h3>Comments</h3>
                        @foreach ($comments as $comment)
                            <div class="comment">
                                <div class="comment-header">
                                    <h4>{{ $comment->name }}</h4>
                                    <p>Posted on: {{ date('m-d-Y', strtotime($comment->created_at)) }}</p>
                                </div>
                                <div class="comment-body">
                                    <p>{{ $comment->body }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection