@extends('layouts.sidebar')

@section('content')
<div class="container-fluid col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Dokumentasi Proses Mekanik</h2>

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
                    <th>No IWO</th>
                    <th>Nomor Komponen</th>
                    <th>Part Name</th>
                    <th>Part Number</th>
                    <th>Serial Number</th>
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
                    <td>{{ $part->no_iwo }}</td>
                    <td>{{ $part->no_wbs }}</td>
                    <td>{{ $part->part_name }}</td>
                    <td>{{ $part->part_number }}</td>
                    <td>{{ $part->no_seri }}</td>
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

                        @if ($existingDocs->has($currentStepName))
                        <div clas="mb-2">
                            @foreach ($existingDocs[$currentStepName] as $doc)
                            <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail me-1 mb-1">
                            @endforeach
                        </div>

                        <!-- <div class="alert alert-info">
                            Step saat ini (yang belum ada dokumentasi): {{ $currentStepName }}
                        </div> -->


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
                        @if ($existingDocs->count() > 0)
                        <button class="btn btn-sm btn-secondary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSteps{{ $part->no_iwo }}">
                            Lihat Step Sebelumnya
                        </button>
                        <div class="collapse mt-2" id="collapseSteps{{ $part->no_iwo }}">
                            @foreach ($existingDocs as $step => $docs)

                            @if ($step !== $currentStepName)
                            <div class="mb-2">
                                <strong>{{ $step }}</strong><br>
                                @foreach ($docs as $doc)
                                <img src="{{ asset('storage/' . $doc->foto) }}" width="100" class="img-thumbnail me-1 mb-1">
                                @endforeach
                            </div>
                            @endif
                            @endforeach

                        </div>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection