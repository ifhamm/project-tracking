<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $statusCode }} - Error | Aircraft Component Tracking</title>
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

        .error-container {
            background: rgba(255, 255, 255, 0.158);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 60px 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    rgba(220, 53, 69, 0.1) 0%,
                    rgba(255, 193, 7, 0.1) 50%,
                    rgba(220, 53, 69, 0.1) 100%);
            animation: rotate 15s linear infinite;
            z-index: -1;
        }

        .error-icon {
            font-size: 8rem;
            color: #dc3545;
            margin-bottom: 30px;
            filter: drop-shadow(0 0 20px rgba(220, 53, 69, 0.4));
            animation: pulse 2s ease-in-out infinite;
        }

        .error-code {
            font-size: 4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .error-title {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .error-message {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .error-description {
            color: #cbd5e1;
            font-size: 1rem;
            margin-bottom: 40px;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(45deg, #0105f879, #30039b);
            color: #fff;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
            color: #fff;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: #fff;
        }

        .error-info {
            margin-top: 40px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .error-info h4 {
            color: #fff;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .error-info p {
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 40px 20px;
            }
            
            .error-code {
                font-size: 3rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <div class="error-code">{{ $statusCode }}</div>
        
        <h1 class="error-title">
            @switch($statusCode)
                @case(400)
                    Bad Request
                    @break
                @case(401)
                    Unauthorized
                    @break
                @case(404)
                    Page Not Found
                    @break
                @case(405)
                    Method Not Allowed
                    @break
                @case(408)
                    Request Timeout
                    @break
                @case(429)
                    Too Many Requests
                    @break
                @case(500)
                    Internal Server Error
                    @break
                @case(502)
                    Bad Gateway
                    @break
                @case(503)
                    Service Unavailable
                    @break
                @case(504)
                    Gateway Timeout
                    @break
                @default
                    Error Occurred
            @endswitch
        </h1>
        
        <p class="error-message">
            {{ $message ?? 'Terjadi kesalahan yang tidak terduga.' }}
        </p>
        
        <p class="error-description">
            Mohon coba lagi nanti atau hubungi administrator jika masalah berlanjut.
        </p>
        
        <div class="action-buttons">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Kembali ke Beranda
            </a>
            
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
        
        <div class="error-info">
            <h4><i class="fas fa-info-circle"></i> Informasi Error</h4>
            <p>
                Error Code: {{ $statusCode }} | 
                @if($statusCode >= 400 && $statusCode < 500)
                    Client Error
                @elseif($statusCode >= 500)
                    Server Error
                @else
                    Other Error
                @endif
            </p>
        </div>
    </div>
</body>

</html> 