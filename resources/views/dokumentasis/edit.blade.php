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
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

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
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm rounded">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Form Edit Dokumentasi</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('dokumentasis.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
            
                                        <!-- Cover Selection -->
                                        <div class="form-group">
                                            <label>Cover:</label>
                                            <select name="cover_id" class="form-control" required>
                                                <option value="" disabled>Pilih Cover</option>
                                                @foreach ($covers as $cover)
                                                    <option value="{{ $cover->id }}" {{ $cover->id == $dokumentasi->cover_id ? 'selected' : '' }}>{{ $cover->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
            
                                        <!-- Judul Input -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Judul</label>
                                            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $dokumentasi->judul) }}" placeholder="Masukkan Judul">
                                            @error('judul')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
            
                                        <!-- Deskripsi Status Radio Buttons -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Status Deskripsi</label>
                                            <div>
                                                <label class="mr-3">
                                                    <input type="radio" name="deskripsi_status" value="aktif" {{ empty($dokumentasi->deskripsi) ? 'checked' : '' }}> Aktif (Tidak bisa mengisi deskripsi)
                                                </label>
                                                <label>
                                                    <input type="radio" name="deskripsi_status" value="non-aktif" {{ !empty($dokumentasi->deskripsi) ? 'checked' : '' }}> Non-Aktif (Bisa mengisi deskripsi)
                                                </label>
                                            </div>
                                        </div>
            
                                        <!-- Deskripsi Textarea -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Deskripsi</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="5" placeholder="Masukkan Deskripsi" {{ empty($dokumentasi->deskripsi) ? 'disabled' : '' }}>{{ old('deskripsi', $dokumentasi->deskripsi) }}</textarea>
                                            @error('deskripsi')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
            
                                        <!-- Order Input -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Urutan (Order)</label>
                                            <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order', $dokumentasi->order) }}" placeholder="Masukkan urutan">
                                            @error('order')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
            
                                        <!-- Status Selection -->
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="draft" {{ $dokumentasi->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="publish" {{ $dokumentasi->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                            </select>
                                        </div>
            
                                        <!-- Buttons -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-primary">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                            <button type="reset" class="btn btn-md btn-warning">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
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
                        <span>Copyright &copy; Your Website 2020</span>
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
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        tinymce.init({
    selector: '#deskripsi', 
    height: 500, 
    menubar: true, 
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount',
        'emoticons', 'codesample', 'media', 'hr',
        'colorpicker', 'pagebreak', 'directionality',
        'fullpage', 'table', 'image' // Tambahkan plugin image
    ],
    toolbar: 'undo redo | formatselect | bold italic underline strikethrough | \
              alignleft aligncenter alignright alignjustify | \
              bullist numlist outdent indent | link image media | \
              forecolor backcolor emoticons codesample | \
              table tabledelete | tableprops tablerowprops tablecellprops | \
              tableinsertrowbefore tableinsertrowafter tabledeleterow | \
              tableinsertcolbefore tableinsertcolafter tabledeletecol | \
              pagebreak hr | ltr rtl | fullpage | help',
    image_advtab: true, // Aktifkan tab lanjutan untuk mengunggah gambar
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',

    // Upload handler untuk gambar
    images_upload_handler: function (blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            fetch("{{ route('dokumentasi.uploadImage') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    resolve(data.url); // Jika berhasil, kembalikan URL gambar
                } else {
                    reject('Gagal mengupload gambar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                reject('Error: ' + error.message);
            });
        });
    }
});

    
        function updateDeskripsiStatus() {
    let editor = tinymce.get('deskripsi');

    if ($('input[name="deskripsi_status"]:checked').val() === 'aktif') {
        // Ubah ke mode readonly
        editor.mode.set('readonly');

        // Tambahkan class CSS agar kursor hilang & warna abu-abu
        $(editor.getBody()).addClass('readonly-editor');
    } else {
        // Ubah ke mode edit (design)
        editor.mode.set('design');

        // Hapus class readonly agar bisa diketik kembali
        $(editor.getBody()).removeClass('readonly-editor');
    }
}

$(document).ready(function() {
    updateDeskripsiStatus(); // Panggil saat halaman pertama kali dimuat
    $('input[name="deskripsi_status"]').change(updateDeskripsiStatus); // Event listener
});
    </script>
    
</body>

</html>