<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/admin.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ Storage::url('images/logo.png') }}" alt="Logo" width="40">

                </div>
                <div class="sidebar-brand-text mx-2">Manual Docs</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tabel Dokumentasi
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Manajemen Cover</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Cover</h6>
                        <a class="collapse-item" href="{{ route('covers.index') }}">Cover</a>
                        <a class="collapse-item" href="{{ route('kategoris.index') }}">Kategori</a>
                        <a class="collapse-item" href="{{ route('versis.index') }}">Versi</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manajemen Dokumentasi</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Dokumentasi</h6>
                        <a class="collapse-item" href="{{ route('dokumentasis.index') }}">Dokumentasi</a>
                        <a class="collapse-item" href="{{ route('subjudul.index') }}">List</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Users
            </div>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admins.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Admin</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-light topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form action="{{ route('covers.index') }}" method="GET"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control bg-white border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">
                    <div class="card shadow mb-4">
                        <!-- Header -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Manajemen List</h6>
                        </div>
                
                        <!-- Filter Section -->
                        <div class="card-body">
                            <form method="GET" action="{{ route('subjudul.index') }}" id="filterForm">
                                <div class="form-row">
                                    <!-- Filter Cover -->
                                    <div class="form-group col-md-4">
                                        <label for="cover_id">Pilih Cover:</label>
                                        <select name="cover_id" id="cover_id" class="form-control select2" onchange="updateDokumentasiFilter()">
                                            <option value="">-- Semua Cover --</option>
                                            @foreach ($covers as $cover)
                                                <option value="{{ $cover->id }}" {{ $coverId == $cover->id ? 'selected' : '' }}>
                                                    {{ $cover->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    <!-- Filter Dokumentasi -->
                                    <div class="form-group col-md-4">
                                        <label for="dokumentasi_id">Pilih Dokumentasi:</label>
                                        <select name="dokumentasi_id" id="dokumentasi_id" class="form-control select2" {{ !$coverId ? 'disabled' : '' }}>
                                            <option value="">-- Semua Dokumentasi --</option>
                                            @if ($coverId)
                                                @foreach ($dokumentasis as $dokumentasi)
                                                    <option value="{{ $dokumentasi->id }}" {{ $dokumentasiId == $dokumentasi->id ? 'selected' : '' }}>
                                                        {{ $dokumentasi->judul }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                
                                    <!-- Tombol -->
                                    <div class="form-group col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                        <a href="{{ route('subjudul.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                
                            <!-- Tombol Tambah -->
                            <div class="mt-3">
                                <a href="{{ route('subjudul.create') }}" class="btn btn-success mb-3">
                                    <i class="fas fa-plus"></i> Tambah Subjudul Dokumentasi
                                </a>
                            </div>
                
                            <!-- Tabel Data -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Subjudul</th>
                                            <th>Status</th>
                                            <th>Isi Halaman</th>
                                            <th style="min-width: 200px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($doksubs as $doksub)
                                            <tr>
                                                <td>
                                                    {{ $doksub->subjudul }}
                                                    @if ($doksub->is_duplicate)
                                                        <span class="badge bg-secondary">Copy</span>
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge {{ $doksub->status === 'publish' ? 'bg-success text-white' : 'bg-warning text-white' }}">
                                                        {{ ucfirst($doksub->status) }}
                                                    </span>
                                                </td>
                                                <td>{!! $doksub->deskripsi !!}</td>
                                                <td class="text-center align-middle">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin?');" action="{{ route('subjudul.destroy', $doksub->id) }}" method="POST" class="d-inline">
                                                        <a href="{{ route('subjudul.edit', $doksub->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <div class="alert alert-danger mb-0">
                                                        Data Subjudul belum Tersedia
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
                            <!-- Footer -->
                            <footer class="sticky-footer bg-white mt-4">
                                <div class="container my-auto">
                                    <div class="copyright text-center my-auto">
                                        <span>&copy; Your Website 2020</span>
                                    </div>
                                </div>
                            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Cari Judul Dokumentasi...",
                allowClear: true
            });
        });
    </script>

<script>
    function updateDokumentasiFilter() {
    const coverId = document.getElementById('cover_id').value;
    const dokumentasiSelect = document.getElementById('dokumentasi_id');

    if (coverId) {
        // Enable filter Dokumentasi
        dokumentasiSelect.disabled = false;

        // Ambil dokumentasi berdasarkan cover_id dan yang deskripsinya null/kosong
        fetch(`/get-dokumentasis?cover_id=${coverId}`)
            .then(response => response.json())
            .then(data => {
                // Kosongkan opsi sebelumnya
                dokumentasiSelect.innerHTML = '<option value="">-- Semua Dokumentasi --</option>';

                // Tambahkan opsi baru
                data.forEach(dokumentasi => {
                    const option = document.createElement('option');
                    option.value = dokumentasi.id;
                    option.text = dokumentasi.judul;
                    dokumentasiSelect.appendChild(option);
                });
            });
    } else {
        // Disable filter Dokumentasi
        dokumentasiSelect.disabled = true;
        dokumentasiSelect.innerHTML = '<option value="">-- Semua Dokumentasi --</option>';
    }
}
</script>

</body>

</html>