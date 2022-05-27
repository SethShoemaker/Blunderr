@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>Projects</h1>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-button">
                @if ($canCreate)
                    <a href="{{ route('dashboard.projects.create') }}" class='btn btn-primary'>Register New Project</a>    
                @endif
            </div>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Created
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class='org-row' data-href='{{ route('dashboard.projects.show', $project->id)}}'>
                            <td>
                                {{ $project->name }}
                            </td>
                            <td>
                                {{ $project->created_at->format('m/d/y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">There are projects registered to {{ $orgName }}</td>
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