<style>
    .modal-dialog {
        margin: 0;
        max-width: 100vw;
    }

    .modal-content {
        background-color: #000;
        border: none;
        height: 80vh;
        display: flex;
        /* align-items: center; */
        justify-content: center;
        overflow: hidden;
    }

    .modal-img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.9);
    }


    .modal-img {
        max-width: 100%;
        max-height: 80vh;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        margin: auto;
        border-radius: 8px;
    }

.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
}

.modal-dialog-scrollable {
    max-height: 90vh;
}

.modal-content {
    background: #121212;
    color: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    overflow: hidden;
}


.modal-header {
    background: linear-gradient(135deg, #0f2a4a,rgb(22, 47, 131));
    color: #f8fafc;
    border-bottom: 1px solid #333;
    position: sticky;
    top: 0;
    z-index: 5;
    padding: 1rem 1.5rem;
}

.modal-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.btn-close {
    filter: invert(1);
    opacity: 0.8;
}

.modal-body {
    padding: 1.5rem;
    background-color: #f8fafc;
}

/* Step section */
.modal-body h6 {
    color: black;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* grid */
.modal-body .d-flex.flex-wrap {
    gap: 0.5rem;
}

/* Thumbnail style */
.previewable-image {
    width: 120px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #444;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.previewable-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
    cursor: pointer;
}


    /* --- Modal Styling --- */


#imagePreviewModal .modal-content {
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.8);
    animation: zoomIn 0.3s ease-in-out;
    position: relative;
    padding: 0;
    background-color: transparent;
}

/* --- Image Styling --- */
#imagePreviewModal .modal-img {
    /* max-width: 100%; */
    max-height: 80vh;
    object-fit: contain;
    border-radius: 12px;
    margin: auto;
    display: block;
    transition: transform 0.3s ease;
    background-color: transparent;
}

/* --- Close Button --- */
#imagePreviewModal .close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 1.8rem;
    color: black;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 36px;
    text-align: center;
    cursor: pointer;
    z-index: 10;
    transition: background 0.3s ease;
}

#imagePreviewModal .close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* --- Zoom Animation --- */
@keyframes zoomIn {
    from {
        transform: scale(0.85);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* --- Responsive Fix --- */
@media (max-width: 768px) {
    #imagePreviewModal .modal-img {
        max-height: 60vh;
    }
    #imagePreviewModal .close-btn {
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        font-size: 1.5rem;
    }
}


</style>



@extends('layouts.sidebar')

