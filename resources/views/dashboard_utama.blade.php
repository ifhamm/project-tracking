@extends('layouts.sidebar')

@section('content')
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .chart-container {
            height: 250px;
            position: relative;
        }

        .status-badge {
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .bg-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .bg-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .bg-info {
            background-color: #cff4fc;
            color: #055160;
        }
    </style>

    <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Customer Selector -->
        <div class="mb-3">
            <label for="customer" class="form-label">Pilih Customer</label>
            <select name="customer" id="customerSelect" class="form-control select2" required>
                <option value="">Pilih Customer</option>
                @foreach ($customers as $c)
                    <option value="{{ $c->customer }}">{{ $c->customer }}</option>
                @endforeach
            </select>
        </div>

        <!-- Export Button -->
        <div class="mb-3">
            <a href="#" id="exportButton" class="btn btn-primary">
                <i class="bi bi-file-earmark-arrow-down"></i> Export PDF
            </a>
        </div>

        <!-- Charts Section -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Status Komponen</h5>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Tren Pemrosesan</h5>
                        <div class="chart-container d-flex justify-content-center align-items-center">
                            <p class="text-muted">[Diagram Tren Pemrosesan]</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
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
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat via Ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let chartInstance;

        $(document).ready(function() {
            console.log("Document ready");

            // Inisialisasi Select2
            $('#customerSelect').select2({
                placeholder: 'Cari atau pilih customer',
                allowClear: true
            });

            // Fungsi untuk update tombol export
            function updateExportButton(customer) {
                const exportButton = $('#exportButton');
                if (customer) {
                    exportButton.attr('href', '{{ route('export.pdf') }}?customer=' + encodeURIComponent(customer));
                } else {
                    exportButton.attr('href', '{{ route('export.pdf') }}?customer=all');
                }
                exportButton.removeClass('disabled');
            }

            // Fungsi untuk render chart
            function renderChart(data) {
                console.log("Rendering chart with data:", data);

                const ctx = document.getElementById('statusChart').getContext('2d');

                // Hancurkan chart sebelumnya jika ada
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Buat chart baru
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Status Komponen per Minggu'
                            }
                        }
                    }
                });
            }

            // Fungsi untuk update tabel
            function updateTable(parts) {
                console.log("Updating table with parts:", parts);

                const tbody = $('table tbody');
                tbody.empty();

                if (!parts || parts.length === 0) {
                    tbody.append('<tr><td colspan="5" class="text-center">Tidak ada komponen</td></tr>');
                    return;
                }

                parts.forEach(part => {
                    // Tentukan kelas status
                    let statusClass;
                    if (part.status === 'Final Inspection') {
                        statusClass = 'bg-success';
                    } else if (part.status === 'In Progress') {
                        statusClass = 'bg-warning';
                    } else {
                        statusClass = 'bg-info';
                    }

                    // Format tanggal
                    const incomingDate = part.incoming_date ? new Date(part.incoming_date) : null;
                    const formattedDate = incomingDate ? incomingDate.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }) : '-';

                    const priorityText = part.priority == 1 ? 'Urgent' : 'Normal';

                    const row = `
                        <tr>
                            <td>${part.no_wbs || '-'}</td>
                            <td>${part.part_name || '-'}</td>
                            <td><span class="status-badge ${statusClass}">${part.status || '-'}</span></td>
                            <td>${formattedDate}</td>
                            <td>${priorityText}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            // Load data awal saat halaman dimuat
            $.ajax({
                url: '/api/parts-by-customer/all',
                method: 'GET',
                success: function(parts) {
                    console.log("Initial parts loaded:", parts);
                    updateTable(parts);
                },
                error: function(xhr) {
                    console.error('Gagal memuat data komponen awal', xhr.responseText);
                    $('table tbody').html(
                        '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data: ' +
                        xhr.status + ' ' + xhr.statusText + '</td></tr>'
                    );
                }
            });

            // Event ketika customer dipilih
            $('#customerSelect').on('change', function() {
                const customer = $(this).val();
                console.log("Customer selected:", customer);
                updateExportButton(customer);

                if (customer) {
                    // Load chart data
                    $.ajax({
                        url: `/api/chart-data/${customer}`,
                        method: 'GET',
                        success: function(response) {
                            console.log("Chart data loaded:", response);
                            renderChart(response);
                        },
                        error: function(xhr) {
                            console.error('Gagal memuat data chart', xhr.responseText);
                            $('#statusChart').closest('.card-body').html(
                                '<p class="text-danger">Gagal memuat data chart: ' +
                                xhr.status + ' ' + xhr.statusText + '</p>'
                            );
                        }
                    });

                    // Load table data
                    $.ajax({
                        url: `/api/parts-by-customer/${customer}`,
                        method: 'GET',
                        success: function(parts) {
                            console.log("Parts data loaded:", parts);
                            updateTable(parts);
                        },
                        error: function(xhr) {
                            console.error('Gagal memuat data komponen', xhr.responseText);
                            $('table tbody').html(
                                '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data: ' +
                                xhr.status + ' ' + xhr.statusText + '</td></tr>'
                            );
                        }
                    });
                } else {
                    // Jika tidak ada customer yang dipilih, tampilkan semua data
                    $.ajax({
                        url: '/api/parts-by-customer/all',
                        method: 'GET',
                        success: function(parts) {
                            console.log("All parts loaded:", parts);
                            updateTable(parts);
                        },
                        error: function(xhr) {
                            console.error('Gagal memuat data komponen', xhr.responseText);
                            $('table tbody').html(
                                '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data: ' +
                                xhr.status + ' ' + xhr.statusText + '</td></tr>'
                            );
                        }
                    });

                    // Reset chart area
                    $('#statusChart').closest('.card-body').html(`
                        <h5 class="card-title">Status Komponen</h5>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    `);
                }
            });

            // Inisialisasi export button untuk pertama kali
            updateExportButton('');
        });
    </script>
@endsection
