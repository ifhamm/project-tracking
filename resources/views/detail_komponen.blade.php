@extends('layouts.sidebar')

@section('content')
<div class="p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-info-circle me-3"></i>
                Detail Komponen
            </h1>
            <p class="text-muted mb-0">Informasi lengkap komponen dan breakdown parts</p>
        </div>
        <a href="{{ route('komponen') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Component Details Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-gear me-2"></i>Informasi Komponen
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-upc-scan me-2"></i>No IWO:
                        </div>
                        <div class="col-sm-8">
                            <span class="text-primary fw-semibold">{{ $part->no_iwo }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-tag me-2"></i>Nama Part:
                        </div>
                        <div class="col-sm-8">{{ $part->part_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-hash me-2"></i>Nomor Part:
                        </div>
                        <div class="col-sm-8">{{ $part->part_number }}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-calendar me-2"></i>Tanggal Masuk:
                        </div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-building me-2"></i>Customer:
                        </div>
                        <div class="col-sm-8">{{ $part->customer }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">
                            <i class="bi bi-person-gear me-2"></i>Mekanik:
                        </div>
                        <div class="col-sm-8">{{ $part->akunMekanik->name ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breakdown Parts Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-list-check me-2"></i>Breakdown Part List
            </h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBdpModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah BDP
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($part->breakdownParts as $bdp)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $bdp->bdp_name }}</span>
                                </td>
                                <td>{{ $bdp->bdp_number_eqv }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $bdp->quantity }}</span>
                                </td>
                                <td>{{ $bdp->unit }}</td>
                                <td>{{ $bdp->op_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($bdp->op_date)->format('d M Y') }}</td>
                                <td>
                                    @if($bdp->defect)
                                        <span class="badge bg-warning">{{ $bdp->defect }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $bdp->mt_number ?? '-' }}</td>
                                <td>{{ $bdp->mt_quantity ?? '-' }}</td>
                                <td>{{ $bdp->mt_date ? \Carbon\Carbon::parse($bdp->mt_date)->format('d M Y') : '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary edit-bdp-btn"
                                                data-bs-toggle="modal" data-bs-target="#editBdpModal"
                                                data-id="{{ $bdp->no_iwo }}"
                                                data-bdp_name="{{ $bdp->bdp_name }}"
                                                data-bdp_number_eqv="{{ $bdp->bdp_number_eqv }}"
                                                data-quantity="{{ $bdp->quantity }}"
                                                data-unit="{{ $bdp->unit }}"
                                                data-op_number="{{ $bdp->op_number }}"
                                                data-op_date="{{ $bdp->op_date }}"
                                                data-defect="{{ $bdp->defect }}"
                                                data-mt_number="{{ $bdp->mt_number }}"
                                                data-mt_quantity="{{ $bdp->mt_quantity }}"
                                                data-mt_date="{{ $bdp->mt_date }}"
                                                title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="deleteBdp('{{ $bdp->no_iwo }}', '{{ $bdp->bdp_name }}')"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        <h6>Belum ada Breakdown Parts</h6>
                                        <p class="mb-0">Klik tombol "Tambah BDP" untuk menambahkan data</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add BDP Modal -->
<div class="modal fade" id="addBdpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Breakdown Part Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('breakdown.parts.store') }}" method="POST">
                @csrf
                <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bdp_name" class="form-label fw-semibold">
                                <i class="bi bi-tag me-2"></i>BDP Name
                            </label>
                            <input type="text" name="bdp_name" id="bdp_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bdp_number_eqv" class="form-label fw-semibold">
                                <i class="bi bi-hash me-2"></i>BDP Number Eqv
                            </label>
                            <input type="text" name="bdp_number_eqv" id="bdp_number_eqv" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label fw-semibold">
                                <i class="bi bi-123 me-2"></i>Quantity
                            </label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label fw-semibold">
                                <i class="bi bi-rulers me-2"></i>Unit
                            </label>
                            <input type="text" name="unit" id="unit" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="op_number" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text me-2"></i>OP Number
                            </label>
                            <input type="text" name="op_number" id="op_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="op_date" class="form-label fw-semibold">
                                <i class="bi bi-calendar me-2"></i>OP Date
                            </label>
                            <input type="date" name="op_date" id="op_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="defect" class="form-label fw-semibold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Defect
                            </label>
                            <input type="text" name="defect" id="defect" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-6">
                            <label for="mt_number" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text me-2"></i>MT Number
                            </label>
                            <input type="text" name="mt_number" id="mt_number" class="form-control" placeholder="Opsional">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mt_quantity" class="form-label fw-semibold">
                                <i class="bi bi-123 me-2"></i>MT Quantity
                            </label>
                            <input type="number" name="mt_quantity" id="mt_quantity" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-6">
                            <label for="mt_date" class="form-label fw-semibold">
                                <i class="bi bi-calendar me-2"></i>MT Date
                            </label>
                            <input type="date" name="mt_date" id="mt_date" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit BDP Modal -->
<div class="modal fade" id="editBdpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit Breakdown Part
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('breakdown.parts.update', ['no_iwo' => $part->no_iwo]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_bdp_name" class="form-label fw-semibold">
                                <i class="bi bi-tag me-2"></i>BDP Name
                            </label>
                            <input type="text" name="bdp_name" id="edit_bdp_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_bdp_number_eqv" class="form-label fw-semibold">
                                <i class="bi bi-hash me-2"></i>BDP Number Eqv
                            </label>
                            <input type="text" name="bdp_number_eqv" id="edit_bdp_number_eqv" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_quantity" class="form-label fw-semibold">
                                <i class="bi bi-123 me-2"></i>Quantity
                            </label>
                            <input type="number" name="quantity" id="edit_quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_unit" class="form-label fw-semibold">
                                <i class="bi bi-rulers me-2"></i>Unit
                            </label>
                            <input type="text" name="unit" id="edit_unit" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_op_number" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text me-2"></i>OP Number
                            </label>
                            <input type="text" name="op_number" id="edit_op_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_op_date" class="form-label fw-semibold">
                                <i class="bi bi-calendar me-2"></i>OP Date
                            </label>
                            <input type="date" name="op_date" id="edit_op_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_defect" class="form-label fw-semibold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Defect
                            </label>
                            <input type="text" name="defect" id="edit_defect" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_mt_number" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-text me-2"></i>MT Number
                            </label>
                            <input type="text" name="mt_number" id="edit_mt_number" class="form-control" placeholder="Opsional">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_mt_quantity" class="form-label fw-semibold">
                                <i class="bi bi-123 me-2"></i>MT Quantity
                            </label>
                            <input type="number" name="mt_quantity" id="edit_mt_quantity" class="form-control" placeholder="Opsional">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_mt_date" class="form-label fw-semibold">
                                <i class="bi bi-calendar me-2"></i>MT Date
                            </label>
                            <input type="date" name="mt_date" id="edit_mt_date" class="form-control" placeholder="Opsional">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-group .btn {
        border-radius: 6px;
        margin: 0 1px;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Edit BDP button click handler
    document.querySelectorAll('.edit-bdp-btn').forEach(button => {
        button.addEventListener('click', function() {
            const data = this.dataset;
            
            document.getElementById('edit_bdp_name').value = data.bdp_name;
            document.getElementById('edit_bdp_number_eqv').value = data.bdp_number_eqv;
            document.getElementById('edit_quantity').value = data.quantity;
            document.getElementById('edit_unit').value = data.unit;
            document.getElementById('edit_op_number').value = data.op_number;
            document.getElementById('edit_op_date').value = data.op_date;
            document.getElementById('edit_defect').value = data.defect || '';
            document.getElementById('edit_mt_number').value = data.mt_number || '';
            document.getElementById('edit_mt_quantity').value = data.mt_quantity || '';
            document.getElementById('edit_mt_date').value = data.mt_date || '';
        });
    });

    // Delete BDP function
    function deleteBdp(noIwo, bdpName) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus BDP "${bdpName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/breakdown_parts/${noIwo}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'BDP berhasil dihapus.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Gagal menghapus BDP'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus BDP'
                    });
                });
            }
        });
    }
</script>
@endsection
