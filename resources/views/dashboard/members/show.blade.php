@extends('layouts.app')
@section('title', $member->name)
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/members/show.css')}}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>{{ $member->name }}</h1>
        </div>
        <div class="dashboard-body">
            <p>Email: {{ $member->email }}</p>
            <p>Registered: {{ date('m-d-Y', strtotime($member->created_at)) }}</p>
            @if ($canEdit)
                <div id="edit-container">
                    <form action="{{ route('dashboard.members.update', $member->id) }}" method='POST' id='edit-form'>
                        @csrf
                        <div class="form-group">
                            <label for="role" class="col-form-label text-md-right">Role:</label>
                            <select name="role" id="role" class="form-control form-select {{ $errors->has('role') ? ' is-invalid' : '' }}">
                                <option value='' {{ $member->role ? '' : 'selected'}}>Unassigned</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $member->role === $role->title ? 'selected' : ''}}>{{ $role->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id='project-group'>
                            <label for="project" class="col-form-label text-md-right">Project:</label>
                            <select name="project" id="project" class="form-control form-select {{ $errors->has('project') ? ' is-invalid' : '' }}">
                                @forelse ($projects as $project)
                                    <option value='{{ $project->id}}'>{{ $project->name }}</option>
                                @empty
                                    <option disabled>No Registered Projects</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group" id='form-buttons'>
                            <a href='{{ route('dashboard.members.index') }}'class="btn btn-secondary">Cancel</a>
                            <button class="btn btn-primary">Save&nbsp;Changes</button>
                        </div>
                    </form>
                </div>
            @elseif($member->role === 'client')
                <p>Role: {{ $member->role}} for {{ $member->project }}</p>
            @else
                <p>Role: {{ $member->role ?? 'unassigned' }}</p>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
    @if ($canEdit)
        <script src="{{ asset('js/dashboard/members/show.js') }}"></script>
    @endif
@endsection