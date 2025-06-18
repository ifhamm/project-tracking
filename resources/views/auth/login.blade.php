<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aircraft Component Tracking</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0f2a4a;
            --secondary-color: #1a3a5f;
            --accent-color: #007bff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-muted: #6c757d;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        .login-body {
            padding: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating .form-control {
            border-radius: 12px;
            border: 2px solid var(--border-color);
            padding: 1rem 1rem;
            height: auto;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-floating label {
            padding: 1rem 1rem;
            color: var(--text-muted);
        }

        .form-floating .form-control:focus ~ label,
        .form-floating .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            color: var(--accent-color);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent-color), #0056b3);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .brand-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .nav-tabs .nav-link.active { background: var(--accent-color); color: #fff; border-radius: 12px 12px 0 0; }
        .nav-tabs .nav-link { border: none; color: var(--primary-color); font-weight: 600; }
        .tab-content { margin-top: 1.5rem; }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                margin: 0;
                border-radius: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .login-header {
                padding: 1.5rem;
            }

            .login-body {
                padding: 1.5rem;
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .brand-icon {
                font-size: 2.5rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="brand-icon">
                <i class="bi bi-airplane"></i>
            </div>
            <h1>Aircraft Component Tracking</h1>
            <p>Login untuk mengakses sistem</p>
        </div>

        <div class="login-body">
            <ul class="nav nav-tabs justify-content-center" id="loginTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="superadmin-tab" data-bs-toggle="tab" data-bs-target="#superadmin" type="button" role="tab" aria-controls="superadmin" aria-selected="true">
                        Superadmin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false">
                        PM / Mekanik / PPC
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="loginTabContent">
                <!-- Superadmin Login -->
                <div class="tab-pane fade show active" id="superadmin" role="tabpanel" aria-labelledby="superadmin-tab">
                    @if (session('error') && old('login_type') === 'superadmin')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    <form action="{{ route('loginSuperAdmin') }}" method="POST" id="superadminForm">
                        @csrf
                        <input type="hidden" name="login_type" value="superadmin">
                        <div class="form-floating">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                            <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                            <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-login" id="superadminBtn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>
                </div>
                <!-- User Login -->
                <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                    @if (session('error') && old('login_type') === 'user')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    <form action="{{ route('loginUser') }}" method="POST" id="userForm">
                        @csrf
                        <input type="hidden" name="login_type" value="user">
                        <div class="form-floating">
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" placeholder="NIK" value="{{ old('nik') }}" required minlength="8" maxlength="20">
                            <label for="nik"><i class="bi bi-person-badge me-2"></i>NIK</label>
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-login" id="userBtn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Sistem terjamin keamanannya
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab persistence on error
            @if (old('login_type') === 'user')
                var userTab = new bootstrap.Tab(document.getElementById('user-tab'));
                userTab.show();
            @endif
            // Loading animation
            const superadminForm = document.getElementById('superadminForm');
            const superadminBtn = document.getElementById('superadminBtn');
            if (superadminForm) {
                superadminForm.addEventListener('submit', function() {
                    const originalText = superadminBtn.innerHTML;
                    superadminBtn.innerHTML = '<span class="loading"></span> Logging in...';
                    superadminBtn.disabled = true;
                    setTimeout(() => {
                        superadminBtn.innerHTML = originalText;
                        superadminBtn.disabled = false;
                    }, 10000);
                });
            }
            const userForm = document.getElementById('userForm');
            const userBtn = document.getElementById('userBtn');
            if (userForm) {
                userForm.addEventListener('submit', function() {
                    const originalText = userBtn.innerHTML;
                    userBtn.innerHTML = '<span class="loading"></span> Logging in...';
                    userBtn.disabled = true;
                    setTimeout(() => {
                        userBtn.innerHTML = originalText;
                        userBtn.disabled = false;
                    }, 10000);
                });
            }
            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>

</html>