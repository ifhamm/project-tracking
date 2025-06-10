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
</style>
@extends('layouts.sidebar')

@section('content')
    <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
        <h2 class="mb-4">Aircraft Component Tracking</h2>

        <div class="filter-section mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md">
                </div>
                <div class="col-md-auto">
                    <label for="statusFilter" class="me-2 fw-semibold">Status:</label>
                    <select id="statusFilter" class="form-select">
                        <option selected>All</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                        <option>Not Started</option>
                    </select>
                </div>
                <div class="col-md-auto">
                    <label for="dateFilter" class="me-2 fw-semibold">Date:</label>
                    <input type="search" id="dateFilter" class="form-control" placeholder="Search">
                </div>
            </div>
        </div>

        @if (in_array(Session::get('role'), ['superadmin']))
            <div class="mb-3 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                    <i class="bi bi-plus-circle"></i> Insert Component
                </button>
            </div>

            <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="insertModalLabel">Tambah Komponen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('part.store') }}" method="POST">
                            @csrf
                            <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                                <div class="mb-3">
                                    <label for="id_credentials" class="form-label">Pilih Mekanik</label>
                                    <select name="id_credentials" class="form-control" required>
                                        <option value="" disabled selected>Pilih Mekanik</option>
                                        @foreach ($mekanik as $m)
                                            <option value="{{ $m->id_credentials }}">{{ $m->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_credentials')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="no_wbs" class="form-label">No WBS</label>
                                    <input type="text" class="form-control @error('no_wbs') is-invalid @enderror"
                                        id="no_wbs" name="no_wbs" value="{{ old('no_wbs') }}" required>
                                    @error('no_wbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="incoming_date" class="form-label">Tanggal Masuk</label>
                                    <input type="date" class="form-control @error('incoming_date') is-invalid @enderror"
                                        id="incoming_date" name="incoming_date" value="{{ old('incoming_date') }}" required>
                                    @error('incoming_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="part_name" class="form-label">Nama Part</label>
                                    <input type="text" class="form-control @error('part_name') is-invalid @enderror"
                                        id="part_name" name="part_name" value="{{ old('part_name') }}" required>
                                    @error('part_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="part_number" class="form-label">Nomor Part</label>
                                    <input type="text" class="form-control @error('part_number') is-invalid @enderror"
                                        id="part_number" name="part_number" value="{{ old('part_number') }}" required>
                                    @error('part_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_seri" class="form-label">Nomor Seri (Opsional)</label>
                                    <input type="text" class="form-control @error('no_seri') is-invalid @enderror"
                                        id="no_seri" name="no_seri" value="{{ old('no_seri') }}">
                                    @error('no_seri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="step_sequence" class="form-label">Urutan Step</label>
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
                                    <small class="form-text text-muted">Pilih urutan step yang akan dilakukan (gunakan
                                        Ctrl/Cmd
                                        untuk memilih multiple)</small>
                                    @error('step_sequence')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="customer" class="form-label">Customer</label>
                                    <textarea class="form-control @error('customer') is-invalid @enderror" id="customer" name="customer">{{ old('customer') }}</textarea>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
        @endif

        <div class="card">
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
                                <th class="text-center">Detail (BDP)</th>
                                @if (in_array(Session::get('role'), ['superadmin']))
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Hapus</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parts as $part)
                                <tr>
                                    <td>{{ $part->no_wbs }}</td>
                                    <td>{{ $part->part_name }}</td>
                                    <td>{{ $part->part_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($part->incoming_date)->format('M d, Y') }}
                                    </td>
                                    <td>{{ $part->customer }}</td>
                                    <td>{{ $part->akunMekanik->name }}</td>
                                    @php
                                        $totalSteps = $part->workProgres->count();
                                        $completedSteps = $part->workProgres->where('is_completed', 1)->count();
                                    @endphp

                                    @php
                                        $totalSteps = $part->workProgres->count();
                                        $completedSteps = $part->workProgres->where('is_completed', 1)->count();
                                    @endphp

                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($totalSteps === 0)
                                                <span class="status-badge bg-secondary bg-opacity-25 text-secondary me-2">
                                                    Belum Diproses
                                                </span>
                                            @elseif ($completedSteps < $totalSteps)
                                                <span class="status-badge bg-warning bg-opacity-25 text-dark me-2">
                                                    Sedang Proses ({{ $completedSteps }}/{{ $totalSteps }})
                                                </span>
                                            @else
                                                <span class="status-badge bg-success text-white me-2">
                                                    Selesai
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="table-action-cell">
                                        <a href="{{ route('detail.komponen', ['id' => $part->no_iwo]) }}"
                                            class="btn btn-info btn-sm" title="Lihat Detail (BDP)">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </a>
                                    </td>
                                    @if (in_array(Session::get('role'), ['superadmin']))
                                        <td class="table-action-cell">
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $part->no_iwo }}" title="Edit Komponen">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                        <td class="table-action-cell">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-no-iwo="{{ $part->no_iwo }}" title="Hapus Komponen">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    @endif
                                </tr>

                                <div class="modal fade" id="editModal{{ $part->no_iwo }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('part.update', ['no_iwo' => $part->no_iwo]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Komponen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="id_credentials{{ $part->no_iwo }}"
                                                            class="form-label">Pilih Mekanik</label>
                                                        <select name="id_credentials" class="form-control" required>
                                                            <option value="">Pilih Mekanik</option>
                                                            @foreach ($mekanik as $m)
                                                                <option value="{{ $m->id_credentials }}"
                                                                    {{ $part->id_credentials == $m->id_credentials ? 'selected' : '' }}>
                                                                    {{ $m->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_wbs{{ $part->no_iwo }}" class="form-label">No
                                                            WBS</label>
                                                        <input type="text" class="form-control"
                                                            id="no_wbs{{ $part->no_iwo }}" name="no_wbs"
                                                            value="{{ $part->no_wbs }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="incoming_date{{ $part->no_iwo }}"
                                                            class="form-label">Tanggal Masuk</label>
                                                        <input type="date" class="form-control"
                                                            id="incoming_date{{ $part->no_iwo }}" name="incoming_date"
                                                            value="{{ $part->incoming_date }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="part_name{{ $part->no_iwo }}" class="form-label">Nama
                                                            Part</label>
                                                        <input type="text" class="form-control"
                                                            id="part_name{{ $part->no_iwo }}" name="part_name"
                                                            value="{{ $part->part_name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="part_number{{ $part->no_iwo }}"
                                                            class="form-label">Nomor Part</label>
                                                        <input type="text" class="form-control"
                                                            id="part_number{{ $part->no_iwo }}" name="part_number"
                                                            value="{{ $part->part_number }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="no_seri{{ $part->no_iwo }}" class="form-label">Nomor
                                                            Seri (Opsional)</label>
                                                        <input type="text" class="form-control"
                                                            id="no_seri{{ $part->no_iwo }}" name="no_seri"
                                                            value="{{ $part->no_seri }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description{{ $part->no_iwo }}"
                                                            class="form-label">Deskripsi (Opsional)</label>
                                                        <textarea class="form-control" id="description{{ $part->no_iwo }}" name="description">{{ $part->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="step_sequence{{ $part->no_iwo }}"
                                                            class="form-label">Urutan Step</label>
                                                        <select class="form-select" id="step_sequence{{ $part->no_iwo }}"
                                                            name="step_sequence[]" multiple required>
                                                            <option value="1"
                                                                {{ is_array($part->step_sequence) && in_array(1, $part->step_sequence) ? 'selected' : '' }}>
                                                                Incoming</option>
                                                            <option value="2"
                                                                {{ is_array($part->step_sequence) && in_array(2, $part->step_sequence) ? 'selected' : '' }}>
                                                                Pre Test</option>
                                                            <option value="3"
                                                                {{ is_array($part->step_sequence) && in_array(3, $part->step_sequence) ? 'selected' : '' }}>
                                                                Disassembly</option>
                                                            <option value="4"
                                                                {{ is_array($part->step_sequence) && in_array(4, $part->step_sequence) ? 'selected' : '' }}>
                                                                Check + Stripping</option>
                                                            <option value="5"
                                                                {{ is_array($part->step_sequence) && in_array(5, $part->step_sequence) ? 'selected' : '' }}>
                                                                Cleaning</option>
                                                            <option value="6"
                                                                {{ is_array($part->step_sequence) && in_array(6, $part->step_sequence) ? 'selected' : '' }}>
                                                                Assembly + Repair</option>
                                                            <option value="7"
                                                                {{ is_array($part->step_sequence) && in_array(7, $part->step_sequence) ? 'selected' : '' }}>
                                                                Post Test</option>
                                                            <option value="8"
                                                                {{ is_array($part->step_sequence) && in_array(8, $part->step_sequence) ? 'selected' : '' }}>
                                                                Final Inspection</option>
                                                        </select>
                                                        <small class="form-text text-muted">Pilih urutan step yang akan
                                                            dilakukan (gunakan Ctrl/Cmd untuk memilih multiple)</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="customer{{ $part->no_iwo }}"
                                                            class="form-label">Customer</label>
                                                        <textarea class="form-control" id="customer{{ $part->no_iwo }}" name="customer">{{ $part->customer }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan
                                                        Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $parts->firstItem() ?? 0 }} to {{ $parts->lastItem() ?? 0 }} of {{ $parts->total() }} entries
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($parts->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $parts->previousPageUrl() }}" rel="prev">Previous</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
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

                    {{-- Next Page Link --}}
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert for success messages (e.g., after edit/insert)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            // SweetAlert for error messages
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                });
            @endif

            // SweetAlert for Delete Confirmation
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const noIwo = this.dataset.noIwo;
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Anda tidak akan bisa mengembalikan ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action =
                                `{{ url('part/delete') }}/${noIwo}`;

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
