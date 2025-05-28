<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        .sidebar {
            background-color: #0f2a4a;
            color: white;
            min-height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: white;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background-color: #1a3a5f;
        }

        .sidebar .nav-link.active {
            background-color: #1a3a5f;
        }

        /* Responsive sidebar */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 250px;
                height: 100%;
                transition: all 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .content-wrapper {
                width: 100%;
            }

            .overlay {
                display: none;
                position: fixed;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                z-index: 999;
                opacity: 0;
                transition: all 0.5s ease-in-out;
            }

            .overlay.show {
                display: block;
                opacity: 1;
            }

            .modal-dialog {
                z-index: 1050 !important;
            }

        }
    </style>
</head>

<body>
    <!-- Mobile Nav Toggle Button -->
    <div class="d-lg-none position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <button id="sidebarToggle" class="btn btn-primary">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Overlay for sidebar on mobile -->
    <div class="overlay" id="overlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 px-0 sidebar" id="sidebar">
                <div class="d-flex flex-column">
                    <div class="p-3">
                        <h5 class="fw-bold d-flex justify-content-between align-items-center">
                            AIRCRAFT COMPONENT
                            <button class="btn-close d-lg-none text-white" id="sidebarClose"></button>
                        </h5>
                    </div>
                    <ul class="nav flex-column" id="sidebarNav">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard">
                                <i class="bi bi-house me-2"></i> Dashboard
                            </a>
                        </li>

                        @if (in_array(Session::get('role'), ['superadmin', 'mekanik']))
                        <li class="nav-item">
                            <a class="nav-link" href="komponen">
                                <i class="bi bi-boxes me-2"></i> Komponen
                            </a>
                        </li>
                        @endif

                        @if (in_array(Session::get('role'), ['superadmin', 'mekanik']))
                        <li class="nav-item">
                            <a class="nav-link" href="proses-mekanik">
                                <i class="bi bi-gear me-2"></i> Proses Mekanik
                            </a>
                        </li>
                        @endif

                        @if (in_array(Session::get('role'), ['superadmin', 'mekanik']))
                        <li class="nav-item">
                            <a class="nav-link" href="dokumentasi-mekanik">
                                <i class="bi bi-file-text me-2"></i> Dokumentasi
                            </a>
                        </li>
                        @endif

                        @if (in_array(Session::get('role'), ['superadmin', 'mekanik']))
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-truck me-2"></i> Delivery
                            </a>
                        </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @yield('content')
        </div>

    </div>

    @yield('scripts')
    <!-- Sidebar Toggle Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarNav = document.getElementById('sidebarNav');
            const navLinks = sidebarNav.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Hapus class active dari semua link
                    navLinks.forEach(item => {
                        item.classList.remove('active');
                    });

                    // Tambahkan class active ke link yang diklik
                    this.classList.add('active');

                    localStorage.setItem('activeNavItem', this.getAttribute('href'));
                });
            });

            // Optional: Untuk mempertahankan state active setelah refresh
            const currentPath = window.location.pathname.split('/').pop();
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>