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
</style>
@extends('layouts.sidebar')

@section('content')
    <!-- Main Content -->
    <div class="col-lg-10 content-wrapper px-3 px-md-4 py-4">
        <h2 class="mb-4">Aircraft Component Tracking</h2>

        <!-- Filter Section -->
        <div class="filter-section mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-md">
                    <!-- Empty space to push filters to the right -->
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

        <!-- Insert Button -->
        <div class="mb-3 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">
                <i class="bi bi-plus-circle"></i> Insert Component
            </button>
        </div>

        <!-- Modal Insert Component -->
        <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel">Tambah Komponen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('part.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_mekanik" class="form-label">Pilih Mekanik</label>
                                <select name="id_mekanik" class="form-control" required>
                                    <option value="">Pilih Mekanik</option>
                                    @foreach ($mekanik as $m)
                                        <option value="{{ $m->id_mekanik }}">{{ $m->nama_mekanik }}</option>
                                    @endforeach
                                </select>
                                @error('id_mekanik')
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
                                <small class="form-text text-muted">Pilih urutan step yang akan dilakukan (gunakan Ctrl/Cmd
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
        <!-- Table - Responsive -->
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
                                    <td>{{ $part->akunMekanik->nama_mekanik }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="status-badge bg-info bg-opacity-25 text-info me-2">In
                                                Progress</span>
                                            <div class="flex-grow-1">
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: 45%;" aria-valuenow="45" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <div class="text-end mt-1"><small>45%</small></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
