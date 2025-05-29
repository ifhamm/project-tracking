    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .chart-container {
            height: 250px;
        }

        .status-badge {
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    </style>
    @extends('layouts.sidebar')
    @section('content')
        <!-- Main Content -->
        <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
            <h2 class="mb-4">Dashboard</h2>

            <!-- Stats Cards -->
            <div>
                <!-- <div class="col-12 col-md-4">
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
                                                                                    </div> -->

                <div class="mb-3">
                    <label for="customer" class="form-label">Pilih Customer</label>
                    <select name="customer" id="customerSelect" class="form-control select2" required>
                        <option value="">Pilih Customer</option>
                        @foreach ($customers as $c)
                            <option value="{{ $c->customer }}">{{ $c->customer }}</option>
                        @endforeach
                    </select>
                    @error('customer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <a href="#" id="exportButton" class="btn btn-primary">
                        <i class="bi bi-file-earmark-arrow-down"></i> Export PDF
                    </a>
                </div>
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
                                    <td><span class="status-badge bg-info bg-opacity-25 text-info">In
                                            Progress</span></td>
                                    <td>01/04/2025</td>
                                </tr>
                                <tr>
                                    <td>COMP-002</td>
                                    <td>Electrical Generator</td>
                                    <td><span class="status-badge bg-success bg-opacity-25 text-success">Completed</span>
                                    </td>
                                    <td>02/04/2025</td>
                                </tr>
                                <tr>
                                    <td>COMP-003</td>
                                    <td>Fuel Control Unit</td>
                                    <td><span class="status-badge bg-info bg-opacity-25 text-info">In
                                            Progress</span></td>
                                    <td>03/04/2025</td>
                                </tr>
                                <tr>
                                    <td>COMP-004</td>
                                    <td>Hydraulic Actuator</td>
                                    <td><span class="status-badge bg-success bg-opacity-25 text-success">Completed</span>
                                    </td>
                                    <td>03/04/2025</td>
                                </tr>
                                <tr>
                                    <td>COMP-005</td>
                                    <td>Aircraft Brake</td>
                                    <td><span class="status-badge bg-info bg-opacity-25 text-info">In
                                            Progress</span></td>
                                    <td>04/04/2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            let chartInstance;

            $(document).ready(function() {
                $('#customerSelect').select2({
                    placeholder: 'Cari atau pilih customer',
                    allowClear: true
                });
            });
            $('#customerSelect').on('change', function() {
                const customer = $(this).val();

                if (customer) {
                    // Ambil dan tampilkan chart (jika ada)
                    $.get(`/api/chart-data/${customer}`, function(response) {
                        renderChart(response);
                    });

                    // Ambil data parts berdasarkan customer
                    $.get(`/api/parts-by-customer/${customer}`, function(parts) {
                        const tbody = $('table tbody');
                        tbody.empty();

                        if (parts.length === 0) {
                            tbody.append(
                                '<tr><td colspan="4" class="text-center">Tidak ada komponen</td></tr>');
                        } else {
                            parts.forEach(part => {
                                const statusClass = part.status === 'Final Inspection' ?
                                    'bg-success bg-opacity-25 text-success' :
                                    'bg-info bg-opacity-25 text-info';

                                const row = `
                        <tr>
                            <td>${part.no_wbs}</td>
                            <td>${part.part_name}</td>
                            <td><span class="status-badge ${statusClass}">${part.status}</span></td>
                            <td>${part.incoming_date}</td>
                        </tr>
                    `;
                                tbody.append(row);
                            });
                        }
                    });
                }
            });

            function renderChart(data) {
                const ctx = document.getElementById('statusChart').getContext('2d');
                if (chartInstance) chartInstance.destroy(); // Hapus chart sebelumnya

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
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

            $('#customerSelect').on('change', function() {
                const customer = $(this).val();
                if (customer) {
                    $.get(`/api/chart-data/${customer}`, function(response) {
                        renderChart(response);
                    });
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const exportButton = document.getElementById('exportButton');
                const customerName = document.getElementById('customerSelect').value;

                exportButton.href = '{{ route('export.pdf') }}' + '?customer=' + encodeURIComponent(customerName);
            });
        </script>
    @endsection
