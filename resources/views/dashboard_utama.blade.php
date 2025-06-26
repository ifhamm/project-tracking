@extends('layouts.sidebar')

@section('content')
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .chart-container {
            height: 300px;
            position: relative;
        }

        .chart-container canvas {
            max-height: 100%;
        }

        /* Chart specific styles */
        .card .chart-container {
            padding: 1rem;
        }

        .status-badge {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white !important;
        }

        .bg-success {
            background-color: #198754 !important;
            color: white !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
            color: white !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }

        /* Dashboard specific styles */
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 0 0 20px 20px;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Select2 customization */
        .select2-container--default .select2-selection--single {
            border-radius: 8px;
            border: 2px solid var(--border-color);
            height: 45px;
            padding: 0.5rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            color: var(--primary-color);
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .chart-container {
                height: 250px;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: var(--primary-color);
            font-weight: 500;
            background-color: #fff;
        }

        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Dashboard pagination specific styling */
        #pagination-container {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        #pagination-container .pagination .page-link {
            color: #495057;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        #pagination-container .pagination .page-link:hover {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        #pagination-container .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        #pagination-container .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        #pagination-info {
            color: #6c757d;
            font-weight: 500;
        }

        /* Export button disabled state */
        .btn.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn.disabled:hover {
            transform: none;
        }
    </style>

    <div class="p-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2">
                        <i class="bi bi-speedometer2 me-3"></i>
                        Dashboard
                    </h1>
                    <p class="mb-0 opacity-75">Monitor progress dan status komponen pesawat</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                        <a href="#" id="exportButton" class="btn btn-light">
                            <i class="bi bi-file-earmark-arrow-down me-2"></i>
                            <span class="d-none d-md-inline">Export PDF</span>
                            <span class="d-md-none">Export</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Selector -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <label for="customerSelect" class="form-label fw-semibold">
                            <i class="bi bi-building me-2"></i>Pilih Customer
                        </label>
                        <select name="customer" id="customerSelect" class="form-control select2" required>
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $c)
                                <option value="{{ $c->customer }}">{{ $c->customer }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-outline-secondary" onclick="resetFilter()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <div class="stats-number" id="totalParts">-</div>
                    <div class="stats-label">Total Komponen</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="stats-number" id="inProgress">-</div>
                    <div class="stats-label">Dalam Proses</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stats-number" id="completed">-</div>
                    <div class="stats-label">Selesai</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stats-number" id="urgent">-</div>
                    <div class="stats-label">Urgent</div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-pie-chart me-2"></i>Distribusi Status Komponen
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>Tren Pemrosesan Komponen
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-table me-2"></i>Daftar Komponen
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nomor Komponen</th>
                                <th>Nama</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Priority</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat via Ajax -->
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div id="pagination-container" class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted">
                        <small id="pagination-info">Showing 0 to 0 of 0 entries</small>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul id="pagination-links" class="pagination pagination-sm mb-0">
                            <!-- Pagination links will be inserted here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let statusChartInstance;
        let trendChartInstance;

        $(document).ready(function() {
            console.log("Document ready");

            // Inisialisasi Select2
            $('#customerSelect').select2({
                placeholder: 'Cari atau pilih customer',
                allowClear: true
            });

            // Setup CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fungsi untuk update tombol export
            function updateExportButton(customer) {
                const exportButton = $('#exportButton');
                if (customer) {
                    exportButton.attr('href', '{{ route('export.pdf') }}?customer=' + encodeURIComponent(customer));
                    exportButton.removeClass('disabled');
                } else {
                    exportButton.addClass('disabled');
                    exportButton.removeAttr('href');
                }
            }

            // Event handler untuk export button
            $('#exportButton').on('click', function(e) {
                const customer = $('#customerSelect').val();
                if (!customer) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Customer Terlebih Dahulu',
                        text: 'Silakan pilih customer untuk mengexport data',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#007bff'
                    });
                    return false;
                }
                
                // Show confirmation before export
                e.preventDefault();
                Swal.fire({
                    title: 'Export PDF?',
                    text: `Apakah Anda yakin ingin mengexport data untuk customer "${customer}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Export!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Mengexport PDF...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Use AJAX to fetch the PDF
                        fetch(`{{ route('export.pdf') }}?customer=${encodeURIComponent(customer)}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/pdf'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Export failed');
                            }
                            return response.blob();
                        })
                        .then(blob => {
                            // Create a download link and trigger it
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.style.display = 'none';
                            a.href = url;
                            a.download = `komponen-${customer}.pdf`;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            
                            // Show success notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Export Berhasil',
                                text: 'File PDF telah berhasil diunduh',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        })
                        .catch(error => {
                            console.error('Export error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Export Gagal',
                                text: 'Terjadi kesalahan saat mengexport data',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                    }
                });
            });

            // Fungsi untuk update stats
            function updateStats(parts, totalAll) {
                if (!parts || parts.length === 0) {
                    $('#totalParts').text('0');
                    $('#inProgress').text('0');
                    $('#completed').text('0');
                    $('#urgent').text('0');
                    return;
                }

                const total = totalAll !== undefined ? totalAll : parts.length;
                const inProgress = parts.filter(p => p.status === 'In Progress').length;
                const completed = parts.filter(p => p.status === 'Completed').length;
                const urgent = parts.filter(p => p.is_urgent == 1).length;

                $('#totalParts').text(total);
                $('#inProgress').text(inProgress);
                $('#completed').text(completed);
                $('#urgent').text(urgent);
            }

            // Fungsi untuk render status chart (doughnut)
            function renderStatusChart(data) {
                console.log("Rendering status chart with data:", data);

                const ctx = document.getElementById('statusChart').getContext('2d');

                if (statusChartInstance) {
                    statusChartInstance.destroy();
                }

                statusChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Status Komponen',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        },
                        cutout: '60%',
                        elements: {
                            arc: {
                                borderWidth: 2
                            }
                        }
                    }
                });
            }

            // Fungsi untuk render trend chart (line)
            function renderTrendChart(data) {
                console.log("Rendering trend chart with data:", data);

                const ctx = document.getElementById('trendChart').getContext('2d');

                if (trendChartInstance) {
                    trendChartInstance.destroy();
                }

                trendChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Tren Komponen Selesai per Bulan',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        elements: {
                            point: {
                                radius: 6,
                                hoverRadius: 8
                            },
                            line: {
                                tension: 0.4
                            }
                        }
                    }
                });
            }

            // Fungsi untuk update tabel
            function updateTable(parts, isPaginated = false) {
                console.log("Updating table with parts:", parts);

                const tbody = $('table tbody');
                tbody.empty();

                if (!parts || (isPaginated ? parts.data.length === 0 : parts.length === 0)) {
                    tbody.append(
                        '<tr><td colspan="7" class="text-center py-4"><div class="text-muted"><i class="bi bi-inbox display-4"></i><p class="mt-2">Tidak ada komponen</p></div></td></tr>'
                        );
                    $('#pagination-container').hide();
                    
                    // Show no data notification
                    Swal.fire({
                        icon: 'info',
                        title: 'Tidak Ada Data',
                        text: 'Tidak ada komponen yang ditemukan untuk ditampilkan',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#6c757d'
                    });
                    return;
                }

                const dataToProcess = isPaginated ? parts.data : parts;

                dataToProcess.forEach(part => {
                    console.log("DATA PART:", part);

                    let statusClass;
                    let statusText = part.status;
                    if (part.status === 'Completed') {
                        statusClass = 'bg-success';
                        statusText = 'Selesai';
                    } else if (part.status === 'In Progress') {
                        statusClass = 'bg-warning';
                    } else if (part.status === 'Belum Diproses') {
                        statusClass = 'bg-info';
                    } else {
                        statusClass = 'bg-secondary';
                    }

                    const incomingDate = part.incoming_date ? new Date(part.incoming_date) : null;
                    const formattedDate = incomingDate ? incomingDate.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }) : '-';

                    const priorityText = part.is_urgent == 1 ? 'Urgent' : 'Normal';
                    console.log('no_iwo yang dikirim:', part.no_iwo);

                    const row = `s
                    <tr>
                        <td><a href="/dokumentasi/${part.no_iwo}" class="text-decoration-none fw-bold text-primary">${part.no_wbs || '-'}</a></td>
                        <td>${part.part_name || '-'}</td>
                        <td>${part.customer || '-'}</td>
                        <td><span class="status-badge ${statusClass}">${statusText || '-'}</span></td>
                        <td>${formattedDate}</td>
                        <td><span class="badge ${part.is_urgent == 1 ? 'bg-danger' : 'bg-secondary'}">${priorityText}</span></td>
                        <td>
                            ${part.status === 'Completed' ? 
                                '<span class="text-muted"><i class="bi bi-check-circle me-1"></i>Selesai</span>' : 
                                (part.is_urgent != 1 ? `<button class="btn btn-sm btn-danger set-urgent-btn" data-id="${part.no_iwo}">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Set Urgent
                                </button>` : '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Urgent</span>')
                            }
                        </td>
                    </tr>
                `;
                    tbody.append(row);
                });

                // Handle pagination display
                if (isPaginated && parts.data.length > 0) {
                    updatePagination(parts);
                    $('#pagination-container').show();
                } else {
                    $('#pagination-container').hide();
                }

                // Event klik tombol Set Urgent
                tbody.off('click', '.set-urgent-btn').on('click', '.set-urgent-btn', function() {
                    const partId = $(this).data('id');
                    const button = $(this);
                    
                    Swal.fire({
                        title: 'Set Priority Urgent?',
                        text: 'Apakah Anda yakin ingin mengubah status komponen ini menjadi Urgent?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Set Urgent!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            button.prop('disabled', true);
                            button.html('<i class="bi bi-hourglass-split me-1"></i>Processing...');
                            
                            $.ajax({
                                url: `/parts/${partId}/set-urgent`,
                                method: 'POST',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Komponen berhasil di-set menjadi Urgent',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#198754'
                                    }).then(() => {
                                        $('#customerSelect').trigger('change');
                                    });
                                },
                                error: function(xhr) {
                                    // Reset button state
                                    button.prop('disabled', false);
                                    button.html('<i class="bi bi-exclamation-triangle me-1"></i>Set Urgent');
                                    
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Gagal mengubah status urgent: ' + (xhr.responseJSON?.message || xhr.responseText || 'Terjadi kesalahan'),
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#dc3545'
                                    });
                                }
                            });
                        }
                    });
                });
            }

            // Fungsi untuk update pagination
            function updatePagination(data) {
                const info = `Showing ${data.from || 0} to ${data.to || 0} of ${data.total || 0} entries`;
                $('#pagination-info').text(info);

                const links = $('#pagination-links');
                links.empty();

                // Previous button
                if (data.prev_page_url) {
                    links.append(
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page - 1}">Previous</a></li>`
                        );
                } else {
                    links.append(`<li class="page-item disabled"><span class="page-link">Previous</span></li>`);
                }

                // Page numbers
                for (let i = 1; i <= data.last_page; i++) {
                    if (i === data.current_page) {
                        links.append(`<li class="page-item active"><span class="page-link">${i}</span></li>`);
                    } else {
                        links.append(
                            `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`
                            );
                    }
                }

                // Next button
                if (data.next_page_url) {
                    links.append(
                        `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page + 1}">Next</a></li>`
                        );
                } else {
                    links.append(`<li class="page-item disabled"><span class="page-link">Next</span></li>`);
                }

                // Pagination click events
                links.off('click', '.page-link').on('click', '.page-link', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    if (page) {
                        // Show loading notification
                        Swal.fire({
                            title: 'Memuat Halaman...',
                            text: `Memuat halaman ${page}`,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        loadData('all', page);
                    }
                });
            }

            // Fungsi untuk load data
            function loadData(customer, page = 1) {
                console.log("Loading data for customer:", customer, "page:", page);
                updateExportButton(customer);

                if (customer && customer !== 'all') {
                    // Load chart data for specific customer
                    $.ajax({
                        url: `/api/chart-data/${customer}`,
                        method: 'GET',
                        success: function(response) {
                            console.log("Chart data response:", response);
                            renderStatusChart(response.statusChart);
                            renderTrendChart(response.trendChart);
                            
                            // Close loading and show success notification
                            Swal.close();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Berhasil Dimuat',
                                text: `Data untuk customer "${customer}" berhasil dimuat`,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        },
                        error: function(xhr) {
                            console.error("Error loading chart data:", xhr);
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Data Chart',
                                text: 'Terjadi kesalahan saat memuat data chart',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

                    // Load table data (no pagination for specific customer)
                    $.ajax({
                        url: `/api/parts-by-customer/${customer}`,
                        method: 'GET',
                        success: function(response) {
                            console.log("Customer specific response:", response);
                            updateTable(response.data, false);
                            updateStats(response.data, response.total_all);
                        },
                        error: function(xhr) {
                            console.error("Error loading customer data:", xhr);
                            Swal.close();
                            $('table tbody').html(
                                '<tr><td colspan="7" class="text-center text-danger py-4"><i class="bi bi-exclamation-triangle display-4"></i><p class="mt-2">Gagal memuat data</p></td></tr>'
                            );
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Data',
                                text: 'Terjadi kesalahan saat memuat data customer',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    // Close loading if exists
                    if (Swal.isVisible()) {
                        Swal.close();
                    }
                    
                    // Load chart data for all customers
                    $.ajax({
                        url: '/api/chart-data/all',
                        method: 'GET',
                        success: function(response) {
                            console.log("All customers chart data:", response);
                            renderStatusChart(response.statusChart);
                            renderTrendChart(response.trendChart);
                        },
                        error: function(xhr) {
                            console.error("Error loading all customers chart data:", xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Data Chart',
                                text: 'Terjadi kesalahan saat memuat data chart',
                                confirmButtonText: 'OK'
                            });
                        }
                    });

                    // Request 1: Untuk statistik (all=1)
                    $.ajax({
                        url: '/api/parts-by-customer/all?all=1',
                        method: 'GET',
                        success: function(response) {
                            console.log("Stats response:", response);
                            updateStats(response.data, response.total_all);
                        },
                        error: function(xhr) {
                            console.error("Error loading stats:", xhr);
                        }
                    });
                    
                    // Request 2: Untuk tabel (paginated)
                    $.ajax({
                        url: '/api/parts-by-customer/all?page=' + page,
                        method: 'GET',
                        success: function(response) {
                            console.log("Table response:", response);
                            updateTable(response, true);
                            
                            // Close loading if exists (for pagination)
                            if (Swal.isVisible()) {
                                Swal.close();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Halaman Berhasil Dimuat',
                                    text: `Halaman ${page} berhasil dimuat`,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error("Error loading table data:", xhr);
                            // Close loading if exists
                            if (Swal.isVisible()) {
                                Swal.close();
                            }
                            $('table tbody').html(
                                '<tr><td colspan="7" class="text-center text-danger py-4"><i class="bi bi-exclamation-triangle display-4"></i><p class="mt-2">Gagal memuat data</p></td></tr>'
                            );
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Data',
                                text: 'Terjadi kesalahan saat memuat data tabel',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            }

            // Load data awal
            loadData('all');

            // Event ketika customer dipilih
            $('#customerSelect').on('change', function() {
                const customer = $(this).val();
                console.log("Customer selected:", customer);
                
                // Show loading notification
                if (customer) {
                    Swal.fire({
                        title: 'Memuat Data...',
                        text: `Memuat data untuk customer "${customer}"`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
                
                loadData(customer, 1); // Reset to page 1 when customer changes
            });

            // Initialize pagination container visibility
            $('#pagination-container').hide();
        });

        // Fungsi reset filter (global)
        function resetFilter() {
            $('#customerSelect').val('').trigger('change');
            loadData('all', 1); // Load all parts when filter is reset
            
            // Show reset notification
            Swal.fire({
                icon: 'info',
                title: 'Filter Direset',
                text: 'Filter customer telah direset ke semua customer',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    </script>
@endsection
