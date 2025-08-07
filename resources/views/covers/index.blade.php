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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">

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
                 <!-- Ganti modal detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detail Dokumentasi</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="coverImage" src="" class="img-fluid rounded mb-3 shadow" alt="Cover">
                        <img id="logoImage" src="" class="img-fluid rounded" width="100" alt="Logo">
                    </div>
                    <div class="col-md-8">
                        <h4 id="coverName" class="font-weight-bold mb-3"></h4>
                        <div class="mb-3">
                            <span class="badge bg-primary mr-2" id="coverKategori"></span>
                            <span class="badge bg-success" id="coverVersi"></span>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted mb-1"><i class="fas fa-user mr-2"></i><span id="coverAuthor"></span></p>
                            <p class="text-muted"><i class="fas fa-edit mr-2"></i><span id="coverEditor"></span></p>
                        </div>
                        <div class="mb-3">
                            <span class="badge" id="coverStatus"></span>
                        </div>
                        <div class="border-top pt-3">
                            <h6 class="font-weight-bold">Konten:</h6>
                            <p id="coverContent" class="text-justify"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Manajemen Cover</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('covers.create')}}" class="btn btn-md btn-success mb-3">
                                <i class="fas fa-plus"></i> Tambah Cover
                            </a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Cover</th>
                                            <th>Cover</th>
                                            <th>Logo</th>
                                            <th>Kategori</th>
                                            <th>Versi</th>
                                            <th>Author</th> 
                                            <th>Edited By</th>
                                            <th>Status</th>
                                            <th>Konten</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($covers as $cover)
                                            <tr>
                                                <td class="text-left align-middle">
                                                    {{ $cover->name }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ asset('storage/' . $cover->image) }}" class="image-popup">
                                                        <img src="{{ asset('storage/' . $cover->image) }}" alt="Image" width="80" class="rounded">
                                                    </a>
                                                </td>                                        
                                                <td class="text-center align-middle">
                                                    <a href="{{ asset('storage/' . $cover->logo) }}" class="image-popup">
                                                    <img src="{{ asset('storage/' . $cover->logo) }}" alt="Logo" width="80" class="rounded">
                                                    </a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($cover->kategori)
                                                        {{ $cover->kategori->name }}
                                                    @else
                                                        <span class="badge badge-warning">Tidak ada kategori</span>
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $cover->versis->first()->versi ?? 'Belum ada versi' }}
                                                </td>                                                
                                                <td class="text-center align-middle">
                                                    {{ $cover->author ?? 'Tidak ada author' }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $cover->edited ?? 'Belum ada editor' }}
                                                </td>                                                                                                
                                                <td class="text-center align-middle">
                                                    <span class="badge {{ $cover->status === 'publish' ? 'bg-success text-white' : 'bg-warning text-white' }}">
                                                        {{ $cover->status === 'publish' ? 'Publish' : 'Draft' }}
                                                    </span>                                                    
                                                </td>
                                                <td class="text-center align-middle" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $cover->content }}
                                                </td>
                                                <td class="text-center align-middle" style="min-width: 200px;">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('covers.destroy', $cover->id) }}" method="POST">
                                                        <button type="button" class="btn btn-sm btn-primary btn-detail" data-id="{{ $cover->id }}" data-toggle="tooltip" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>                                                      
                                                        <a href="{{ route('covers.edit', $cover->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
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
                                                <td colspan="10" class="text-center">
                                                    <div class="alert alert-danger">
                                                        Data Cover belum Tersedia
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
                
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; DOCSManager {{ now()->year }}</span>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>


<!-- Magnific Popup JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

            $('.btn-detail').on('click', function(){
                var coverId = $(this).data('id');
                $.ajax({
                    url: '/covers/' + coverId,
                    method: 'GET',
                    success: function(response){
                        $('#detailModal .modal-body').html(response);
                        $('#detailModal').modal('show');
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function(){
        $('.btn-detail').on('click', function(){
            var coverId = $(this).data('id');
            $.ajax({
                url: '/covers/' + coverId,
                method: 'GET',
                success: function(response){
                    // Update modal dengan data
                    $('#coverName').text(response.name);
                    $('#coverImage').attr('src', 'storage/' + response.image);
                    $('#logoImage').attr('src', 'storage/' + response.logo);
                    $('#coverKategori').text(response.kategori ? response.kategori.name : 'Tanpa Kategori');
                    $('#coverVersi').text(response.versis && response.versis.length > 0 ? response.versis[0].versi : 'Tanpa Versi');
                    $('#coverAuthor').text(response.author || 'Tanpa Author');
                    $('#coverEditor').text(response.edited || 'Belum Diedit');
                    $('#coverContent').text(response.content);
                    
                    // Update status badge
                    var statusBadge = $('#coverStatus');
                    statusBadge.text(response.status === 'publish' ? 'Publish' : 'Draft');
                    statusBadge.removeClass().addClass('badge');
                    statusBadge.addClass(response.status === 'publish' ? 'bg-success' : 'bg-warning');
                    
                    $('#detailModal').modal('show');
                }
            });
        });
        
        // Inisialisasi tooltip
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
        
        // Inisialisasi popup gambar
        $('.image-popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-img-mobile',
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300
            }
        });
    });
    </script>

</body>

</html>