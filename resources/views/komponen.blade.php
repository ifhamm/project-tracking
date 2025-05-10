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

        .status-badge {
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.85rem;
            display: inline-block;
            min-width: 100px;
            text-align: center;
        }

        .progress {
            height: 10px;
            width: 100%;
            margin-top: 5px;
            background-color: #eef2f5;
        }

        .table> :not(caption)>*>* {
            padding: 0.75rem 1rem;
        }

        .filter-section {
            background-color: #fff;
            border-radius: 0.375rem;
            padding: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
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
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/">
                                <i class="bi bi-house me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
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
                <h2 class="mb-4">Aircraft Component Tracking</h2>

                <!-- Filter Section -->
                <div class="filter-section mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-md">
                            <!-- Empty space to push filters to the right -->
                        </div>
                        <div class="col-md-auto">
                            <label for="statusFilter" class="me-2 fw-semibold">Status:</label>
                            <select id="statusFilter" class="form-select">
                                <option selected>All</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                                <option>Not Started</option>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <label for="dateFilter" class="me-2 fw-semibold">Date:</label>
                            <input type="search" id="dateFilter" class="form-control" placeholder="Search">
                        </div>
                    </div>
                </div>

                <!-- Insert Button -->
                <div class="mb-3 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                        <i class="bi bi-plus-circle"></i> Insert Component
                    </button>
                </div>

                <!-- Modal Insert Component -->
                <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="insertModalLabel">Tambah Komponen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('part.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="id_mekanik" class="form-label">Pilih Mekanik</label>
                                        <select class="form-select @error('id_mekanik') is-invalid @enderror"
                                            id="id_mekanik" name="id_mekanik" required>
                                            <option value="" disabled selected>Pilih Mekanik</option>
                                            @foreach ($mekanik as $mekaniks)
                                                <option value="{{ $mekaniks->id }}"
                                                    {{ old('id_mekanik') == $mekaniks->id ? 'selected' : '' }}>
                                                    {{ $mekaniks->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_mekanik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_wbs" class="form-label">No WBS</label>
                                        <input type="text" class="form-control @error('no_wbs') is-invalid @enderror"
                                            id="no_wbs" name="no_wbs" value="{{ old('no_wbs') }}" required>
                                        @error('no_wbs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="incoming_date" class="form-label">Tanggal Masuk</label>
                                        <input type="date"
                                            class="form-control @error('incoming_date') is-invalid @enderror"
                                            id="incoming_date" name="incoming_date"
                                            value="{{ old('incoming_date') }}" required>
                                        @error('incoming_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="part_name" class="form-label">Nama Part</label>
                                        <input type="text"
                                            class="form-control @error('part_name') is-invalid @enderror"
                                            id="part_name" name="part_name" value="{{ old('part_name') }}" required>
                                        @error('part_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="part_number" class="form-label">Nomor Part</label>
                                        <input type="text"
                                            class="form-control @error('part_number') is-invalid @enderror"
                                            id="part_number" name="part_number" value="{{ old('part_number') }}"
                                            required>
                                        @error('part_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_seri" class="form-label">Nomor Seri (Opsional)</label>
                                        <input type="text"
                                            class="form-control @error('no_seri') is-invalid @enderror" id="no_seri"
                                            name="no_seri" value="{{ old('no_seri') }}">
                                        @error('no_seri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer" class="form-label">Customer</label>
                                        <textarea class="form-control @error('customer') is-invalid @enderror" id="customer" name="customer">{{ old('customer') }}</textarea>
                                        @error('customer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Table - Responsive -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Component</th>
                                    <th>Description</th>
                                    <th>Date Received</th>
                                    <th>Customer/Airline</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>COMP-001</td>
                                    <td>Hydraulic pump</td>
                                    <td>April 1, 2025</td>
                                    <td>Airline X</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="status-badge bg-info bg-opacity-25 text-info me-2">In
                                                Progress</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: 45%;" aria-valuenow="45" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>45%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-002</td>
                                    <td>Generator</td>
                                    <td>March 28, 2025</td>
                                    <td>Airline Y</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-success bg-opacity-25 text-success me-2">Completed</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>100%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-003</td>
                                    <td>Valve</td>
                                    <td>March 25, 2025</td>
                                    <td>Airline Z</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-success bg-opacity-25 text-success me-2">Completed</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>100%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-004</td>
                                    <td>Actuator</td>
                                    <td>March 20, 2025</td>
                                    <td>Airline X</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-secondary bg-opacity-25 text-secondary me-2">Not
                                                Started</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-secondary" role="progressbar"
                                                        style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>0%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-005</td>
                                    <td>Fuel pump</td>
                                    <td>Febr.115, 2025</td>
                                    <td>Airline Y</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-success bg-opacity-25 text-success me-2">Completed</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>100%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-006</td>
                                    <td>Landing gear</td>
                                    <td>Jan.10, 2025</td>
                                    <td>AOG</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-success bg-opacity-25 text-success me-2">Completed</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>100%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>COMP-006</td>
                                    <td>Landing gear</td>
                                    <td>Jan.10, 2025</td>
                                    <td>—</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="status-badge bg-success bg-opacity-25 text-success me-2">Completed</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 100%;" aria-valuenow="100" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>100%</small></div>
                                            </div>
                                        </div>
                                    </td>
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
