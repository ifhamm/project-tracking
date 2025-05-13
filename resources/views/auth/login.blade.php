@extends('layouts.auth')

@section('auth-content')
    <div class="tabs">
        <button class="tab {{ request()->is('login') ? 'active' : '' }}" data-route="{{ route('loginUser') }}">Sign In</button>
        <button class="tab {{ request()->is('register') ? 'active' : '' }}" data-route="{{ route('register') }}">Sign
            Up</button>
    </div>

    <div class="form-content active" id="loginSuperAdmin">
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

        <form method="POST" action="{{ route('loginSuperAdmin') }}">
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
            Are you a Mekanik or PM? <a href="#" onclick="toggleLoginForm('ppc')" class="auth-link">Click here</a>
        </div>
    </div>

    <div class="form-content active" id="loginUser">
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

        <form method="POST" action="{{ route('loginUser') }}">
            @csrf
            <div class="input-group">
                <i class="fa-solid fa-address-card input-icon"></i>
                <input type="text" name="nik" class="form-input" placeholder="NIK"
                    value="{{ old('nik') }}" required autofocus>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>

        <div class="auth-footer">
            Are you a Super Admin or PPC? <a href="#" onclick="toggleLoginForm('user')" class="auth-link">Click here</a>
        </div>
    </div>
@endsection
