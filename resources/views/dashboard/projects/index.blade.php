@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>Projects</h1>
        </div>
        <div class="dashboard-body">
            <div class="table-button">
                @if ($admin)
                    <a href="{{ route('dashboard.projects.create')}}" class='btn btn-primary'>Register New Project</a>    
                @endif
            </div>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Organization
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class='org-row' data-href='{{ route('dashboard.projects.show', $ticket->id)}}'>
                            <td>
                                {{ $project->name }}
                            </td>
                            <td>
                                {{ $project->organization }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">There are no registered projects</td>
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