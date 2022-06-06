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
                <h1>Ticket: {{ $ticket->subject }}</h1>
                <p>Project: {{ $ticket->project }}</p>
            </div>
            <div class="dashboard-body body-split">
                <div class="split-left">
                    <div class="body-content">
                        <ul>
                            <li>Status:<span>{{ $ticket->status }}</span></li>
                            <li>Client:<span>{{ $ticketClientName }}</span></li> 
                            <li>Submitted:<span>{{ date('m-d-Y', strtotime($ticket->created_at)) }}</span></li>
                            @if ($canAssign && !$isComplete)
                                <form action="{{ route('dashboard.tickets.assign', $ticket->id)}}" method="POST" class='split'>
                                    @csrf
                                    @method('PATCH')
                                    <li>
                                        <label for="agent">Agent:</label>
                                        <span>
                                            <select name="agent" id="agent">
                                                <option value=''{{ $ticket->assigned_agent_id ? '' : 'selected'}}>None</option>
                                                @forelse ($agents as $agent)
                                                    <option value='{{ $agent->id }}' {{ $ticket->assigned_agent_id === $agent->id ? 'selected' : ' '}}>{{ $agent->name }}</option>
                                                @empty
                                                    <option disabled>No Agents</option>
                                                @endforelse
                                            </select>
                                        </span>
                                    </li>
                                    <li>
                                        <span class='form-button'>
                                            <button type="submit" class='btn btn-secondary'>Save Changes</button>
                                        </span>
                                    </li>
                                </form>
                                @if ($ticket->status === 'under review')
                                    <form action="{{ route('dashboard.tickets.approve', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <li>
                                            <span class="form-button">
                                                <button type="submit" class='btn btn-primary'>Approve Ticket</button>
                                            </span>
                                        </li>
                                        
                                    </form>
                                @endif
                            @elseif ($canSubmit)
                                <li>Agent:<span>{{ $ticketAgentName }}</span></li>
                                @if ($ticket->status !== 'under review')
                                    <form action="{{ route('dashboard.tickets.submit', $ticket->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <li>
                                            <span>
                                                <div class="form-button">
                                                    <button type="submit" class='btn btn-primary'>Submit Ticket</button>
                                                </div>
                                            </span>
                                        </li>
                                    </form>
                                @else
                                    <li>Ticket is under review</li>
                                @endif
                            @else
                                <li>Agent:<span>{{ $ticketAgentName }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="split-right">
                    <div class="body-content">
                        <p>Body: {{ $ticket->body }}</p>
                    </div>
                </div>
            </div> 
        </div>
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h2>Comments</h2>
                <p>Comments for ticket: {{ $ticket->subject }}</p>
            </div>
            <div class="dashboard-body body-comments">
                @if (!$isComplete)
                    <div class="comment-submit">
                        <form action="{{ route('dashboard.tickets.comment', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="body">Comment</label>
                                <textarea name="body" rows='1' id="body"></textarea>
                            </div>
                            <div class='form-group' id="form-buttons">
                                <button class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                @endif
                @if ($hasComments)
                    <div class="comments-list-container">
                        <h3>Comments</h3>
                        <ul>
                            @foreach ($comments as $comment)
                                <li>
                                    <div class="comment-header">
                                        <h4>{{ $comment->name }}</h4>
                                        <p>Posted on: {{ date('m-d-Y', strtotime($comment->created_at)) }}</p>
                                    </div>
                                    <div class="comment-body">
                                        <p>{{ $comment->body }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection