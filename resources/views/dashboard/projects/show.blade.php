@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>{{ $project->name }}</h1>
        </div>
        <div class="dashboard-body">
            <div class="dashboard-button">
                @if($canEdit)
                    <a href="{{ route('dashboard.projects.edit', $project->id) }}" class='btn btn-primary'>Edit Project</a>
                @endif
            </div>
            <p>Registered on {{ date('m-d-Y', strtotime($project->created_at)) }}</p>
            <p>{{ $project->description }}</p>
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
                    @foreach($clients as $client)
                        <tr class='org-row' data-href='{{ route('dashboard.members.show', $client->id)}}'>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection