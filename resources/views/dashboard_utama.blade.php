@extends('layouts.sidebar')

@section('content')
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<!-- Select2 -->
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
        @error('customer')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Export Button -->
    <div class="mb-3">
        <a href="#" id="exportButton" class="btn btn-primary disabled">
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

    <!-- Komponen Filter -->
    <!-- <h3 class="mb-3">Komponen</h3>
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
    </div> -->

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

    $(document).ready(function () {
        $('#customerSelect').select2({
            placeholder: 'Cari atau pilih customer',
            allowClear: true
        });

        function updateExportButton(customer) {
            const exportButton = $('#exportButton');
            if (customer) {
                exportButton.attr('href', '{{ route('export.pdf') }}?customer=' + encodeURIComponent(customer));
                exportButton.removeClass('disabled');
            } else {
                exportButton.attr('href', '#');
                exportButton.addClass('disabled');
            }
        }

        function renderChart(data) {
            const ctx = document.getElementById('statusChart').getContext('2d');
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Status Komponen per Minggu'
                        }
                    }
                }
            });
        }

        function updateTable(parts) {
            const tbody = $('table tbody');
            tbody.empty();

            if (parts.length === 0) {
                tbody.append('<tr><td colspan="4" class="text-center">Tidak ada komponen</td></tr>');
                return;
            }

            parts.forEach(part => {
                const statusClass = part.status === 'Final Inspection'
                    ? 'bg-success bg-opacity-25 text-success'
                    : 'bg-info bg-opacity-25 text-info';

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

        $('#customerSelect').on('change', function () {
            const customer = $(this).val();
            updateExportButton(customer);

            if (customer) {
                $.get(`/api/chart-data/${customer}`, renderChart);
                $.get(`/api/parts-by-customer/${customer}`, updateTable);
            } else {
                $('table tbody').empty();
                if (chartInstance) chartInstance.destroy();
            }
        });
    });
</script>
@endsection
