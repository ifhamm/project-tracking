<style>
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

    .table-action-cell {
        white-space: nowrap;
        text-align: center;
    }

    .table-action-cell .btn {
        padding: 6px 12px;
        font-size: 0.875rem;
        min-width: 80px;
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .btn-group .btn {
        border-radius: 6px;
        margin: 0 1px;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .progress {
            width: 60px !important;
        }

        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
    }
</style>
@extends('layouts.sidebar')

@section('content')
<div class="p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-boxes me-3"></i>
                Aircraft Component Tracking
            </h1>
            <p class="text-muted mb-0">Kelola dan monitor komponen pesawat</p>
        </div>
        @if (in_array(Session::get('role'), ['superadmin','ppc']))
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
            <i class="bi bi-plus-circle me-2"></i>Insert Component
        </button>
        @endif
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label for="statusFilter" class="form-label fw-semibold">
                        <i class="bi bi-funnel me-2"></i>Status
                    </label>
                    <select id="statusFilter" name="status" class="form-select">
                        <option value="">All</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label for="searchFilter" class="form-label fw-semibold">
                        <i class="bi bi-search me-2"></i>Search
                    </label>
                    <input type="search" id="searchFilter" name="search" class="form-control" placeholder="Search components...">
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                        <button type="button" class="btn btn-outline-secondary flex-fill" onclick="resetFilters()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Insert Modal -->
    @if (in_array(Session::get('role'), ['superadmin','ppc']))
    <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insertModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Komponen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('part.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_credentials" class="form-label fw-semibold">
                                        <i class="bi bi-person-gear me-2"></i>Pilih Mekanik
                                    </label>
                                    <select name="id_credentials" class="form-select" required>
                                        <option value="" disabled selected>Pilih Mekanik</option>
                                        @foreach ($mekanik as $m)
                                            <option value="{{ $m->id_credentials }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_credentials')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer" class="form-label fw-semibold">
                                        <i class="bi bi-building me-2"></i>Customer
                                    </label>
                                    <input type="text" class="form-control @error('customer') is-invalid @enderror" 
                                           id="customer" name="customer" value="{{ old('customer') }}" required>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_wbs" class="form-label fw-semibold">
                                        <i class="bi bi-upc-scan me-2"></i>No WBS
                                    </label>
                                    <input type="text" class="form-control @error('no_wbs') is-invalid @enderror"
                                        id="no_wbs" name="no_wbs" value="{{ old('no_wbs') }}" required>
                                    @error('no_wbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="incoming_date" class="form-label fw-semibold">
                                        <i class="bi bi-calendar me-2"></i>Tanggal Masuk
                                    </label>
                                    <input type="date" class="form-control @error('incoming_date') is-invalid @enderror"
                                        id="incoming_date" name="incoming_date" 
                                        value="{{ old('incoming_date', date('Y-m-d')) }}" 
                                        min="{{ date('Y-m-d') }}" 
                                        max="{{ date('Y-m-d') }}" 
                                        required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Hanya tanggal hari ini yang diizinkan
                                    </div>
                                    @error('incoming_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="part_name" class="form-label fw-semibold">
                                        <i class="bi bi-box me-2"></i>Nama Part
                                    </label>
                                    <input type="text" class="form-control @error('part_name') is-invalid @enderror"
                                        id="part_name" name="part_name" value="{{ old('part_name') }}" required>
                                    @error('part_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="part_number" class="form-label fw-semibold">
                                        <i class="bi bi-hash me-2"></i>Nomor Part
                                    </label>
                                    <input type="text" class="form-control @error('part_number') is-invalid @enderror"
                                        id="part_number" name="part_number" value="{{ old('part_number') }}" required>
                                    @error('part_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_seri" class="form-label fw-semibold">
                                        <i class="bi bi-upc me-2"></i>Nomor Seri (Opsional)
                                    </label>
                                    <input type="text" class="form-control @error('no_seri') is-invalid @enderror"
                                        id="no_seri" name="no_seri" value="{{ old('no_seri') }}">
                                    @error('no_seri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">
                                        <i class="bi bi-text-paragraph me-2"></i>Deskripsi (Opsional)
                                    </label>
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                           id="description" name="description" value="{{ old('description') }}">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="step_sequence" class="form-label fw-semibold">
                                <i class="bi bi-list-ol me-2"></i>Urutan Step
                            </label>
                            <select class="form-select @error('step_sequence') is-invalid @enderror"
                                id="step_sequence" name="step_sequence[]" multiple required>
                                <option value="1">Incoming</option>
                                <option value="2">Pre Test</option>
                                <option value="3">Disassembly</option>
                                <option value="4">Check + Stripping</option>
                                <option value="5">Cleaning</option>
                                <option value="6">Assembly + Repair</option>
                                <option value="7">Post Test</option>
                                <option value="8">Final Inspection</option>
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih urutan step yang akan dilakukan (gunakan Ctrl/Cmd untuk memilih multiple)
                            </div>
                            @error('step_sequence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    @endif

    <!-- Edit Modals for each part -->
    @if (in_array(Session::get('role'), ['superadmin','ppc']))
    @foreach($parts as $part)
    <div class="modal fade" id="editModal{{ $part->no_iwo }}" tabindex="-1" aria-labelledby="editModalLabel{{ $part->no_iwo }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $part->no_iwo }}">
                        <i class="bi bi-pencil me-2"></i>Edit Komponen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('part.update', $part->no_iwo) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_credentials{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-person-gear me-2"></i>Pilih Mekanik
                                    </label>
                                    <select name="id_credentials" class="form-select" required>
                                        <option value="" disabled>Pilih Mekanik</option>
                                        @foreach ($mekanik as $m)
                                            <option value="{{ $m->id_credentials }}" {{ $part->id_credentials == $m->id_credentials ? 'selected' : '' }}>
                                                {{ $m->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-building me-2"></i>Customer
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="customer{{ $part->no_iwo }}" 
                                           name="customer" 
                                           value="{{ $part->customer }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_wbs{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-upc-scan me-2"></i>No WBS
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="no_wbs{{ $part->no_iwo }}" 
                                           name="no_wbs" 
                                           value="{{ $part->no_wbs }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="incoming_date{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-calendar me-2"></i>Tanggal Masuk
                                    </label>
                                    <input type="date" class="form-control" 
                                           id="incoming_date{{ $part->no_iwo }}" 
                                           name="incoming_date" 
                                           value="{{ $part->incoming_date }}" 
                                           min="{{ date('Y-m-d') }}" 
                                           max="{{ date('Y-m-d') }}" 
                                           required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Hanya tanggal hari ini yang diizinkan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="part_name{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-box me-2"></i>Nama Part
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="part_name{{ $part->no_iwo }}" 
                                           name="part_name" 
                                           value="{{ $part->part_name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="part_number{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-hash me-2"></i>Nomor Part
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="part_number{{ $part->no_iwo }}" 
                                           name="part_number" 
                                           value="{{ $part->part_number }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_seri{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-upc me-2"></i>Nomor Seri (Opsional)
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="no_seri{{ $part->no_iwo }}" 
                                           name="no_seri" 
                                           value="{{ $part->no_seri }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description{{ $part->no_iwo }}" class="form-label fw-semibold">
                                        <i class="bi bi-text-paragraph me-2"></i>Deskripsi (Opsional)
                                    </label>
                                    <input type="text" class="form-control" 
                                           id="description{{ $part->no_iwo }}" 
                                           name="description" 
                                           value="{{ $part->description }}">
                                </div>
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
    @endforeach
    @endif

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
                            <th>No WBS</th>
                            <th>Part Name</th>
                            <th>Part Number</th>
                            <th>Date Received</th>
                            <th>Customer</th>
                            <th>Mekanik</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parts as $part)
                        @php
                            $totalSteps = $part->workProgres->count();
                            $completedSteps = $part->workProgres->where('is_completed', true)->count();
                            $progress = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                            
                            if ($progress == 0) {
                                $status = 'Not Started';
                                $statusClass = 'bg-secondary';
                            } elseif ($progress == 100) {
                                $status = 'Completed';
                                $statusClass = 'bg-success';
                            } else {
                                $status = 'In Progress';
                                $statusClass = 'bg-warning';
                            }
                        @endphp
                        <tr>
                            <td>
                                <span class="fw-semibold text-primary">{{ $part->no_wbs }}</span>
                            </td>
                            <td>{{ $part->part_name }}</td>
                            <td>{{ $part->part_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') }}</td>
                            <td>
                                <span class="fw-semibold">{{ $part->customer }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-muted"></i>
                                    {{ $part->akunMekanik->name ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress me-2" style="width: 80px; height: 8px;">
                                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ round($progress) }}%</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ $status }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('part.show', $part->no_iwo) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if (in_array(Session::get('role'), ['superadmin','ppc']))
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal{{ $part->no_iwo }}"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="deletePart('{{ $part->no_iwo }}')" 
                                            title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($parts->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            <small>
                Showing {{ $parts->firstItem() ?? 0 }} to {{ $parts->lastItem() ?? 0 }} of {{ $parts->total() }} entries
            </small>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0">
                @if ($parts->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $parts->previousPageUrl() }}" rel="prev">Previous</a>
                    </li>
                @endif

                @foreach ($parts->getUrlRange(1, $parts->lastPage()) as $page => $url)
                    @if ($page == $parts->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                @if ($parts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $parts->nextPageUrl() }}" rel="next">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function resetFilters() {
        Swal.fire({
            title: 'Reset Filter',
            text: 'Apakah Anda yakin ingin mereset semua filter?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('statusFilter').value = '';
                document.getElementById('searchFilter').value = '';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Filter Direset!',
                    text: 'Semua filter telah direset.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route('komponen') }}';
                });
            }
        });
    }

    function deletePart(noIwo) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus komponen ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/part/delete/${noIwo}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Komponen berhasil dihapus.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Gagal menghapus komponen'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus komponen'
                    });
                });
            }
        });
    }

    // Date validation for insert form
    document.addEventListener('DOMContentLoaded', function() {
        const incomingDateInput = document.getElementById('incoming_date');
        if (incomingDateInput) {
            // Set min and max date to today (only today is allowed)
            const today = new Date();
            // Convert to WIB (UTC+7)
            const wibDate = new Date(today.getTime() + (7 * 60 * 60 * 1000));
            const todayString = wibDate.toISOString().split('T')[0];
            incomingDateInput.value = todayString;
            incomingDateInput.setAttribute('min', todayString);
            incomingDateInput.setAttribute('max', todayString);
            
            // Add validation on change
            incomingDateInput.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                // Convert to WIB (UTC+7)
                const wibDate = new Date(today.getTime() + (7 * 60 * 60 * 1000));
                wibDate.setHours(0, 0, 0, 0); // Reset time to start of day
                const selectedDay = new Date(selectedDate);
                selectedDay.setHours(0, 0, 0, 0); // Reset time to start of day
                
                if (selectedDay.getTime() !== wibDate.getTime()) {
                    this.setCustomValidity('Hanya tanggal hari ini yang diizinkan');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });
        }
        
        // Date validation for edit forms
        const editDateInputs = document.querySelectorAll('input[id^="incoming_date"][id!="incoming_date"]');
        editDateInputs.forEach(function(input) {
            const today = new Date();
            // Convert to WIB (UTC+7)
            const wibDate = new Date(today.getTime() + (7 * 60 * 60 * 1000));
            const todayString = wibDate.toISOString().split('T')[0];
            input.setAttribute('min', todayString);
            input.setAttribute('max', todayString);
            
            input.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                // Convert to WIB (UTC+7)
                const wibDate = new Date(today.getTime() + (7 * 60 * 60 * 1000));
                wibDate.setHours(0, 0, 0, 0); // Reset time to start of day
                const selectedDay = new Date(selectedDate);
                selectedDay.setHours(0, 0, 0, 0); // Reset time to start of day
                
                if (selectedDay.getTime() !== wibDate.getTime()) {
                    this.setCustomValidity('Hanya tanggal hari ini yang diizinkan');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show validation errors with SweetAlert
        const errorMessages = [];
        @foreach ($errors->all() as $error)
            errorMessages.push('{{ $error }}');
        @endforeach
        
        Swal.fire({
            icon: 'error',
            title: 'Validasi Error',
            html: errorMessages.join('<br>'),
            confirmButtonColor: '#d33'
        });
        
        // Show the modal
        var insertModal = new bootstrap.Modal(document.getElementById('insertModal'));
        insertModal.show();
    });
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var insertModalEl = document.getElementById('insertModal');
        if (insertModalEl) {
            insertModalEl.addEventListener('hidden.bs.modal', function () {
                var form = insertModalEl.querySelector('form');
                if(form) form.reset();
                insertModalEl.querySelectorAll('.is-invalid').forEach(function(el) {
                    el.classList.remove('is-invalid');
                });
                insertModalEl.querySelectorAll('.invalid-feedback').forEach(function(el) {
                    el.innerHTML = '';
                });
            });
        }
        
        // Show success messages with SweetAlert
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        
        // Show error messages with SweetAlert
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    });
</script>
@endsection
