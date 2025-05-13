<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(45deg, #3F72AF, #275194);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.158);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    rgba(99, 102, 241, 0.1) 0%,
                    rgba(14, 165, 233, 0.1) 50%,
                    rgba(99, 102, 241, 0.1) 100%);
            animation: rotate 15s linear infinite;
            z-index: -1;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header img {
            width: 80px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 15px rgba(99, 102, 241, 0.4));
        }

        .form-title {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-subtitle {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .input-group {
            margin-bottom: 24px;
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #456592;
            transition: 0.3s;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(255, 255, 255, 0.301);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            transition: 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .form-input:focus+.input-icon {
            color: #6366f1;
        }

        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(45deg, #0105f879, #30039b);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            color: #123666;
            font-size: 0.9rem;
        }

        .auth-link {
            color: #818cf8;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .auth-link:hover {
            color: #6366f1;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Switch between forms */
        .form-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tabs {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
        }

        .tab {
            flex: 1;
            padding: 12px;
            background: none;
            border: none;
            color: #9aa8bd;
            font-weight: 500;
            cursor: pointer;
            position: relative;
            transition: 0.3s;
        }

        .tab.active {
            color: white !important;
            font-weight: 600;
        }

        .tab::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #6366f1;
            transition: 0.3s;
        }

        .tab.active::after {
            width: 100%;
        }

        .error-notification {
            background: rgba(239, 68, 68, 0.15);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            color: #fff;
            font-size: 0.9rem;
            animation: slideIn 0.3s ease;
        }

        .error-notification ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .error-notification li {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-notification li::before {
            content: '\f06a';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: #ef4444;
            font-size: 0.8rem;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        @yield('auth-content')
    </div>

    @yield('scripts')
    <script>
        document.querySelectorAll('.tab').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                this.classList.add('active');
                setTimeout(() => {
                    window.location.href = this.getAttribute('data-route');
                }, 300);
            });
        });
    </script>
</body>

</html>
