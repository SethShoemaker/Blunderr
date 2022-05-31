@extends('layouts.app')
@section('title', 'Organization Members')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <h1>Members</h1>
                <p>List of all organization members</p>
            </div>
            <div class="dashboard-body">
                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr class='org-row' data-href='{{ route('dashboard.members.show', $member->id)}}'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td class='{{ $member->title ? '' : 'error' }}'>
                                    {{ $member->title ?? 'unassigned' }}
                                    @if ($member->title === 'client')
                                        ({{ $member->project }})
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
@endsection