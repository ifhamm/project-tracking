<style>
    /* Reset and base modal styles */
    .modal {
        z-index: 1050;
    }

    .modal-dialog {
        margin: 1.75rem auto;
        max-width: 600px;
        pointer-events: auto;
    }

    .modal-content {
        background-color: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        position: relative;
    }

    .modal-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border-bottom: 1px solid #dee2e6;
        padding: 1rem 1.5rem;
        position: relative;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0;
        color: white;
    }

    .btn-close {
        filter: invert(1);
        opacity: 0.8;
        background: none;
        border: none;
        font-size: 1.5rem;
        padding: 0;
        margin: 0;
        width: auto;
        height: auto;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 1.5rem;
        background-color: #fff;
        color: #333;
        position: relative;
    }

    .modal-body h6 {
        color: #333;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 1rem 1.5rem;
        position: relative;
    }

    /* Form styling */
    .form-label {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        outline: none;
    }

    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }

    /* Image preview styling */
    .img-thumbnail {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        transition: transform 0.2s ease;
        background-color: #fff;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
    }

    /* Button styling */
    .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #545b62;
        border-color: #545b62;
        transform: translateY(-1px);
    }

    /* Modal backdrop fix */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }

    /* Prevent modal flickering */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translate(0, -50px);
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    /* Ensure modal stability */
    .modal {
        transition: opacity 0.15s linear;
    }

    .modal.fade {
        opacity: 0;
    }

    .modal.show {
        opacity: 1;
    }

    /* Prevent body scroll issues */
    body.modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }

    /* Fix backdrop issues */
    .modal-backdrop {
        opacity: 0;
        transition: opacity 0.15s linear;
    }

    .modal-backdrop.show {
        opacity: 0.5;
    }

    /* Ensure form elements don't cause layout shifts */
    .form-control {
        min-height: 38px;
    }

    .btn {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Prevent image preview layout shifts */
    .d-flex.flex-wrap {
        gap: 0.5rem;
        margin-top: 0.5rem;
        min-height: 20px;
        align-items: flex-start;
    }

    .img-thumbnail {
        flex-shrink: 0;
    }

    /* Table styling */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    /* Form validation styling */
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .form-control.is-valid {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    /* Loading state for upload button */
    .btn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    /* Additional responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }

    /* Responsive fixes */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100vw - 1rem);
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
        }
    }

    /* Image preview container */
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
        min-height: 20px;
    }

    .preview-image {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .file-drop-zone {
        border: 2px dashed #007bff;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-drop-zone:hover {
        border-color: #0056b3;
        background-color: #e3f2fd;
    }

    .file-drop-zone.dragover {
        border-color: #28a745;
        background-color: #d4edda;
    }

    .file-drop-zone i {
        font-size: 2rem;
        color: #007bff;
        margin-bottom: 1rem;
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
            <form action="{{ route('dokumentasi-mekanik') }}" method="GET">
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
                                        onclick="openUploadModal('{{ $part->no_iwo }}', '{{ $part->no_wbs }}', '{{ $part->part_name }}', '{{ $currentStep->step_name }}')">
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
                    <li class="page-item {{ $page == $parts->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
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
    @endif
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    <i class="bi bi-upload me-2"></i>
                    Upload Dokumentasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadForm" action="{{ route('dokumentasi.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-upc-scan me-2"></i>No WBS
                            </label>
                            <input type="text" class="form-control" id="modalNoWbs" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-box me-2"></i>Part Name
                            </label>
                            <input type="text" class="form-control" id="modalPartName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-list-ol me-2"></i>Step
                            </label>
                            <input type="text" class="form-control" id="modalStepName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar me-2"></i>Tanggal
                            </label>
                            <input type="text" class="form-control" id="modalTanggal" readonly>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="foto" class="form-label">
                            <i class="bi bi-images me-2"></i>
                            Pilih Foto Dokumentasi
                        </label>
                        
                        <!-- File Drop Zone -->
                        <div class="file-drop-zone" id="fileDropZone">
                            <i class="bi bi-cloud-upload"></i>
                            <p class="mb-2">Drag & drop foto di sini atau klik untuk memilih file</p>
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 5MB per foto</small>
                        </div>
                        
                        <!-- Hidden file input -->
                        <input type="file" 
                               class="form-control d-none" 
                               id="foto" 
                               name="foto[]" 
                               multiple 
                               required 
                               accept="image/*">
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="image-preview-container mt-3"></div>

                    <!-- Hidden inputs -->
                    <input type="hidden" name="no_iwo" id="modalNoIwo">
                    <input type="hidden" name="no_wbs" id="modalNoWbsHidden">
                    <input type="hidden" name="komponen" id="modalKomponen">
                    <input type="hidden" name="step_name" id="modalStepNameHidden">
                    <input type="hidden" name="tanggal" id="modalTanggalHidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-upload me-1"></i>Upload Dokumentasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Global variables
    let currentPartId = null;
    
    // Initialize modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        initializeModal();
        initializeFileDropZone();
    });

    function initializeModal() {
        const modal = document.getElementById('uploadModal');
        const modalInstance = new bootstrap.Modal(modal);
        
        // Reset form when modal is hidden
        modal.addEventListener('hidden.bs.modal', function() {
            resetUploadForm();
        });
        
        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            handleFormSubmission(e);
        });
    }

    function initializeFileDropZone() {
        const dropZone = document.getElementById('fileDropZone');
        const fileInput = document.getElementById('foto');
        
        // Click to select files
        dropZone.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Drag and drop functionality
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });
        
        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.classList.remove('dragover');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                validateAndProcessFiles(files, fileInput);
            }
        });
        
        // File input change
        fileInput.addEventListener('change', function() {
            validateAndProcessFiles(this.files, this);
        });
    }

    function validateAndProcessFiles(files, fileInput) {
        console.log('validateAndProcessFiles called with:', files.length, 'files');
        
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        const validFiles = [];
        const errors = [];
        let processedCount = 0;
        const totalFiles = files.length;

        // If no files, show error
        if (totalFiles === 0) {
            console.log('No files selected');
            showFileErrors(['Tidak ada file yang dipilih']);
            return;
        }

        // Validate each file
        Array.from(files).forEach((file, index) => {
            console.log('Processing file:', file.name, 'Type:', file.type, 'Size:', file.size);
            
            // Check file type
            if (!allowedTypes.includes(file.type)) {
                console.log('Invalid file type:', file.type);
                errors.push(`File "${file.name}" bukan file gambar yang valid. Hanya JPG, JPEG, dan PNG yang diperbolehkan.`);
                processedCount++;
                if (processedCount === totalFiles) {
                    console.log('All files processed. Valid:', validFiles.length, 'Errors:', errors.length);
                    processValidFiles(validFiles, errors, fileInput);
                }
                return;
            }

            // Check file size
            if (file.size > maxSize) {
                console.log('File too large:', file.size);
                errors.push(`File "${file.name}" terlalu besar (${formatFileSize(file.size)}). Maksimal 5MB per file.`);
                processedCount++;
                if (processedCount === totalFiles) {
                    console.log('All files processed. Valid:', validFiles.length, 'Errors:', errors.length);
                    processValidFiles(validFiles, errors, fileInput);
                }
                return;
            }

            // Check if file is actually an image by reading its header
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const arr = new Uint8Array(e.target.result).subarray(0, 4);
                    let header = '';
                    for (let i = 0; i < arr.length; i++) {
                        header += arr[i].toString(16);
                    }
                    
                    console.log('File header for', file.name, ':', header);
                    
                    // Check for image file signatures
                    const isImage = (
                        header.startsWith('ffd8') || // JPEG
                        header.startsWith('89504e47') || // PNG
                        header.startsWith('47494638') // GIF
                    );
                    
                    if (!isImage) {
                        console.log('Invalid image signature for:', file.name);
                        errors.push(`File "${file.name}" bukan file gambar yang valid. File mungkin rusak atau bukan gambar.`);
                    } else {
                        console.log('Valid image file:', file.name);
                        validFiles.push(file);
                    }
                } catch (error) {
                    console.error('Error validating file:', file.name, error);
                    errors.push(`File "${file.name}" tidak dapat divalidasi. File mungkin rusak.`);
                }
                
                processedCount++;
                console.log('Processed count:', processedCount, 'Total:', totalFiles);
                if (processedCount === totalFiles) {
                    console.log('All files processed. Valid:', validFiles.length, 'Errors:', errors.length);
                    processValidFiles(validFiles, errors, fileInput);
                }
            };
            
            reader.onerror = function() {
                console.error('Error reading file:', file.name);
                errors.push(`Gagal membaca file "${file.name}". File mungkin rusak.`);
                processedCount++;
                if (processedCount === totalFiles) {
                    console.log('All files processed. Valid:', validFiles.length, 'Errors:', errors.length);
                    processValidFiles(validFiles, errors, fileInput);
                }
            };
            
            reader.readAsArrayBuffer(file);
        });
    }

    function processValidFiles(validFiles, errors, fileInput) {
        console.log('processValidFiles called. Valid files:', validFiles.length, 'Errors:', errors.length);
        
        // Show errors if any
        if (errors.length > 0) {
            console.log('Showing errors:', errors);
            showFileErrors(errors);
        }

        // Process valid files
        if (validFiles.length > 0) {
            console.log('Processing valid files:', validFiles.length);
            // Create a new FileList-like object
            const dataTransfer = new DataTransfer();
            validFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
            
            // Show success message
            showFileSuccess(validFiles.length);
            
            // Preview images
            previewImages(fileInput);
        } else {
            console.log('No valid files to process');
            // Clear preview if no valid files
            document.getElementById('imagePreview').innerHTML = '';
            fileInput.value = '';
        }
    }

    function showFileErrors(errors) {
        console.log('showFileErrors called with:', errors);
        
        // Create error alert
        const errorHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error Upload File:</strong>
                <ul class="mb-0 mt-2">
                    ${errors.map(error => `<li>${error}</li>`).join('')}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insert error alert before the modal body
        const modalBody = document.querySelector('#uploadModal .modal-body');
        console.log('Modal body found:', !!modalBody);
        
        if (modalBody) {
            const existingAlert = modalBody.querySelector('.alert-danger');
            if (existingAlert) {
                console.log('Removing existing error alert');
                existingAlert.remove();
            }
            
            console.log('Inserting error alert');
            modalBody.insertAdjacentHTML('afterbegin', errorHtml);
            
            // Auto-remove after 10 seconds
            setTimeout(() => {
                const alert = modalBody.querySelector('.alert-danger');
                if (alert) {
                    console.log('Auto-removing error alert');
                    alert.remove();
                }
            }, 10000);
        } else {
            console.error('Modal body not found!');
        }
    }

    function showFileSuccess(fileCount) {
        console.log('showFileSuccess called with file count:', fileCount);
        
        // Create success alert
        const successHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Berhasil!</strong> ${fileCount} file gambar valid telah dipilih.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insert success alert before the modal body
        const modalBody = document.querySelector('#uploadModal .modal-body');
        console.log('Modal body found for success:', !!modalBody);
        
        if (modalBody) {
            const existingAlert = modalBody.querySelector('.alert-success');
            if (existingAlert) {
                console.log('Removing existing success alert');
                existingAlert.remove();
            }
            
            console.log('Inserting success alert');
            modalBody.insertAdjacentHTML('afterbegin', successHtml);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                const alert = modalBody.querySelector('.alert-success');
                if (alert) {
                    console.log('Auto-removing success alert');
                    alert.remove();
                }
            }, 5000);
        } else {
            console.error('Modal body not found for success alert!');
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function previewImages(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            // Add file count info
            const fileCount = input.files.length;
            const countInfo = document.createElement('div');
            countInfo.className = 'mb-2 text-muted';
            countInfo.innerHTML = `<small><i class="bi bi-images me-1"></i>${fileCount} file dipilih</small>`;
            preview.appendChild(countInfo);
            
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'position-relative d-inline-block me-2 mb-2';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    img.alt = `Preview ${index + 1}`;
                    img.title = `${file.name} (${formatFileSize(file.size)})`;
                    
                    // Add file info overlay
                    const overlay = document.createElement('div');
                    overlay.className = 'position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 text-white d-flex align-items-center justify-content-center opacity-0';
                    overlay.style.transition = 'opacity 0.3s ease';
                    overlay.innerHTML = `
                        <div class="text-center">
                            <small>${file.name}</small><br>
                            <small>${formatFileSize(file.size)}</small>
                        </div>
                    `;
                    
                    imgContainer.appendChild(img);
                    imgContainer.appendChild(overlay);
                    
                    // Show overlay on hover
                    imgContainer.addEventListener('mouseenter', function() {
                        overlay.classList.remove('opacity-0');
                    });
                    
                    imgContainer.addEventListener('mouseleave', function() {
                        overlay.classList.add('opacity-0');
                    });
                    
                    preview.appendChild(imgContainer);
                };
                
                reader.onerror = function() {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'alert alert-warning alert-sm mb-2';
                    errorDiv.innerHTML = `
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Gagal memuat preview untuk file "${file.name}"
                    `;
                    preview.appendChild(errorDiv);
                };
                
                reader.readAsDataURL(file);
            });
        }
    }

    function openUploadModal(partId, noWbs, partName, stepName) {
        currentPartId = partId;
        
        // Set modal values
        document.getElementById('modalNoWbs').value = noWbs;
        document.getElementById('modalPartName').value = partName;
        document.getElementById('modalStepName').value = stepName;
        document.getElementById('modalTanggal').value = new Date().toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        
        // Set hidden values
        document.getElementById('modalNoIwo').value = partId;
        document.getElementById('modalNoWbsHidden').value = noWbs;
        document.getElementById('modalKomponen').value = partName;
        document.getElementById('modalStepNameHidden').value = stepName;
        document.getElementById('modalTanggalHidden').value = new Date().toISOString().split('T')[0];
        
        // Update modal title
        document.getElementById('uploadModalLabel').innerHTML = 
            '<i class="bi bi-upload me-2"></i>Upload Dokumentasi - ' + noWbs;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }

    function handleFormSubmission(e) {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Uploading...';
        
        // Re-enable after a delay (in case of validation errors)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }, 5000);
    }

    function resetUploadForm() {
        // Reset form
        document.getElementById('uploadForm').reset();
        
        // Clear preview
        document.getElementById('imagePreview').innerHTML = '';
        
        // Reset drop zone
        document.getElementById('fileDropZone').classList.remove('dragover');
        
        // Clear any alerts
        const modalBody = document.querySelector('#uploadModal .modal-body');
        const alerts = modalBody.querySelectorAll('.alert');
        alerts.forEach(alert => alert.remove());
        
        // Reset current part ID
        currentPartId = null;
    }
</script>
@endsection