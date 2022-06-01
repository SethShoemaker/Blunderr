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
                <h1>{{ $project->name }}</h1>
                <p>Registered: {{ date('m-d-Y', strtotime($project->created_at)) }}</p>
            </div>
            <div class="dashboard-body">
                <div class="dashboard-button">
                    @if($canEdit)
                        <button class='btn btn-secondary m-2 action-button'>Delete Project</button>
                        <div id="delete-confirm" class='action-prompt'>
                            <div class="action-content">
                                <h1>Confirm</h1>
                                <h2>Are you sure you want to delete this project?</h2>
                            </div>
                            <div class='action-buttons'>
                                <button class='btn btn-secondary action-cancel'>Cancel</button>
                                <a onclick="event.preventDefault(); document.getElementById('delete-form').submit();" class='btn btn-primary'>Delete</a>
                                <form id="delete-form" action="{{ route('dashboard.projects.destroy', $project->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form> 
                            </div>
                        </div>
                        <a href="{{ route('dashboard.projects.edit', $project->id) }}" class='btn btn-primary'>Edit Project</a>
                    @endif
                </div>
                <p>Description: {{ $project->description }}</p>
                <h2>Clients</h2>
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                            <tr class='org-row' data-href='{{ route('dashboard.members.show', $client->id)}}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">There are no clients registered to this project</td>
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
    <script src="{{ asset('js/dashboard/projects/show.js') }}"></script>
@endsection