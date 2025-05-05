<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
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
        .chart-container {
            height: 250px;
        }
        .status-badge {
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 0.85rem;
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
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-house me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="komponen">
                                <i class="bi bi-boxes me-2"></i> Komponen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="proses-mekanik">
                                <i class="bi bi-gear me-2"></i> Proses Mekanik
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-file-text me-2"></i> Dokumentasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-truck me-2"></i> Delivery
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
                <h2 class="mb-4">Dashboard</h2>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Total Masuk</h6>
                                <h2 class="card-title">12</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Dalam Proses</h6>
                                <h2 class="card-title">5</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2 text-muted">Selesai</h6>
                                <h2 class="card-title">7</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Status Komponen</h5>
                                <div class="chart-container">
                                    <!-- This is where the first chart will go -->
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <p class="text-muted">[Diagram Status Komponen]</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Tren Pemrosesan</h5>
                                <div class="chart-container">
                                    <!-- This is where the second chart will go -->
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <p class="text-muted">[Diagram Tren Pemrosesan]</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Komponen Section -->
                <h3 class="mb-3">Komponen</h3>
                <div class="row g-2 mb-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <input type="text" class="form-control" placeholder="Nomor Komponen">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <select class="form-select">
                            <option selected>Status</option>
                            <option>In Progress</option>
                            <option>Completed</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-9 col-lg-4">
                        <input type="date" class="form-control" placeholder="Tanggal Masuk">
                    </div>
                    <div class="col-12 col-sm-3 col-lg-1">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>

                <!-- Table - Responsive -->
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nomor Komponen</th>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>COMP-001</td>
                                        <td>Adroulic Pump</td>
                                        <td><span class="status-badge bg-info bg-opacity-25 text-info">In Progress</span></td>
                                        <td>01/04/2025</td>
                                    </tr>
                                    <tr>
                                        <td>COMP-002</td>
                                        <td>Electrical Generator</td>
                                        <td><span class="status-badge bg-success bg-opacity-25 text-success">Completed</span></td>
                                        <td>02/04/2025</td>
                                    </tr>
                                    <tr>
                                        <td>COMP-003</td>
                                        <td>Fuel Control Unit</td>
                                        <td><span class="status-badge bg-info bg-opacity-25 text-info">In Progress</span></td>
                                        <td>03/04/2025</td>
                                    </tr>
                                    <tr>
                                        <td>COMP-004</td>
                                        <td>Hydraulic Actuator</td>
                                        <td><span class="status-badge bg-success bg-opacity-25 text-success">Completed</span></td>
                                        <td>03/04/2025</td>
                                    </tr>
                                    <tr>
                                        <td>COMP-005</td>
                                        <td>Aircraft Brake</td>
                                        <td><span class="status-badge bg-info bg-opacity-25 text-info">In Progress</span></td>
                                        <td>04/04/2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }
            
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarClose.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>
</html>