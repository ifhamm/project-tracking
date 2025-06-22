<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Aircraft Component Tracking</title>
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
                    rgba(255, 193, 7, 0.1) 0%,
                    rgba(220, 53, 69, 0.1) 50%,
                    rgba(255, 193, 7, 0.1) 100%);
            animation: rotate 15s linear infinite;
            z-index: -1;
        }

        .error-icon {
            font-size: 8rem;
            color: #ffc107;
            margin-bottom: 30px;
            filter: drop-shadow(0 0 20px rgba(255, 193, 7, 0.4));
            animation: float 3s ease-in-out infinite;
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

        .helpful-links {
            margin-top: 40px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .helpful-links h4 {
            color: #fff;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .link-item {
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .link-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .link-item a {
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .link-item a:hover {
            color: #fff;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
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

            .links-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-search"></i>
        </div>
        
        <div class="error-code">404</div>
        
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        
        <p class="error-message">
            Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
        </p>
        
        <p class="error-description">
            URL yang Anda masukkan mungkin salah atau halaman telah dihapus dari server.
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
        
        <div class="helpful-links">
            <h4><i class="fas fa-link"></i> Halaman Populer</h4>
            <div class="links-grid">
                <div class="link-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </div>
                <div class="link-item">
                    <a href="{{ url('/komponen') }}">
                        <i class="fas fa-cogs"></i>
                        Komponen
                    </a>
                </div>
                <div class="link-item">
                    <a href="{{ url('/proses-mekanik') }}">
                        <i class="fas fa-tools"></i>
                        Proses Mekanik
                    </a>
                </div>
                <div class="link-item">
                    <a href="{{ url('/dokumentasi-mekanik') }}">
                        <i class="fas fa-file-alt"></i>
                        Dokumentasi
                    </a>
                </div>
                <div class="link-item">
                    <a href="{{ url('/breakdown_parts') }}">
                        <i class="fas fa-list"></i>
                        Breakdown Parts
                    </a>
                </div>
                <div class="link-item">
                    <a href="{{ url('/add-mekanik-PM') }}">
                        <i class="fas fa-user-plus"></i>
                        Tambah Mekanik
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html> 