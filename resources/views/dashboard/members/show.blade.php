@extends('layouts.app')
@section('title', 'Dashboard')
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
            @if ($canEdit)
                <form action="{{ route('dashboard.members.update', $member->id) }}" method='POST'>
                    @csrf
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-secondary">Remove User</button>
                    <button class="btn btn-primary">Save Changes</button>
                </form>
            @else
                {{ $member->title ?? 'unassigned' }}
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection