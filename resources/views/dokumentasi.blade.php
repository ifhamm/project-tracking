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


</style>



@extends('layouts.sidebar')

@section('content')
<div class="container-fluid col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Dokumentasi Proses Mekanik</h2>

    <!-- Filter Form -->
    <div class="row mb-4 g-2">
        <form action="{{ route('proses-mekanik') }}" method="GET" class="row g-2 w-100">
            <div class="col-md-4">
                <input type="text" class="form-control" name="no_wbs" placeholder="Customer"
                    value="{{ request('customer') }}">
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
                        <div class="mb-2">
                            @foreach ($docsForCurrentStep as $doc)
                            <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail me-1 mb-1 previewable-image">
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
</div>

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
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