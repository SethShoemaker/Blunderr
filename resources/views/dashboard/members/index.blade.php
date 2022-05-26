@extends('layouts.app')
@section('title', 'Dashboard')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
    @include('dashboard.inc.nav')
    <div class="dashboard-viewport">
        <div class="dashboard-header">
            <h1>Members</h1>
        </div>
        <div class="dashboard-body">
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Role
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr class='org-row' data-href='{{ route('dashboard.members.show', $member->id)}}'>
                            <td>
                                {{ $member->id }}
                            </td>
                            <td>
                                {{ $member->name }}
                            </td>
                            <td>
                                {{ $member->role ?? 'unassigned' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">There are no registered members</td>
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