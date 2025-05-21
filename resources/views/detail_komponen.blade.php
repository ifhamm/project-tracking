@extends('layouts.sidebar')

@section('content')
<div class="col-lg-10 content-wrapper">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Detail Komponen</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th class="text-muted" style="width: 150px;">No IWO</th>
                                        <td>{{ $part->no_iwo }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Nama Part</th>
                                        <td>{{ $part->part_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Nomor Part</th>
                                        <td>{{ $part->part_number }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th class="text-muted" style="width: 150px;">Tanggal Masuk</th>
                                        <td>{{ \Carbon\Carbon::parse($part->incoming_date)->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Customer</th>
                                        <td>{{ $part->customer }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Mekanik</th>
                                        <td>{{ $part->akunMekanik->name ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Break Down Part List</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBdpModal">
                            <i class="bi bi-plus-lg"></i> Tambah BDP
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
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
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                                    Belum ada Breakdown Parts
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
        </div>
    </div>
</div>

<!-- Add BDP Modal -->
<div class="modal fade" id="addBdpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Breakdown Part Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('breakdown.parts.store') }}" method="POST">
                @csrf
                <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bdp_name" class="form-label">BDP Name</label>
                            <input type="text" name="bdp_name" id="bdp_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bdp_number_eqv" class="form-label">BDP Number Eqv</label>
                            <input type="text" name="bdp_number_eqv" id="bdp_number_eqv" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" name="unit" id="unit" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="op_number" class="form-label">OP Number</label>
                            <input type="text" name="op_number" id="op_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="op_date" class="form-label">OP Date</label>
                            <input type="date" name="op_date" id="op_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="defect" class="form-label">Defect</label>
                            <input type="text" name="defect" id="defect" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="mt_number" class="form-label">MT Number</label>
                            <input type="text" name="mt_number" id="mt_number" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mt_quantity" class="form-label">MT Quantity</label>
                            <input type="number" name="mt_quantity" id="mt_quantity" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="mt_date" class="form-label">MT Date</label>
                            <input type="date" name="mt_date" id="mt_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    });
</script>
@endsection
