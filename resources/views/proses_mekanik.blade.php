<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .status-badge {
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 14px;
    }

    .in-progress {
        background-color: #e0f7ee;
        color: #0f5132;
        font-size: 12px;
    }

    .completed {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .not-started {
        background-color: #e2e3e5;
        color: #41464b;
    }

    .action-btn {
        color: #0d6efd;
        cursor: pointer;
        text-decoration: underline;
    }

    .dropdown-menu {
        min-width: 120px;
    }

    .dropdown-item {
        padding: 8px 15px;
        font-size: 14px;
    }
</style>

@extends('layouts.sidebar')

@section('content')
    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
        <h2 class="mb-4">Proses Mekanik</h2>

        <!-- Filter Form -->
        <div class="row mb-4 g-2">
            <form action="{{ route('proses-mekanik') }}" method="GET" class="row g-2 w-100">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="no_wbs" placeholder="Nomor Komponen"
                        value="{{ request('no_wbs') }}">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="teknisi" placeholder="Teknisi"
                        value="{{ request('teknisi') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="step" placeholder="Step Saat Ini"
                        value="{{ request('step') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>

        <!-- Main Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
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
                            <td>{{ $part->customer }}</td>
                            <td>{{ $part->no_iwo }}</td>
                            <td>{{ $part->no_wbs }}</td>
                            <td>{{ $part->part_name }}</td>
                            <td>{{ $part->part_number }}</td>
                            <td>{{ $part->no_seri }}</td>
                            <td>{{ $currentStep ? $currentStep->step_name : 'Completed' }}</td>
                            <td><span
                                    class="status-badge {{ strtolower(str_replace(' ', '-', $status)) }}">{{ $status }}</span>
                            </td>
                            <td>{{ $part->akunMekanik->nama_mekanik }}</td>
                            <td>
                                @if ($part->urgency_icon === 'red')
                                    <div class="text-center">
                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                    </div>
                                @elseif ($part->urgency_icon === 'yellow')
                                    <div class="text-center">
                                        <i class="fas fa-exclamation-circle text-warning"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($currentStep)
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-no-iwo="{{ $part->no_iwo }}"
                                        data-step="{{ $currentStep->step_name }}" data-status="{{ $status }}">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </button>
                                @endif
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#viewModal" data-no-iwo="{{ $part->no_iwo }}"
                                    data-step="{{ $currentStep ? $currentStep->step_name : 'Completed' }}"
                                    data-status="{{ $status }}"
                                    data-teknisi="{{ $part->akunMekanik->nama_mekanik }}"
                                    data-next-step="{{ $part->next_step }}">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Edit Modal for Mark as Complete -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Status Komponen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" id="no_iwo" name="no_iwo">
                            <div class="mb-3">
                                <label for="komponenInfo" class="form-label">Nomor Komponen</label>
                                <input type="text" class="form-control" id="komponenInfo" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="stepInfo" class="form-label">Step Saat Ini</label>
                                <input type="text" class="form-control" id="stepInfo" readonly>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="markComplete">
                                <label class="form-check-label" for="markComplete">Tandai sebagai
                                    Selesai</label>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveStatus">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Detail Komponen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Nomor Komponen:</div>
                            <div class="col-md-8" id="viewKomponen"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Step Saat Ini:</div>
                            <div class="col-md-8" id="viewStep"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Step Berikutnya:</div>
                            <div class="col-md-8" id="viewNextStep"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Status:</div>
                            <div class="col-md-8" id="viewStatus"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Teknisi:</div>
                            <div class="col-md-8" id="viewTeknisi"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Komponen Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createForm">
                            <div class="mb-3">
                                <label for="newKomponenId" class="form-label">Nomor Komponen</label>
                                <input type="text" class="form-control" id="newKomponenId" required>
                            </div>
                            <div class="mb-3">
                                <label for="newStep" class="form-label">Step Saat Ini</label>
                                <input type="text" class="form-control" id="newStep" required>
                            </div>
                            <div class="mb-3">
                                <label for="newStatus" class="form-label">Status</label>
                                <select class="form-select" id="newStatus" required>
                                    <option value="">Pilih Status</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Not Started">Not Started</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="newTeknisi" class="form-label">Teknisi</label>
                                <input type="text" class="form-control" id="newTeknisi">
                            </div>
                            <div class="mb-3">
                                <label for="newKeterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="newKeterangan" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveNew">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Komponen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm">
                            <input type="hidden" id="updateKomponenId" name="updateKomponenId">
                            <div class="mb-3">
                                <label for="updateKomponenNo" class="form-label">Nomor Komponen</label>
                                <input type="text" class="form-control" id="updateKomponenNo" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="updateStep" class="form-label">Step Saat Ini</label>
                                <input type="text" class="form-control" id="updateStep" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateStatus" class="form-label">Status</label>
                                <select class="form-select" id="updateStatus" required>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Not Started">Not Started</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="updateTeknisi" class="form-label">Teknisi</label>
                                <input type="text" class="form-control" id="updateTeknisi">
                            </div>
                            <div class="mb-3">
                                <label for="updateKeterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="updateKeterangan" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveUpdate">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus komponen <span id="deleteKomponenNo" class="fw-bold"></span>?
                        </p>
                        <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

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
            });

            // Save status changes with SweetAlert2
            document.getElementById('saveStatus').addEventListener('click', function() {
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
