@extends('layouts.app')
@section('title', 'Organization Projects')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>Projects</h1>
                <p>List of all projects</p>
            </div>
            <div class="dashboard-body body-table">
                <div class="dashboard-button">
                    @if ($canCreate)
                        <a href="{{ route('dashboard.projects.create') }}" class='btn btn-primary'>Register New Project</a>    
                    @endif
                </div>
                <div class="search-container">
                    <form action="{{ route('dashboard.projects.index') }}" method="GET">
                        <input placeholder="search" type="text" name="search" id="search" role='search' value='{{ $search }}'>
                        <button class="btn btn-primary"><img src="{{ asset('images/icons/search.svg') }}" alt="Search"></button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th> 
                            <th>Description</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class='org-row' data-href='{{ route('dashboard.projects.show', $project->id)}}'>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ Str::limit($project->description, 20) }}</td>
                                <td>{{ $project->created_at->format('m/d/y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No projects match this search</td>
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