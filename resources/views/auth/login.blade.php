@extends('layouts.auth')

@section('auth-content')
    <div class="tabs">
        <button class="tab {{ request()->is('login') ? 'active' : '' }}" data-route="{{ route('login') }}">Sign In</button>
        <button class="tab {{ request()->is('register') ? 'active' : '' }}" data-route="{{ route('register') }}">Sign
            Up</button>
    </div>

    <div class="form-content active">
        <div class="form-header">
            <img src="https://img.icons8.com/fluency/96/airport.png" alt="Airport">
            <h1 class="form-title">Welcome Back</h1>
            <p class="form-subtitle">Sign in to continue to your dashboard</p>
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

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" class="form-input" placeholder="Email Address"
                    value="{{ old('email') }}" required autofocus>
            </div>

            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>

        <div class="auth-footer">
            Forgot password? <a href="#" class="auth-link">Reset here</a>
        </div>
    </div>
@endsection
