@extends('layouts.sidebar')

@section('content')
<div class="p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-gear me-3"></i>
                Proses Mekanik
            </h1>
            <p class="text-muted mb-0">Monitor dan update progress komponen</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('proses-mekanik') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label for="no_wbs" class="form-label fw-semibold">
                            <i class="bi bi-upc-scan me-2"></i>Nomor Komponen
                        </label>
                        <input type="text" class="form-control" id="no_wbs" name="no_wbs" 
                               placeholder="Cari nomor komponen" value="{{ request('no_wbs') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="teknisi" class="form-label fw-semibold">
                            <i class="bi bi-person-gear me-2"></i>Teknisi
                        </label>
                        <input type="text" class="form-control" id="teknisi" name="teknisi" 
                               placeholder="Cari teknisi" value="{{ request('teknisi') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="step" class="form-label fw-semibold">
                            <i class="bi bi-list-check me-2"></i>Step Saat Ini
                        </label>
                        <input type="text" class="form-control" id="step" name="step" 
                               placeholder="Cari step" value="{{ request('step') }}">
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('proses-mekanik') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Daftar Proses Komponen
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>No IWO</th>
                            <th>Nomor Komponen</th>
                            <th>Part Name</th>
                            <th>Part Number</th>
                            <th>Serial Number</th>
                            <th>Step Saat Ini</th>
                            <th>Status</th>
                            <th>Teknisi</th>
                            <th>Priority</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parts as $part)
                            @php
                                $currentStep = $part->workProgres->where('is_completed', false)->first();
                                $status = $currentStep ? 'In Progress' : 'Completed';
                            @endphp
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $part->customer }}</span>
                                </td>
                                <td>
                                    <span class="text-primary fw-semibold">{{ $part->no_iwo }}</span>
                                </td>
                                <td>{{ $part->no_wbs }}</td>
                                <td>{{ $part->part_name }}</td>
                                <td>{{ $part->part_number }}</td>
                                <td>{{ $part->no_seri }}</td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $currentStep ? $currentStep->step_name : 'Completed' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $status === 'In Progress' ? 'bg-warning' : 'bg-success' }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2 text-muted"></i>
                                        {{ $part->akunMekanik->name ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    @if ($part->is_urgent == 1)
                                        <div class="text-center">
                                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if ($currentStep)
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal" 
                                                    data-no-iwo="{{ $part->no_iwo }}"
                                                    data-step="{{ $currentStep->step_name }}" 
                                                    data-status="{{ $status }}"
                                                    title="Edit Status">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewModal" 
                                                data-no-iwo="{{ $part->no_iwo }}"
                                                data-step="{{ $currentStep ? $currentStep->step_name : 'Completed' }}"
                                                data-status="{{ $status }}"
                                                data-teknisi="{{ $part->akunMekanik->name ?? '-' }}"
                                                data-next-step="{{ $part->next_step ?? '-' }}"
                                                title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </button>
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
            {{ $parts->links() }}
        </nav>
    </div>
    @endif

    <!-- Edit Modal for Mark as Complete -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="bi bi-pencil me-2"></i>Update Status Komponen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="no_iwo" name="no_iwo">
                        <div class="mb-3">
                            <label for="komponenInfo" class="form-label fw-semibold">Nomor Komponen</label>
                            <input type="text" class="form-control" id="komponenInfo" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="stepInfo" class="form-label fw-semibold">Step Saat Ini</label>
                            <input type="text" class="form-control" id="stepInfo" readonly>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="markComplete">
                            <label class="form-check-label fw-semibold" for="markComplete">
                                <i class="bi bi-check-circle me-2"></i>Tandai sebagai Selesai
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph me-2"></i>Keterangan (opsional)
                            </label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                                      placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="saveStatus" disabled>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text">
                            <i class="bi bi-check-circle me-1"></i>Simpan
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Komponen
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">
                            <i class="bi bi-upc-scan me-2"></i>Nomor Komponen:
                        </div>
                        <div class="col-md-8" id="viewKomponen"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">
                            <i class="bi bi-list-check me-2"></i>Step Saat Ini:
                        </div>
                        <div class="col-md-8" id="viewStep"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">
                            <i class="bi bi-arrow-right me-2"></i>Step Berikutnya:
                        </div>
                        <div class="col-md-8" id="viewNextStep"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">
                            <i class="bi bi-flag me-2"></i>Status:
                        </div>
                        <div class="col-md-8" id="viewStatus"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-semibold">
                            <i class="bi bi-person-gear me-2"></i>Teknisi:
                        </div>
                        <div class="col-md-8" id="viewTeknisi"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
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
    // Edit Modal
    document.getElementById('editModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const noIwo = button.getAttribute('data-no-iwo');
        const step = button.getAttribute('data-step');
        const status = button.getAttribute('data-status');

        document.getElementById('no_iwo').value = noIwo;
        document.getElementById('komponenInfo').value = noIwo;
        document.getElementById('stepInfo').value = step;
        document.getElementById('markComplete').checked = status === 'Completed';
        
        // Enable/disable save button based on checkbox
        const saveButton = document.getElementById('saveStatus');
        saveButton.disabled = !document.getElementById('markComplete').checked;
    });

    // Checkbox change event
    document.getElementById('markComplete').addEventListener('change', function() {
        const saveButton = document.getElementById('saveStatus');
        saveButton.disabled = !this.checked;
    });

    // Save status changes with SweetAlert2
    document.getElementById('saveStatus').addEventListener('click', function() {
        const button = this;
        const noIwo = document.getElementById('no_iwo').value;
        const isComplete = document.getElementById('markComplete').checked;
        const keterangan = document.getElementById('keterangan').value;

        // Validate no_iwo is a valid UUID
        if (!noIwo || !/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(noIwo)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid component number format'
            });
            return;
        }

        // Show loading state
        const spinner = button.querySelector('.spinner-border');
        const buttonText = button.querySelector('.btn-text');
        spinner.classList.remove('d-none');
        buttonText.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Menyimpan...';
        button.disabled = true;

        fetch('{{ route('proses-mekanik.update-step') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    no_iwo: noIwo,
                    is_completed: isComplete,
                    keterangan: keterangan
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Server error');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Close modal
                const editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                editModal.hide();

                // Show success message with SweetAlert2
                if (data.all_completed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Selesai!',
                        text: 'Semua step telah selesai! Komponen telah selesai diproses.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Status berhasil diperbarui! Komponen telah dipindahkan ke step berikutnya.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                // Reset button state
                spinner.classList.add('d-none');
                buttonText.innerHTML = '<i class="bi bi-check-circle me-1"></i>Simpan';
                button.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui status: ' + error.message
                });
            });
    });

    // View Modal
    document.getElementById('viewModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const noIwo = button.getAttribute('data-no-iwo');
        const step = button.getAttribute('data-step');
        const status = button.getAttribute('data-status');
        const teknisi = button.getAttribute('data-teknisi');
        const nextStep = button.getAttribute('data-next-step');

        document.getElementById('viewKomponen').textContent = noIwo;
        document.getElementById('viewStep').textContent = step;
        document.getElementById('viewNextStep').textContent = nextStep || 'Tidak ada step berikutnya';
        document.getElementById('viewStatus').textContent = status;
        document.getElementById('viewTeknisi').textContent = teknisi;
    });
</script>
@endsection
