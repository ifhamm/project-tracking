@extends('layouts.sidebar')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="p-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-file-text me-3"></i>
                Detail Dokumentasi Part
            </h1>
            <p class="text-muted mb-0">Informasi lengkap dan dokumentasi part</p>
        </div>
        <a href="{{ route('dokumentasi-mekanik') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Informasi Part -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-info-circle me-2"></i>Informasi Part
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 150px;">No WBS</th>
                            <td class="fw-semibold">{{ $part->no_wbs }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Part Name</th>
                            <td class="fw-semibold">{{ $part->part_name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Part Number</th>
                            <td>{{ $part->part_number }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Serial Number</th>
                            <td>{{ $part->no_seri }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 150px;">Customer</th>
                            <td class="fw-semibold">{{ $part->customer }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Masuk</th>
                            <td>{{ \Carbon\Carbon::parse($part->incoming_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Teknisi</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-muted"></i>
                                    {{ $part->akunMekanik->name ?? '-' }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Status</th>
                            <td>
                                @php
                                    $totalSteps = $part->workProgres->count();
                                    $completedSteps = $part->workProgres->where('is_completed', true)->count();
                                    $progress = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress me-3" style="width: 120px; height: 8px;">
                                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <span class="text-muted fw-semibold">{{ $completedSteps }}/{{ $totalSteps }} Steps</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-list-check me-2"></i>Progress Steps
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($part->workProgres as $step)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 {{ $step->is_completed ? 'border-success' : 'border-warning' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="card-title mb-0 fw-semibold">{{ $step->step_name }}</h6>
                                <span class="badge {{ $step->is_completed ? 'bg-success' : 'bg-warning' }}">
                                    {{ $step->is_completed ? 'Selesai' : 'In Progress' }}
                                </span>
                            </div>
                            
                            @if($step->is_completed && $step->completed_at)
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Selesai: {{ \Carbon\Carbon::parse($step->completed_at)->format('d M Y H:i') }}
                                </small>
                            @endif

                            @if(isset($dokumentasiByStep[$step->step_name]))
                                <div class="mt-3">
                                    <small class="text-muted fw-semibold">Dokumentasi:</small>
                                    <div class="d-flex flex-wrap mt-2">
                                        @foreach($dokumentasiByStep[$step->step_name] as $doc)
                                        <div class="position-relative me-2 mb-2">
                                            <img src="{{ asset('storage/' . $doc->foto) }}" 
                                                 width="60" height="40" 
                                                 class="img-thumbnail previewable-image" 
                                                 style="object-fit: cover; cursor: pointer;"
                                                 title="{{ $doc->tanggal }}"
                                                 onerror="this.style.display='none'; console.log('Failed to load image:', '{{ asset('storage/' . $doc->foto) }}');">
                                            <button type="button" 
                                                    class="btn-delete-photo" 
                                                    onclick="deletePhoto({{ $doc->id }}, '{{ $doc->foto }}')"
                                                    title="Hapus foto">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Dokumentasi Detail -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-images me-2"></i>Dokumentasi Detail
            </h5>
        </div>
        <div class="card-body">
            @if($dokumentasiByStep->count() > 0)
                @foreach($dokumentasiByStep as $stepName => $docs)
                <div class="mb-4">
                    <h6 class="border-bottom pb-2 fw-semibold">
                        <i class="bi bi-collection me-2"></i>{{ $stepName }}
                    </h6>
                    <div class="row">
                        @foreach($docs as $doc)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="card h-100 position-relative">
                                <img src="{{ asset('storage/' . $doc->foto) }}" 
                                     class="card-img-top previewable-image" 
                                     style="height: 150px; object-fit: cover; cursor: pointer;"
                                     alt="Dokumentasi {{ $stepName }}"
                                     onerror="this.style.display='none'; console.log('Failed to load image:', '{{ asset('storage/' . $doc->foto) }}');">
                                <button type="button" 
                                        class="btn-delete-photo-large" 
                                        onclick="deletePhoto({{ $doc->id }}, '{{ $doc->foto }}')"
                                        title="Hapus foto">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div class="card-body p-3">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($doc->tanggal)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi bi-images display-4 text-muted"></i>
                    <p class="mt-3 mb-1 text-muted">Belum ada dokumentasi untuk part ini</p>
                    <small class="text-muted">Dokumentasi akan muncul setelah upload</small>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
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

<style>
    .previewable-image {
        transition: transform 0.2s ease;
    }
    
    .previewable-image:hover {
        transform: scale(1.05);
    }

    /* Delete button styling */
    .btn-delete-photo {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        border: 2px solid white;
        color: white;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        opacity: 0;
        transform: scale(0.8);
    }

    .btn-delete-photo:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
        opacity: 1;
    }

    .position-relative:hover .btn-delete-photo {
        opacity: 1;
        transform: scale(1);
    }

    .btn-delete-photo-large {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        border: 2px solid white;
        color: white;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        opacity: 0;
        transform: scale(0.8);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .btn-delete-photo-large:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
        opacity: 1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }

    .card:hover .btn-delete-photo-large {
        opacity: 1;
        transform: scale(1);
    }

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

    #imagePreviewModal .modal-img {
        max-height: 80vh;
        object-fit: contain;
        border-radius: 12px;
        margin: auto;
        display: block;
        transition: transform 0.3s ease;
        background-color: transparent;
    }

    #imagePreviewModal .close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        font-size: 1.8rem;
        color: white;
        background: rgba(0, 0, 0, 0.5);
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
        background: rgba(0, 0, 0, 0.7);
    }

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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .progress {
            width: 80px !important;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .table th {
            width: 120px;
        }

        /* Mobile delete button adjustments */
        .btn-delete-photo {
            width: 28px;
            height: 28px;
            font-size: 12px;
            top: -6px;
            right: -6px;
        }

        .btn-delete-photo-large {
            width: 36px;
            height: 36px;
            font-size: 16px;
            top: 6px;
            right: 6px;
        }

        /* Show delete buttons on mobile by default */
        .btn-delete-photo,
        .btn-delete-photo-large {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        const modalImage = document.getElementById('previewImage');

        // Debug: Log image paths
        document.querySelectorAll('.previewable-image').forEach((img, index) => {
            console.log(`Image ${index + 1}:`, img.src);
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

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Function to delete photo
    function deletePhoto(photoId, photoPath) {
        Swal.fire({
            title: 'Hapus Foto?',
            text: 'Apakah Anda yakin ingin menghapus foto ini? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus Foto...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send delete request
                fetch(`/dokumentasi/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
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
                            text: data.message || 'Foto berhasil dihapus',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            // Reload page to update the view
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Gagal menghapus foto');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: error.message || 'Gagal menghapus foto. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                });
            }
        });
    }
</script>
@endsection 