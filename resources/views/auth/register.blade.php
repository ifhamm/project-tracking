@extends('layouts.auth')

@section('auth-content')
    <div class="tabs">
        <button class="tab {{ request()->is('login') ? 'active' : '' }}" data-route="{{ route('login') }}">Sign In</button>
        <button class="tab {{ request()->is('register') ? 'active' : '' }}" data-route="{{ route('register') }}">Sign
            Up</button>
    </div>

    <div id="register-form" class="form-content active">
        <div class="form-header">
            <img src="https://img.icons8.com/fluency/96/airplane-take-off.png" alt="Register">
            <h1 class="form-title">Create Account</h1>
            <p class="form-subtitle">Start your journey with us</p>
        </div>

        @if ($errors->any())
            <div class="error-notification">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group">
                <i class="fas fa-signature input-icon"></i>
                <input type="text" name="nama_mekanik" class="form-input" placeholder="Full Name" autocomplete="name">
            </div>

            <div class="input-group">
                <i class="fas fa-id-card-alt input-icon"></i>
                <input type="text" name="username" class="form-input" placeholder="Username" autocomplete="username">
            </div>

            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="form-input" placeholder="Email Address" autocomplete="email">
            </div>

            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" class="form-input" placeholder="Password" autocomplete="new-password"
                    pattern="(?=.*\d)(?=.*[a-z]).{8,}"
                    title="Must contain at least one number, and at least 8 or more characters">
            </div>

            <button type="submit" name="submit" class="btn-primary">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign In</a>
        </div>
    </div>
@endsection
