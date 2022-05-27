
@extends('layouts.app')
@section('title', 'Blunderr')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection
@section('content')
<div id="auth-container">
    <form method="POST" action="{{ route('dashboard.projects.store') }}">
        <h1>Register Project</h1>
        @csrf

        <div class="form-group">
            <label for="name" class="col-form-label text-md-right">Name</label>
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="description" class="col-form-label text-md-right">Description (optional)</label>
            <textarea id="description" rows='11' maxLength='1500' class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb-4" id="form-buttons">
            <a href="{{ route('dashboard.projects.index') }}" class='btn btn-secondary'>Cancel</a>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</div>
@endsection