@section('content')
<div class="container-fluid col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Dokumentasi Proses Mekanik</h2>

    <!-- Filter Form -->
    <div class="row mb-4 g-2">
        <form action="{{ route('dokumentasi.filter') }}" method="GET" class="row g-2 w-100">
            <div class="col-md-3">
                <input type="text" class="form-control" name="no_wbs" placeholder="Nomor WBS"
                    value="{{ request('no_wbs') }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="customer" placeholder="Customer"
                    value="{{ request('customer') }}">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="teknisi" placeholder="Teknisi"
                    value="{{ request('teknisi') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer</th>
                    <!-- <th>No IWO</th> -->
                    <th>No WBS</th>
                    <th>Part Name</th>
                    <!-- <th>Part Number</th> -->
                    <!-- <th>Serial Number</th> -->
                    <th>Step Saat Ini</th>
                    <th>Status</th>
                    <th>Teknisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parts as $part)
                @php
                $allSteps = $part->workProgres;
                $existingDocs = $part->dokumentasiMekanik()->get()->groupBy('step_name');
                @endphp
                @php
                $allSteps = $part->workProgres->pluck('step_name');
                $existingDocs = $part->dokumentasiMekanik()->get()->groupBy('step_name');

                // Ambil step pertama yang belum ada dokumentasinya
                $currentStepName = $allSteps->first(function ($stepName) use ($existingDocs) {
                return !$existingDocs->has($stepName);
                });

                $status = $currentStepName ? 'In Progress' : 'Completed';
                @endphp

                @php
                $currentStepName = $allSteps->first(function ($stepName) use ($existingDocs) {
                return !$existingDocs->has($stepName);
                });
                $status = $currentStepName ? 'In Progress' : 'Completed';
                @endphp

                <!-- @php
                $currentStep = $part->workProgres->where('is_completed', false)->first();
                $status = $currentStep ? 'In Progress' : 'Completed';
                $existingDoc = $part->dokumentasiMekanik()
                ->where('step_name', $currentStep?->step_name)
                ->first();
                @endphp -->
                <tr>
                    <td>{{ $part->customer }}</td>
                    <!-- <td>{{ $part->no_iwo }}</td> -->
                    <td>{{ $part->no_wbs }}</td>
                    <td>{{ $part->part_name }}</td>
                    <!-- <td>{{ $part->part_number }}</td> -->
                    <!-- <td>{{ $part->no_seri }}</td> -->
                    <td>{{ $currentStep?->step_name ?? 'Completed' }}</td>
                    <td>
                        <span class="status-badge {{ strtolower(str_replace(' ', '-', $status)) }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td>{{ $part->akunMekanik->name }}</td>
                    <td>
                        <!-- Current Step Upload/Display -->
                        @php $currentStepName = $currentStep?->step_name; @endphp


                        @if ($currentStepName)
                        @php
                        $docsForCurrentStep = $existingDocs[$currentStepName] ?? collect();
                        @endphp

                        @if ($docsForCurrentStep->isNotEmpty())
                        <!-- <div class="mb-2">
                            @foreach ($docsForCurrentStep as $doc)
                            <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail me-1 mb-1 previewable-image" style="cursor: pointer;">
                            @endforeach
                        </div> -->
                        <div class="d-flex flex-wrap">
@foreach ($docsForCurrentStep as $doc)
    <div class="position-relative me-2 mb-2">
        <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail">

        {{-- Tombol hapus --}}
        <form action="{{ route('dokumentasi.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?')" class="position-absolute top-0 end-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger px-1 py-0" style="font-size:12px;">&times;</button>
        </form>
    </div>
@endforeach
</div>

                        @endif

                        <form action="{{ route('dokumentasi.upload') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">
                            <input type="hidden" name="no_wbs" value="{{ $part->no_wbs }}">
                            <input type="hidden" name="komponen" value="{{ $part->part_name }}">
                            <input type="hidden" name="step_name" value="{{ $currentStepName }}">
                            <input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::now()->toDateString() }}">

                            <input type="file" name="foto[]" class="form-control form-control-sm mb-1" multiple required accept="image/*">
                            <small class="text-muted">*Upload 1 atau lebih foto dokumentasi</small>

                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
                        @endif


                        <!-- Expandable Previous Steps -->
                        <!-- Expandable Previous Steps -->
                        @if ($existingDocs->count() > 0)
                        <!-- Tombol untuk buka modal -->
                        <button class="btn btn-sm btn-secondary mt-2" type="button" data-bs-toggle="modal" data-bs-target="#modalSteps{{ $part->no_iwo }}">
                            Lihat Step Sebelumnya
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="modalSteps{{ $part->no_iwo }}" tabindex="-1" aria-labelledby="modalStepsLabel{{ $part->no_iwo }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalStepsLabel{{ $part->no_iwo }}">Dokumentasi Step Sebelumnya - {{ $part->no_wbs }} - {{ $part->part_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($existingDocs as $step => $docs)
                                        @if ($step !== $currentStepName)
                                        <div class="mb-4">
                                            <h6 class="mb-2">{{ $step }}</h6>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($docs as $doc)
                                                <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail me-1 mb-1 previewable-image" style="cursor: pointer;">
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
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


<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content position-relative">
            <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                <img id="previewImage" src="" alt="Preview" class="modal-img">
            </div>
        </div>
    </div>
</div>



@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        const modalImage = document.getElementById('previewImage');

        document.querySelectorAll('.previewable-image').forEach(img => {
            img.addEventListener('click', function() {
                modalImage.src = this.src;
                modal.show();
            });
        });
    });

    document.getElementById('imagePreviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            bootstrap.Modal.getInstance(this).hide();
        }
    });
</script>