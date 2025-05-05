<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aircraft Component Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background-color: #0f2a4a;
            color: white;
            min-height: 100vh;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: white;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link:focus {
            background-color: #1a3a5f;
        }

        .sidebar .nav-link.active {
            background-color: #1a3a5f;
        }


        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .in-progress {
            background-color: #e0f7ee;
            color: #0f5132;
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

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }

            .action-buttons {
                display: flex;
                flex-direction: column;
            }

            .action-buttons button {
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
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
                            <a class="nav-link" href="/">
                                <i class="bi bi-house me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-boxes me-2"></i> Komponen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="proses-mekanik">
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
                <h2 class="mb-4">Proses Mekanik</h2>

                <!-- Filter Form -->
                <div class="row mb-4 g-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Nomor Komponen">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Teknisi">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Step Saat Ini">
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>

                <!-- Main Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor Komponen</th>
                                <th>Step Saat Ini</th>
                                <th>Status</th>
                                <th>Teknisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>COMP-001</td>
                                <td>Assembly & Repair</td>
                                <td><span class="status-badge in-progress">In Progress</span></td>
                                <td>Budi</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-komponen="COMP-001">Edit</button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#viewModal" data-komponen="COMP-001"><i
                                                            class="fas fa-eye me-2"></i> View</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#createModal"><i class="fas fa-plus me-2"></i>
                                                        Create</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal" data-komponen="COMP-001"><i
                                                            class="fas fa-edit me-2"></i> Update</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-komponen="COMP-001"><i class="fas fa-trash me-2"></i>
                                                        Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>COMP-002</td>
                                <td>Cleaning</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td>Rina</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-komponen="COMP-002">Edit</button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#viewModal" data-komponen="COMP-002"><i
                                                            class="fas fa-eye me-2"></i> View</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#createModal"><i class="fas fa-plus me-2"></i>
                                                        Create</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal" data-komponen="COMP-002"><i
                                                            class="fas fa-edit me-2"></i> Update</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-komponen="COMP-002"><i class="fas fa-trash me-2"></i>
                                                        Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>COMP-003</td>
                                <td>Brake Actuator</td>
                                <td><span class="status-badge not-started">Not Started</span></td>
                                <td>—</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-komponen="COMP-003">Edit</button>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#viewModal" data-komponen="COMP-003"><i
                                                            class="fas fa-eye me-2"></i> View</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#createModal"><i class="fas fa-plus me-2"></i>
                                                        Create</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal" data-komponen="COMP-003"><i
                                                            class="fas fa-edit me-2"></i> Update</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                        data-komponen="COMP-003"><i class="fas fa-trash me-2"></i>
                                                        Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Secondary Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Komponen</th>
                                <th>Step Saat Ini</th>
                                <th>Teknisi</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>COMP-001</td>
                                <td>Assembly & Repair</td>
                                <td>Budi</td>
                                <td>07/04/2025</td>
                            </tr>
                            <tr>
                                <td>COMP-002</td>
                                <td>Cleaning</td>
                                <td>Rina</td>
                                <td>03/07/2025</td>
                            </tr>
                            <tr>
                                <td>COMP-003</td>
                                <td>Brake Actuator</td>
                                <td>—</td>
                                <td>—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                        <input type="hidden" id="komponenId" name="komponenId">
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
                            <label class="form-check-label" for="markComplete">Tandai sebagai Selesai</label>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                            <textarea class="form-control" id="keterangan" rows="3"></textarea>
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
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8" id="viewStatus"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Teknisi:</div>
                        <div class="col-md-8" id="viewTeknisi"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Terakhir Update:</div>
                        <div class="col-md-8" id="viewUpdate"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keterangan:</div>
                        <div class="col-md-8" id="viewKeterangan"></div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data komponen untuk simulasi
        const komponenData = {
            'COMP-001': {
                step: 'Assembly & Repair',
                status: 'In Progress',
                teknisi: 'Budi',
                lastUpdate: '07/04/2025',
                keterangan: 'Sedang dalam proses perbaikan bagian actuator'
            },
            'COMP-002': {
                step: 'Cleaning',
                status: 'Completed',
                teknisi: 'Rina',
                lastUpdate: '03/07/2025',
                keterangan: 'Pembersihan selesai, siap untuk inspeksi'
            },
            'COMP-003': {
                step: 'Brake Actuator',
                status: 'Not Started',
                teknisi: '—',
                lastUpdate: '—',
                keterangan: 'Menunggu jadwal pemeriksaan'
            }
        };

        // Edit Modal
        document.getElementById('editModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const komponenId = button.getAttribute('data-komponen');
            const komponenInfo = komponenData[komponenId];

            document.getElementById('komponenId').value = komponenId;
            document.getElementById('komponenInfo').value = komponenId;
            document.getElementById('stepInfo').value = komponenInfo.step;

            // Reset checkbox
            document.getElementById('markComplete').checked = komponenInfo.status === 'Completed';
            document.getElementById('keterangan').value = komponenInfo.keterangan || '';
        });

        // Save status changes
        document.getElementById('saveStatus').addEventListener('click', function() {
            const komponenId = document.getElementById('komponenId').value;
            const isComplete = document.getElementById('markComplete').checked;
            const keterangan = document.getElementById('keterangan').value;

            // Simulasi update data
            komponenData[komponenId].status = isComplete ? 'Completed' : 'In Progress';
            komponenData[komponenId].keterangan = keterangan;
            komponenData[komponenId].lastUpdate = new Date().toLocaleDateString('id-ID');

            // Close modal and show alert
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            editModal.hide();

            alert(`Status komponen ${komponenId} telah diperbarui!`);

            // In a real app, you would reload the data or update the UI
            // For demo purposes, we'll just show an alert
        });

        // View Modal
        document.getElementById('viewModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const komponenId = button.getAttribute('data-komponen');
            const komponenInfo = komponenData[komponenId];

            document.getElementById('viewKomponen').textContent = komponenId;
            document.getElementById('viewStep').textContent = komponenInfo.step;
            document.getElementById('viewStatus').textContent = komponenInfo.status;
            document.getElementById('viewTeknisi').textContent = komponenInfo.teknisi;
            document.getElementById('viewUpdate').textContent = komponenInfo.lastUpdate;
            document.getElementById('viewKeterangan').textContent = komponenInfo.keterangan || '—';
        });

        // Create New Component
        document.getElementById('saveNew').addEventListener('click', function() {
            const newKomponenId = document.getElementById('newKomponenId').value;
            const newStep = document.getElementById('newStep').value;
            const newStatus = document.getElementById('newStatus').value;
            const newTeknisi = document.getElementById('newTeknisi').value;
            const newKeterangan = document.getElementById('newKeterangan').value;

            if (!newKomponenId || !newStep || !newStatus) {
                alert('Mohon lengkapi data wajib!');
                return;
            }

            // Simulate adding new data
            komponenData[newKomponenId] = {
                step: newStep,
                status: newStatus,
                teknisi: newTeknisi || '—',
                lastUpdate: new Date().toLocaleDateString('id-ID'),
                keterangan: newKeterangan
            };

            // Close modal and show alert
            const createModal = bootstrap.Modal.getInstance(document.getElementById('createModal'));
            createModal.hide();

            alert(`Komponen ${newKomponenId} telah ditambahkan!`);

            // Reset form
            document.getElementById('createForm').reset();
        });

        // Update Modal
        document.getElementById('updateModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const komponenId = button.getAttribute('data-komponen');
            const komponenInfo = komponenData[komponenId];

            document.getElementById('updateKomponenId').value = komponenId;
            document.getElementById('updateKomponenNo').value = komponenId;
            document.getElementById('updateStep').value = komponenInfo.step;

            // Set the select value
            const statusSelect = document.getElementById('updateStatus');
            for (let i = 0; i < statusSelect.options.length; i++) {
                if (statusSelect.options[i].value === komponenInfo.status) {
                    statusSelect.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('updateTeknisi').value = komponenInfo.teknisi !== '—' ? komponenInfo.teknisi :
                '';
            document.getElementById('updateKeterangan').value = komponenInfo.keterangan || '';
        });

        // Save Update
        document.getElementById('saveUpdate').addEventListener('click', function() {
            const komponenId = document.getElementById('updateKomponenId').value;
            const step = document.getElementById('updateStep').value;
            const status = document.getElementById('updateStatus').value;
            const teknisi = document.getElementById('updateTeknisi').value;
            const keterangan = document.getElementById('updateKeterangan').value;

            if (!step || !status) {
                alert('Mohon lengkapi data wajib!');
                return;
            }

            // Update data
            komponenData[komponenId] = {
                step: step,
                status: status,
                teknisi: teknisi || '—',
                lastUpdate: new Date().toLocaleDateString('id-ID'),
                keterangan: keterangan
            };

            // Close modal and show alert
            const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
            updateModal.hide();

            alert(`Komponen ${komponenId} telah diperbarui!`);
        });

        // Delete Modal
        document.getElementById('deleteModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const komponenId = button.getAttribute('data-komponen');

            document.getElementById('deleteKomponenNo').textContent = komponenId;
        });

        // Confirm Delete
        document.getElementById('confirmDelete').addEventListener('click', function() {
            const komponenId = document.getElementById('deleteKomponenNo').textContent;

            // Delete data
            delete komponenData[komponenId];

            // Close modal and show alert
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();

            alert(`Komponen ${komponenId} telah dihapus!`);
        });
    </script>
</body>

</html>
