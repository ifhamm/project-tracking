<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            min-height: 100vh;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.875rem 1.25rem;
            border-radius: 8px;
            margin: 0.25rem 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        /* Content Area */
        .content-wrapper {
            background-color: white;
            min-height: 100vh;
            border-radius: 0 0 0 20px;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            border: none;
            padding: 1rem 1.5rem;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), #0056b3);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        /* Tables */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--light-bg);
            border: none;
            font-weight: 600;
            color: var(--primary-color);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Status Badges */
        .status-badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Forms */
        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid var(--border-color);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            border: none;
            color: var(--accent-color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        /* Responsive Sidebar */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100%;
                transition: all 0.3s ease;
                z-index: 1050;
            }

            .sidebar.show {
                left: 0;
            }

            .content-wrapper {
                width: 100%;
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                transition: all 0.3s ease;
            }

            .overlay.show {
                display: block;
                opacity: 1;
            }
        }

        /* Mobile Nav Toggle */
        .mobile-nav-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1060;
            background: var(--accent-color);
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Loading Animation */
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

        /* Custom Scrollbar */
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
    <!-- Mobile Nav Toggle Button -->
    <button class="mobile-nav-toggle d-lg-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Overlay for sidebar on mobile -->
    <div class="overlay" id="overlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 px-0 sidebar" id="sidebar">
                <div class="d-flex flex-column h-100">
                    <div class="p-4 border-bottom border-light border-opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 d-flex align-items-center">
                                <i class="bi bi-airplane me-2"></i>
                                <span class="d-none d-lg-inline">AIRCRAFT COMPONENT</span>
                                <span class="d-lg-none">ACT</span>
                            </h5>
                            <button class="btn-close btn-close-white d-lg-none" id="sidebarClose"></button>
                        </div>
                    </div>
                    
                    <nav class="flex-grow-1 p-3">
                        <ul class="nav flex-column" id="sidebarNav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                    <i class="bi bi-house"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            @if (in_array(Session::get('role'), ['superadmin', 'mekanik', 'ppc']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('komponen*') ? 'active' : '' }}" href="{{ url('/komponen') }}">
                                        <i class="bi bi-boxes"></i>
                                        <span>Komponen</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Session::get('role'), ['superadmin', 'mekanik', 'ppc']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('proses-mekanik*') ? 'active' : '' }}" href="{{ url('/proses-mekanik') }}">
                                        <i class="bi bi-gear"></i>
                                        <span>Proses Mekanik</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Session::get('role'), ['superadmin', 'mekanik', 'ppc']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('dokumentasi*') ? 'active' : '' }}" href="{{ route('dokumentasi-mekanik') }}">
                                        <i class="bi bi-file-text"></i>
                                        <span>Dokumentasi</span>
                                    </a>
                                </li>
                            @endif

                            @if (in_array(Session::get('role'), ['superadmin']))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('add-mekanik*') ? 'active' : '' }}" href="{{ url('/add-mekanik-PM') }}">
                                        <i class="bi bi-person-gear"></i>
                                        <span>Tambah Akun</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>

                    <div class="p-3 border-top border-light border-opacity-25">
                        <a class="nav-link text-danger" href="{{ url('/logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const overlay = document.getElementById('overlay');
            const sidebarNav = document.getElementById('sidebarNav');
            const navLinks = sidebarNav.querySelectorAll('.nav-link');

            // Mobile sidebar toggle
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            });

            sidebarClose.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            });

            // Active nav item
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // This is for instant visual feedback on click
                    // The server will set the correct active class on page load.
                    navLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Close mobile sidebar after click
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Add loading state to buttons
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<span class="loading"></span> Loading...';
                        submitBtn.disabled = true;
                        
                        // Re-enable after 5 seconds as fallback
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 5000);
                    }
                });
            });
        });
    </script>
</body>

</html>
