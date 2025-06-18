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
<div class="p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-file-text me-3"></i>
                Dokumentasi Proses Mekanik
            </h1>
            <p class="text-muted mb-0">Upload dan kelola dokumentasi proses perbaikan komponen</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dokumentasi.filter') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label for="no_wbs" class="form-label fw-semibold">
                            <i class="bi bi-upc-scan me-2"></i>Nomor WBS
                        </label>
                        <input type="text" class="form-control" id="no_wbs" name="no_wbs" placeholder="Cari nomor WBS"
                            value="{{ request('no_wbs') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="customer" class="form-label fw-semibold">
                            <i class="bi bi-building me-2"></i>Customer
                        </label>
                        <input type="text" class="form-control" id="customer" name="customer" placeholder="Cari customer"
                            value="{{ request('customer') }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="teknisi" class="form-label fw-semibold">
                            <i class="bi bi-person-gear me-2"></i>Teknisi
                        </label>
                        <input type="text" class="form-control" id="teknisi" name="teknisi" placeholder="Cari teknisi"
                            value="{{ request('teknisi') }}">
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search me-2"></i>Filter
                            </button>
                            <a href="{{ route('dokumentasi-mekanik') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>Daftar Part untuk Dokumentasi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>No WBS</th>
                            <th>Part Name</th>
                            <th>Step Saat Ini</th>
                            <th>Status</th>
                            <th>Teknisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($parts as $part)
                        @php
                        $currentStep = $part->workProgres->where('is_completed', false)->first();
                        $status = $currentStep ? 'In Progress' : 'Completed';
                        @endphp
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $part->customer }}</span>
                            </td>
                            <td>
                                <a href="{{ route('dokumentasi.detail', $part->no_iwo) }}" 
                                   class="text-decoration-none fw-bold text-primary">
                                    {{ $part->no_wbs }}
                                </a>
                            </td>
                            <td>{{ $part->part_name }}</td>
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
                                @if($currentStep)
                                <button class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#uploadModal{{ $part->no_iwo }}">
                                    <i class="bi bi-upload me-1"></i>
                                    <span class="d-none d-md-inline">Upload</span>
                                </button>
                                @else
                                <span class="text-muted">
                                    <i class="bi bi-check-circle me-1"></i>Selesai
                                </span>
                                @endif
                            </td>
                        </tr>

                        <!-- Upload Modal for each part -->
                        @if($currentStep)
                        <div class="modal fade" id="uploadModal{{ $part->no_iwo }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="bi bi-upload me-2"></i>
                                            Upload Dokumentasi - {{ $part->no_wbs }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('dokumentasi.upload') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">No WBS</label>
                                                    <input type="text" class="form-control" value="{{ $part->no_wbs }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Part Name</label>
                                                    <input type="text" class="form-control" value="{{ $part->part_name }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Step</label>
                                                    <input type="text" class="form-control" value="{{ $currentStep->step_name }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Tanggal</label>
                                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('d M Y') }}" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="foto{{ $part->no_iwo }}" class="form-label fw-semibold">
                                                    <i class="bi bi-images me-2"></i>
                                                    Pilih Foto Dokumentasi
                                                </label>
                                                <input type="file" 
                                                       class="form-control" 
                                                       id="foto{{ $part->no_iwo }}" 
                                                       name="foto[]" 
                                                       multiple 
                                                       required 
                                                       accept="image/*"
                                                       onchange="previewImages(this, 'preview{{ $part->no_iwo }}')">
                                                <div class="form-text">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Pilih 1 atau lebih foto. Format: JPG, JPEG, PNG. Maksimal 5MB per foto.
                                                </div>
                                            </div>

                                            <!-- Image Preview -->
                                            <div id="preview{{ $part->no_iwo }}" class="d-flex flex-wrap gap-2"></div>

                                            <!-- Hidden inputs -->
                                            <input type="hidden" name="no_iwo" value="{{ $part->no_iwo }}">
                                            <input type="hidden" name="no_wbs" value="{{ $part->no_wbs }}">
                                            <input type="hidden" name="komponen" value="{{ $part->part_name }}">
                                            <input type="hidden" name="step_name" value="{{ $currentStep->step_name }}">
                                            <input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-upload me-1"></i>Upload Dokumentasi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-4"></i>
                                    <p class="mt-3 mb-1">Tidak ada part yang perlu dokumentasi</p>
                                    <small>Semua part telah selesai diproses</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
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

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }
    
    .modal-header .btn-close {
        filter: invert(1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    function previewImages(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.width = '100px';
                        img.style.height = '80px';
                        img.style.objectFit = 'cover';
                        img.style.margin = '2px';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }
</script>
@endsection