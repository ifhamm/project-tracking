<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking - Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .sidebar {
            background-color: #0c2340;
            color: white;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
            transition: all 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1a3c61;
        }

        .sidebar-icon {
            margin-right: 10px;
        }

        .component-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .detail-row {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 500;
        }

        .detail-value {
            font-weight: 400;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 10px;
        }

        .step-completed {
            background-color: #10b981;
        }

        .step-in-progress {
            background-color: #3b82f6;
        }

        .step-not-started {
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
        }

        .step-line {
            width: 2px;
            background-color: #d1d5db;
            height: 40px;
            margin-left: 14px;
        }

        .step-item {
            margin-bottom: 0;
        }

        .table-step {
            margin-left: 10px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-in-progress {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-not-started {
            background-color: #e2e3e5;
            color: #41464b;
        }

        .action-btn {
            min-width: 120px;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }

            .component-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h3>Detail Komponen</h3>
        <table class="table table-bordered">
            <tr>
                <th>No IWO</th>
                <td>{{ $part->no_iwo }}</td>
            </tr>
            <tr>
                <th>Nama Part</th>
                <td>{{ $part->part_name }}</td>
            </tr>
            <tr>
                <th>Nomor Part</th>
                <td>{{ $part->part_number }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ \Carbon\Carbon::parse($part->incoming_date)->format('M d, Y') }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $part->customer }}</td>
            </tr>
            <tr>
                <th>Mekanik</th>
                <td>{{ $part->akunMekanik->name ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <h4>Break Down Part List</h4>
        <table class="table table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>BDP Name</th>
                    <th>BDP Number Eqv</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>OP Number</th>
                    <th>OP Date</th>
                    <th>Defect</th>
                    <th>MT Number</th>
                    <th>MT Qty</th>
                    <th>MT Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($part->breakdownParts as $bdp)
                    <tr>
                        <td>{{ $bdp->bdp_name }}</td>
                        <td>{{ $bdp->bdp_number_eqv }}</td>
                        <td>{{ $bdp->quantity }}</td>
                        <td>{{ $bdp->unit }}</td>
                        <td>{{ $bdp->op_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($bdp->op_date)->format('M d, Y') }}</td>
                        <td>{{ $bdp->defect }}</td>
                        <td>{{ $bdp->mt_number }}</td>
                        <td>{{ $bdp->mt_quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($bdp->mt_date)->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('breakdown.parts.edit', $bdp->bdp_number_eqv) }}"
                                class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('breakdown.parts.destroy', $bdp->bdp_number_eqv) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin hapus data ini?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">Belum ada Breakdown Parts.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <hr>

        <h4>Tambah Breakdown Part Baru</h4>
        <form action="{{ route('breakdown.parts.store') }}" method="POST">
            @csrf
            <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">

            <div class="row mb-3">
                <div class="col">
                    <label for="bdp_name" class="form-label">BDP Name</label>
                    <input type="text" name="bdp_name" id="bdp_name" class="form-control" required>
                </div>
                <div class="col">
                    <label for="bdp_number_eqv" class="form-label">BDP Number Eqv</label>
                    <input type="text" name="bdp_number_eqv" id="bdp_number_eqv" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>
                <div class="col">
                    <label for="unit" class="form-label">Unit</label>
                    <input type="text" name="unit" id="unit" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="op_number" class="form-label">OP Number</label>
                    <input type="text" name="op_number" id="op_number" class="form-control" required>
                </div>
                <div class="col">
                    <label for="op_date" class="form-label">OP Date</label>
                    <input type="date" name="op_date" id="op_date" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="defect" class="form-label">Defect</label>
                    <input type="text" name="defect" id="defect" class="form-control">
                </div>
                <div class="col">
                    <label for="mt_number" class="form-label">MT Number</label>
                    <input type="text" name="mt_number" id="mt_number" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="mt_quantity" class="form-label">MT Quantity</label>
                    <input type="number" name="mt_quantity" id="mt_quantity" class="form-control">
                </div>
                <div class="col">
                    <label for="mt_date" class="form-label">MT Date</label>
                    <input type="date" name="mt_date" id="mt_date" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan Breakdown Part</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.table-responsive table');

        // event delegation: dengarkan klik pada tombol delete-step
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.delete-step');
            if (!btn) return;

            // cari baris langkah dan baris connector yang mengikutinya
            const stepRow = btn.closest('tr.step-row');
            const nextRow = stepRow.nextElementSibling;

            // konfirmasi (opsional)
            if (!confirm('Yakin ingin menghapus langkah ini?')) return;

            // hapus kedua baris
            stepRow.remove();
            if (nextRow && nextRow.classList.contains('connector-row')) {
                nextRow.remove();
            }
        });
    });
</script>
