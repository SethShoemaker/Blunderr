@extends('layouts.app')
@section('title', $member->name)
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>Member: {{ $member->name }}</h1>
                <p>Registered: {{ date('m-d-Y', strtotime($member->created_at)) }}</p>
            </div>
            <div class="dashboard-body">
                <div class="body-content">
                    <p>Email: {{ $member->email }}</p>
                    @if ($canEdit)
                        <form action="{{ route('dashboard.members.update', $member->id) }}" method='POST' class='inline' id='edit-form'>
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select name="role" id="role" class="form-control form-select {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                    <option value='' {{ $member->role ? '' : 'selected'}}>Unassigned</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $member->role === $role->title ? 'selected' : ''}}>{{ $role->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group' id='project-group'>
                                <label for="project">Project:</label>
                                <select name="project" id="project" class="form-control form-select {{ $errors->has('project') ? ' is-invalid' : '' }}">
                                    <option {{ $member->project ? '' : 'selected' }} disabled>Select</option>
                                    @forelse ($projects as $project)
                                        <option value='{{ $project->id}}' {{ $member->project === $project->name ? 'selected' : ' '}}>{{ $project->name }}</option>
                                    @empty
                                        <option disabled>No Registered Projects</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class='form-group' id='form-buttons'>
                                <button class="btn btn-primary">Save&nbsp;Changes</button>
                            </div>
                        </form>
                    @elseif($member->role === 'client')
                        <p>Role: {{ $member->role}} for {{ $member->project }}</p>
                    @else
                        <p>Role: {{ $member->role ?? 'unassigned' }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
    @if ($canEdit)
        <script src="{{ asset('js/dashboard/members/show.js') }}"></script>
    @endif
@endsection