
@extends('layouts.app')
@section('title', 'Blunderr')
@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection
@section('content')
<div id="auth-container">
    <form method="POST" action="{{ route('dashboard.tickets.store') }}">
        <h1>Submit Ticket</h1>
        @csrf

        <div class="form-group">
            <label for="project" class="col-form-label text-md-right">Project</label>
            <input id="project" type="text" class="form-control" value="{{ $project }}" required disabled>
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label text-md-right">Project</label>
            <select name="type" id="type">
                @foreach ($ticketTypes as $ticketType)
                    <option value='{{ $ticketType->id }}'>{{ $ticketType->type }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject" class="col-form-label text-md-right">Subject</label>
            <input id="subject" type="text" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject') }}" required autofocus>
            @if ($errors->has('subject'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('subject') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="body" class="col-form-label text-md-right">Body</label>
            <textarea id="body" rows='11' maxLength='1500' class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body">{{ old('body') }}</textarea>
            @if ($errors->has('body'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb-4" id="form-buttons">
            <a href="{{ route('dashboard.tickets.index') }}" class='btn btn-secondary'>Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection