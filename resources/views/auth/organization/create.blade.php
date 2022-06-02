<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blunderr</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel='stylesheet' href='{{ asset('css/auth/auth.css') }}'>
</head>
<body>
    <div id="auth-container">
        <form method="POST" action="{{ route('organization.store') }}">
            <h1>Register Organization</h1>
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="owner">Owner</label>
                <input id="owner" type="text" name="owner" value='{{ Auth::user()->name}}' required disabled>
            </div>

            <div class="form-group">
                <label for="description">Description (optional)</label>
                    <textarea id="description" rows='11' maxLength='1500' class="{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                <label for="password">Organization Password</label>
                <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}" name="password-confirm" required>
                @if ($errors->has('password-confirm'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password-confirm') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group mb-4" id="form-buttons">
                <a href='{{ route('organization.join') }}'class='btn btn-secondary'>Back</a>
                <button type="submit" class="btn btn-primary">
                    Register Organization
                </button>
            </div>
        </form>
    </div>
</body>