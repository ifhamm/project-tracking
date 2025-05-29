@extends('layouts.sidebar')

@section('content')
    <div class="col-lg-10 content-wrapper">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Komponen</h5>
                            <a href="/komponen" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
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
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addBdpModal">
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
                                                        {{-- Tombol Edit --}}
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-primary edit-bdp-btn"
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
                                                            data-mt_date="{{ $bdp->mt_date }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        {{-- Form Delete --}}
                                                        <form
                                                            action="{{ route('breakdown.parts.destroy', ['no_iwo' => $bdp->no_iwo]) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
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

    {{-- Modal Tambah BDP --}}
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
                                <input type="text" name="bdp_number_eqv" id="bdp_number_eqv" class="form-control"
                                    required>
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

    {{-- Modal Edit BDP --}}
    <div class="modal fade" id="editBdpModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Breakdown Part</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editBdpForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_bdp_name" class="form-label">BDP Name</label>
                                <input type="text" name="bdp_name" id="edit_bdp_name"
                                    class="form-control @error('bdp_name') is-invalid @enderror" required>
                                @error('bdp_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="edit_bdp_number_eqv" class="form-label">BDP Number Eqv</label>
                                <input type="text" name="bdp_number_eqv" id="edit_bdp_number_eqv"
                                    class="form-control @error('bdp_number_eqv') is-invalid @enderror" required>
                                @error('bdp_number_eqv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_quantity" class="form-label">Quantity</label>
                                <input type="number" name="quantity" id="edit_quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_unit" class="form-label">Unit</label>
                                <input type="text" name="unit" id="edit_unit" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_op_number" class="form-label">OP Number</label>
                                <input type="text" name="op_number" id="edit_op_number" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_op_date" class="form-label">OP Date</label>
                                <input type="date" name="op_date" id="edit_op_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_defect" class="form-label">Defect</label>
                                <input type="text" name="defect" id="edit_defect" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_mt_number" class="form-label">MT Number</label>
                                <input type="text" name="mt_number" id="edit_mt_number" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_mt_quantity" class="form-label">MT Quantity</label>
                                <input type="number" name="mt_quantity" id="edit_mt_quantity" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_mt_date" class="form-label">MT Date</label>
                                <input type="date" name="mt_date" id="edit_mt_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteBdpModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Breakdown Part ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteBdpForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener untuk tombol edit
            document.querySelectorAll('.edit-bdp-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const noIwo = this.dataset.id;

                    // Mengisi form modal edit dengan data yang diambil dari data-attributes
                    document.getElementById('edit_bdp_name').value = this.dataset.bdp_name;
                    document.getElementById('edit_bdp_number_eqv').value = this.dataset
                        .bdp_number_eqv;
                    document.getElementById('edit_quantity').value = this.dataset.quantity;
                    document.getElementById('edit_unit').value = this.dataset.unit;
                    document.getElementById('edit_op_number').value = this.dataset.op_number;
                    document.getElementById('edit_op_date').value = this.dataset.op_date ? this
                        .dataset.op_date.split(' ')[0] : '';
                    document.getElementById('edit_defect').value = this.dataset.defect;
                    document.getElementById('edit_mt_number').value = this.dataset.mt_number;
                    document.getElementById('edit_mt_quantity').value = this.dataset.mt_quantity;
                    document.getElementById('edit_mt_date').value = this.dataset.mt_date ? this
                        .dataset.mt_date.split(' ')[0] : '';

                    // Mengatur action form edit
                    const editForm = document.getElementById('editBdpForm');
                    editForm.action = `/breakdown_parts/${noIwo}`;
                });
            });

            // Event listener untuk tombol delete
            document.querySelectorAll('.delete-bdp-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const noIwo = this.dataset.id;
                    const deleteForm = document.getElementById('deleteBdpForm');
                    deleteForm.action = `/breakdown_parts/${noIwo}`;
                });
            });

            // Show success message if it exists using Bootstrap Toast
            @if (session('success'))
                const toastContainer = document.createElement('div');
                toastContainer.classList.add('toast-container', 'position-fixed', 'bottom-0', 'end-0', 'p-3');
                document.body.appendChild(toastContainer);

                const toastElement = document.createElement('div');
                toastElement.classList.add('toast', 'align-items-center', 'text-white', 'bg-success', 'border-0');
                toastElement.setAttribute('role', 'alert');
                toastElement.setAttribute('aria-live', 'assertive');
                toastElement.setAttribute('aria-atomic', 'true');
                toastElement.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                toastContainer.appendChild(toastElement);

                const toast = new bootstrap.Toast(toastElement);
                toast.show();

                setTimeout(() => {
                    toastElement.remove();
                    if (toastContainer.children.length === 0) {
                        toastContainer.remove();
                    }
                }, 3000);
            @endif

            // Menampilkan modal edit jika ada error validasi setelah submit
            @if ($errors->any() && old('_method') === 'PUT')
                var editModal = new bootstrap.Modal(document.getElementById('editBdpModal'));
                editModal.show();
                // Mengisi kembali form edit dengan old input jika ada error
                document.getElementById('edit_bdp_name').value = "{{ old('bdp_name') }}";
                document.getElementById('edit_bdp_number_eqv').value = "{{ old('bdp_number_eqv') }}";
                document.getElementById('edit_quantity').value = "{{ old('quantity') }}";
                document.getElementById('edit_unit').value = "{{ old('unit') }}";
                document.getElementById('edit_op_number').value = "{{ old('op_number') }}";
                document.getElementById('edit_op_date').value = "{{ old('op_date') }}";
                document.getElementById('edit_defect').value = "{{ old('defect') }}";
                document.getElementById('edit_mt_number').value = "{{ old('mt_number') }}";
                document.getElementById('edit_mt_quantity').value = "{{ old('mt_quantity') }}";
                document.getElementById('edit_mt_date').value = "{{ old('mt_date') }}";

                const editBdpNoIwoAfterError = "{{ session('edit_bdp_no_iwo') }}" || null;
                if (editBdpNoIwoAfterError) {
                    const editForm = document.getElementById('editBdpForm');
                    editForm.action = `/breakdown_parts/${editBdpNoIwoAfterError}`;
                }
            @endif
        });
    </script>
@endsection
