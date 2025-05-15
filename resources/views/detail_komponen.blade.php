<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking - Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .sidebar {
            background-color: #0c2340;
            color: white;
            min-height: 100vh;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
            transition: all 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1a3c61;
        }

        .sidebar-icon {
            margin-right: 10px;
        }

        .component-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .detail-row {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 500;
        }

        .detail-value {
            font-weight: 400;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 10px;
        }

        .step-completed {
            background-color: #10b981;
        }

        .step-in-progress {
            background-color: #3b82f6;
        }

        .step-not-started {
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
        }

        .step-line {
            width: 2px;
            background-color: #d1d5db;
            height: 40px;
            margin-left: 14px;
        }

        .step-item {
            margin-bottom: 0;
        }

        .table-step {
            margin-left: 10px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-in-progress {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-not-started {
            background-color: #e2e3e5;
            color: #41464b;
        }

        .action-btn {
            min-width: 120px;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }

            .component-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <!-- Mobile Nav Toggle Button -->
            <div class="d-lg-none position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                <button id="sidebarToggle" class="btn btn-primary">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <!-- Overlay for sidebar on mobile -->
            <div class="overlay" id="overlay"></div>

            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-2 px-0 sidebar" id="sidebar">
                        <div class="d-flex flex-column">
                            <div class="p-3">
                                <h5 class="fw-bold d-flex justify-content-between align-items-center">
                                    AIRCRAFT COMPONENT
                                    <button class="btn-close d-lg-none text-white" id="sidebarClose"></button>
                                </h5>
                            </div>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="bi bi-house me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="komponen">
                                        <i class="bi bi-boxes me-2"></i> Komponen
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="proses-mekanik">
                                        <i class="bi bi-gear me-2"></i> Proses Mekanik
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="bi bi-file-text me-2"></i> Dokumentasi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="bi bi-truck me-2"></i> Delivery
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-9 col-lg-10 p-4">
                        <div class="component-card">
                            <div class="d-md-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-3 mb-md-0">COMP-001</h2>
                                <div class="d-flex gap-2">
                                    <div class="input-group me-2" style="max-width: 250px;">
                                        <span class="input-group-text">Status:</span>
                                        <select class="form-select">
                                            <option selected>All</option>
                                            <option>Completed</option>
                                            <option>In Progress</option>
                                            <option>Not Started</option>
                                        </select>
                                    </div>
                                    <div class="input-group" style="max-width: 250px;">
                                        <span class="input-group-text">Date:</span>
                                        <input type="text" class="form-control" placeholder="April 1"
                                            value="April 1">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-calendar"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <h4 class="mb-3">Component Details</h4>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Component:</div>
                                        <div class="col-sm-8 detail-value">Hydraulic pump</div>
                                    </div>
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Date Received:</div>
                                        <div class="col-sm-8 detail-value">April 1, 2025</div>
                                    </div>
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Customer / Airline:</div>
                                        <div class="col-sm-8 detail-value">Airline X</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Priority:</div>
                                        <div class="col-sm-8 detail-value">High</div>
                                    </div>
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Issue:</div>
                                        <div class="col-sm-8 detail-value">Low pressure</div>
                                    </div>
                                    <div class="row detail-row">
                                        <div class="col-sm-4 detail-label">Description:</div>
                                        <div class="col-sm-8 detail-value">Hydraulic pump with pressure loss issues
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary mt-3" data-bs-toggle="modal"
                                data-bs-target="#addBDPModal">
                                Add Break Down Part
                            </button>

                            <!-- Modal for Adding BDP -->
                            <div class="modal fade" id="addBDPModal" tabindex="-1" aria-labelledby="addBDPModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('breakdown.parts.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBDPModalLabel">Add Break Down Part</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body row g-3">
                                                <input type="hidden" name="No_IWO" value="COMP-001">
                                                <div class="col-md-6">
                                                    <label class="form-label">BDP Name</label>
                                                    <input type="text" class="form-control" name="BDP_Name"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">BDP Number Eqv</label>
                                                    <input type="text" class="form-control" name="BDP_Number_Eqv">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" class="form-control" name="Quantity">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Unit</label>
                                                    <input type="text" class="form-control" name="Unit">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Defect</label>
                                                    <input type="text" class="form-control" name="Defect">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">OP Number</label>
                                                    <input type="text" class="form-control" name="OP_Number">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">OP Date</label>
                                                    <input type="date" class="form-control" name="OP_Date">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">MT Number</label>
                                                    <input type="text" class="form-control" name="MT_Number">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">MT QTY</label>
                                                    <input type="number" class="form-control" name="MT_QTY">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">MT Date</label>
                                                    <input type="date" class="form-control" name="MT_Date">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save BDP</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Table BDP -->
                            <div class="container mt-4">
                                <h4>Break Down Part List</h4>
                                <table class="table table-striped mt-3">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>BDP Name</th>
                                            <th>BDP Number Eqv</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>OP Number</th>
                                            <th>OP Date</th>
                                            <th>Defect</th>
                                            <th>MT Number</th>
                                            <th>MT Qty</th>
                                            <th>MT Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($breakdownParts as $part)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $part->bdp_name }}</td>
                                                <td>{{ $part->bdp_nunber_eqv }}</td>
                                                <td>{{ $part->quantity }}</td>
                                                <td>{{ $part->unit }}</td>
                                                <td>{{ $part->op_number }}</td>
                                                <td>{{ $part->op_date }}</td>
                                                <td>{{ $part->defect }}</td>
                                                <td>{{ $part->mt_number }}</td>
                                                <td>{{ $part->mt_quantity }}</td>
                                                <td>{{ $part->mt_date }}</td>
                                                <td>
                                                    <a href="{{ route('breakdown.parts.edit', $part->bdp_number) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    <form
                                                        action="{{ route('breakdown.parts.destroy', $part->bdp_number) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody> --}}
                                </table>
                            </div>

                            <hr class="my-4">

                            <h4 class="mb-4">Mechanical Process</h4>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Step</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 15%">Start Date</th>
                                            <th style="width: 15%">Completion Date</th>
                                            <th style="width: 25%">Job and Remark</th>
                                            <th style="width: 5%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Incoming -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <span class="ms-2">Incoming</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-completed">Completed</span>
                                            </td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle">Low voltage</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Pre Test -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <span class="ms-2">Pre Test</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-completed">Completed</span>
                                            </td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle">Replace seal</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Disassembly -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <span class="ms-2">Disassembly</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-completed">Completed</span>
                                            </td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle">Apr 1, 2025</td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Check & Stripping -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <span class="ms-2">Check & Stripping</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-completed">Completed</span>
                                            </td>
                                            <td class="align-middle">April, 2025</td>
                                            <td class="align-middle">April, 2025</td>
                                            <td class="align-middle">Replace seal</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Cleaning -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-completed">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                    <span class="ms-2">Cleaning</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-in-progress">In Progress</span>
                                            </td>
                                            <td class="align-middle">April 7, 2025</td>
                                            <td class="align-middle">April 6, 2025</td>
                                            <td class="align-middle">Replace bearing</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Assembly & Repair -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-in-progress">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </div>
                                                    <span class="ms-2">Assembly & Repair</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-not-started">Not Started</span>
                                            </td>
                                            <td class="align-middle">April 7, 2025</td>
                                            <td class="align-middle">April 7, 2025</td>
                                            <td class="align-middle"></td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Post Test -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-not-started"></div>
                                                    <span class="ms-2">Post Test</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-not-started">Not Started</span>
                                            </td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="connector-row">
                                            <td colspan="6">
                                                <div class="step-line"></div>
                                            </td>
                                        </tr>

                                        <!-- Final Inspection -->
                                        <tr class="step-row">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="step-circle step-not-started"></div>
                                                    <span class="ms-2">Final Inspection</span>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="status-badge status-not-started">Not Started</span>
                                            </td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">—</td>
                                            <td class="align-middle">
                                                <button class="btn btn-sm btn-outline-danger delete-step"
                                                    title="Hapus langkah">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                data-bs-target="#addStepModal">
                                <i class="fas fa-plus me-2"></i> Add Step
                            </button>
                            <button class="btn btn-outline-success action-btn" data-bs-toggle="modal"
                                data-bs-target="#updateStatusModal">
                                <i class="fas fa-check-circle me-2"></i> Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Step Modal -->
        <div class="modal fade" id="addStepModal" tabindex="-1" aria-labelledby="addStepModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStepModalLabel">Add New Step</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="selectStep" class="form-label">Select Step</label>
                                <select class="form-select" id="selectStep">
                                    <option value="">Choose a step...</option>
                                    <option value="5">Cleaning</option>
                                    <option value="6">Assembly & Repair</option>
                                    <option value="7">Post Test</option>
                                    <option value="8">Final Inspection</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="mb-3">
                                <label for="estimatedCompletionDate" class="form-label">Estimated Completion
                                    Date</label>
                                <input type="date" class="form-control" id="estimatedCompletionDate">
                            </div>
                            <div class="mb-3">
                                <label for="jobRemark" class="form-label">Job and Remark</label>
                                <textarea class="form-control" id="jobRemark" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save Step</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status Modal -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Update Step Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="selectStep" class="form-label">Select Step</label>
                                <select class="form-select" id="selectStep">
                                    <option value="">Choose a step...</option>
                                    <option value="5">Cleaning</option>
                                    <option value="6">Assembly & Repair</option>
                                    <option value="7">Post Test</option>
                                    <option value="8">Final Inspection</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stepStatus" class="form-label">Status</label>
                                <select class="form-select" id="stepStatus">
                                    <option value="not_started">Not Started</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="completionDate" class="form-label">Completion Date</label>
                                <input type="date" class="form-control" id="completionDate">
                            </div>
                            <div class="mb-3">
                                <label for="updateJobRemark" class="form-label">Update Job and Remark</label>
                                <textarea class="form-control" id="updateJobRemark" rows="3"></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="notifyTeam">
                                <label class="form-check-label" for="notifyTeam">Notify team about this update</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Update Status</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.table-responsive table');

        // event delegation: dengarkan klik pada tombol delete-step
        table.addEventListener('click', function(e) {
            const btn = e.target.closest('.delete-step');
            if (!btn) return;

            // cari baris langkah dan baris connector yang mengikutinya
            const stepRow = btn.closest('tr.step-row');
            const nextRow = stepRow.nextElementSibling;

            // konfirmasi (opsional)
            if (!confirm('Yakin ingin menghapus langkah ini?')) return;

            // hapus kedua baris
            stepRow.remove();
            if (nextRow && nextRow.classList.contains('connector-row')) {
                nextRow.remove();
            }
        });
    });
</script>
