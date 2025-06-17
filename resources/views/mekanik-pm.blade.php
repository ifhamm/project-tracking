<style>
    .content-wrapper {
        background-color: #f8f9fc;
        min-height: calc(100vh - 70px);
    }

    .d-flex.justify-content-between.align-items-center.mb-4 {
        padding: 15px 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px !important;
    }

    .btn-add {
        background: linear-gradient(135deg, #4e73df 0%, #2e59d9 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.25);
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(78, 115, 223, 0.3);
    }

    .btn-add i {
        margin-right: 10px;
        color: white
    }

    .btn-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #e0b135 100%);
        border: none;
        color: #000;
        font-weight: 600;
        padding: 8px 16px;
        font-size: 0.95rem;
    }

    .btn-danger {
        background: linear-gradient(135deg, #e74a3b 0%, #d52a1b 100%);
        border: none;
        font-weight: 600;
        padding: 8px 16px;
        font-size: 0.95rem;
    }

    .card {
        border-radius: 12px;
        border: none;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #2e59d9 100%);
        color: white;
        border-radius: 0 !important;
        padding: 15px 20px;
        font-weight: 700;
        font-size: 1.1rem;
        border: none !important;
    }

    .card-body.p-0 {
        border-radius: 0 0 12px 12px;
    }

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: 700;
        padding: 15px 20px;
        border-top: 1px solid #e3e6f0;
        border-bottom: 2px solid #e3e6f0;
        text-align: center;
    }

    .table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-top: 1px solid #e3e6f0;
        transition: background-color 0.2s;
        text-align: center;
    }

    .status-badge {
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.85rem;
        display: inline-block;
        min-width: 100px;
    }

    .modal-content {
        border-radius: 12px 12px 0 0;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #4e73df 0%, #2e59d9 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 15px 20px;
        border: none;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #e3e6f0;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #d1d3e2;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-label {
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 8px;
    }

    .alert-danger {
        border-radius: 8px;
        border: none;
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .table tbody tr {
        animation: fadeIn 0.4s ease-out;
        animation-fill-mode: both;
    }

    .table-action-cell {
        white-space: nowrap;
        text-align: center;
    }

    .table-action-cell .btn {
        padding: 6px 12px;
        font-size: 0.875rem;
        min-width: 80px;
    }
</style>

@extends('layouts.sidebar')

@section('content')
    <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Akun</h2>
            <button type="button" class="btn btn-add text-white" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-plus-circle me-2"></i> Tambah Baru
            </button>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Daftar Akun</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Mekanik</th>
                                <th>NIK</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credentials as $credential)
                                <tr>
                                    <td>{{ $credential->name }}</td>
                                    <td>{{ $credential->nik }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($credential->role === 'mekanik')
                                                <span class="status-badge bg-primary text-white me-2">
                                                    Mekanik
                                                </span>
                                            @elseif ($credential->role === 'ppc')
                                                <span class="status-badge bg-warning text-white me-2">
                                                    PPC
                                                </span>
                                            @else
                                                <span class="status-badge bg-success text-white me-2">
                                                    PM
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="table-action-cell">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $credential->id_credentials }}" title="Edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>

                                        <form action="{{ route('add-mekanik-PM.destroy', $credential->id_credentials) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete('{{ $credential->name }}', this.form)"
                                                title="Hapus Data">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editModal{{ $credential->id_credentials }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $credential->id_credentials }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editModalLabel{{ $credential->id_credentials }}">
                                                    Edit Credential
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('add-mekanik-PM.update', $credential->id_credentials) }}"
                                                method="POST" class="edit-form">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    @if ($errors->any() && old('id_credentials') == $credential->id_credentials)
                                                        <div class="alert alert-danger">
                                                            <ul class="mb-0">
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <div class="mb-3">
                                                        <label for="name{{ $credential->id_credentials }}"
                                                            class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control"
                                                            id="name{{ $credential->id_credentials }}" name="name"
                                                            value="{{ old('name', $credential->name) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nik{{ $credential->id_credentials }}"
                                                            class="form-label">NIK (16 digit)</label>
                                                        <input type="text" class="form-control"
                                                            id="nik{{ $credential->id_credentials }}" name="nik"
                                                            value="{{ old('nik', $credential->nik) }}" maxlength="16"
                                                            required>
                                                        <small class="text-muted">Contoh: 1234567890123456</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Role</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ ucfirst($credential->role) }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal Edit -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah akun -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Mekanik / PM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add-mekanik-PM.store') }}" method="POST" id="addForm">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any() && !old('id_credentials'))
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK (16 digit)</label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                value="{{ old('nik') }}" maxlength="16" required>
                            <small class="text-muted">Contoh: 1234567890123456</small>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" selected disabled>Pilih Role</option>
                                <option value="ppc" {{ old('role') == 'ppc' ? 'selected' : '' }}>PPC</option>
                                <option value="mekanik" {{ old('role') == 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                                <option value="pm" {{ old('role') == 'pm' ? 'selected' : '' }}>PM</option>
                            </select>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Auto open modal jika ada error
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('id_credentials'))
                    // Buka modal edit jika ada id_credentials di old data
                    const modalId = 'editModal{{ old('id_credentials') }}';
                    const modalElement = document.getElementById(modalId);

                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                @else
                    // Buka modal tambah jika tidak ada id_credentials
                    const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
                    modal.show();
                @endif
            });
        @endif

        // Validasi form tambah
        document.getElementById('addForm').addEventListener('submit', function(e) {
            const nik = document.getElementById('nik').value;

            // Validasi NIK harus 16 digit
            if (nik.length !== 16) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'NIK harus 16 digit',
                });
                return;
            }

            // Validasi NIK harus angka
            if (!/^\d+$/.test(nik)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'NIK harus berupa angka',
                });
            }
        });

        // Validasi form edit
        document.querySelectorAll('.edit-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const nikInput = this.querySelector('input[name="nik"]');
                const nik = nikInput.value;

                // Validasi NIK harus 16 digit
                if (nik.length !== 16) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'NIK harus 16 digit',
                    });
                    return;
                }

                // Validasi NIK harus angka
                if (!/^\d+$/.test(nik)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'NIK harus berupa angka',
                    });
                }
            });
        });

        // Konfirmasi delete
        function confirmDelete(name, form) {
            Swal.fire({
                title: `Hapus ${name}?`,
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Tampilkan notifikasi
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection