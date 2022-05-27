@extends('layouts.app')
@section('title', 'Register')
@section('stylesheets')
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
@endsection
@section('content')
    <div id="auth-container">
        <form method="POST" action="{{ route('organization.update') }}">
            <h1>Update Organization</h1>
            @csrf
            <div class="form-group">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $organization->name }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="description" class="col-md-4 col-form-label text-md-right">Description (optional)</label>
                    <textarea id="description" rows='6' class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ old('description')  ?? $organization->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group mb-4" id="form-buttons">
                <a href='{{ route('dashboard.home') }}'class='btn btn-secondary'>Back</a>
                <div>
                    @if ($canResetPass)
                        <a href="{{ route('organization.password.edit') }}" class='btn btn-link'>Reset Password</a>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
    
@endsection