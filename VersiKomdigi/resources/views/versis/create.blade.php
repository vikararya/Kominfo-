<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Versi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body style="background: lightgray">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <!-- Tombol untuk Berpindah Antara Cover dan Dokumentasi -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                    <div class="d-flex gap-4">
                        <a href="{{ route('versis.create', ['type' => 'covers']) }}" 
                            class="btn btn-link text-decoration-none d-flex align-items-center p-0 
                            {{ $type === 'covers' ? 'text-primary' : 'text-secondary' }}">
                            <i class="fas fa-file-alt me-2"></i>
                            <span>Cover</span>
                        </a>
                        <a href="{{ route('versis.create', ['type' => 'dokumentasis']) }}" 
                            class="btn btn-link text-decoration-none d-flex align-items-center p-0 
                            {{ $type === 'dokumentasis' ? 'text-primary' : 'text-secondary' }}">
                            <i class="fas fa-sliders-h me-2"></i>
                            <span>Dokumentasi</span>
                        </a>
                    </div>
                    <h1 class="h5 mb-0">Tambah {{ $type === 'covers' ? 'Cover' : 'Dokumentasi' }}</h1>
                </div>
                

                <!-- Form -->
                <form action="{{ route('versis.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <!-- Jika Cover -->
                    @if ($type === 'covers')
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Pilih Cover</label>
                            <select name="cover_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih Cover</option>
                                @foreach ($covers as $cover)
                                    <option value="{{ $cover->id }}">{{ $cover->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Versi</label>
                            <input type="text" class="form-control @error('versi') is-invalid @enderror"
                                name="versi" value="{{ old('versi') }}" placeholder="Masukkan versi (contoh: 2.0.0)" required>
                                @error('versi')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror                            
                        </div>
                    @endif

                    <!-- Jika Dokumentasi -->
                    @if ($type === 'dokumentasis')
                        <div class="form-group mb-3">
                            <select name="dokumentasi_id" id="dokumentasi_id" class="form-control select2" required>
                                <option value="" disabled selected>Pilih Dokumentasi</option>
                                @foreach ($dokumentasis as $dokumentasi)
                                    <option value="{{ $dokumentasi->id }}" data-covers='@json($dokumentasi->cover ? [$dokumentasi->cover->id => $dokumentasi->cover->name] : [])'>
                                        {{ $dokumentasi->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dropdown Cover -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Pilih Cover</label>
                            <select name="cover_id" id="cover_id" class="form-control select2" disabled required>
                                <option value="" disabled selected>Pilih Cover</option>
                            </select>
                        </div>
<!-- Dropdown Versi Cover -->
<div class="form-group mb-3">
    <label class="font-weight-bold">Pilih Versi</label>
    <select name="versi_cover_id" id="versi_cover_id" class="form-control" disabled required>
        <option value="" disabled selected>Pilih Versi</option>
    </select>
</div>
                        @endif

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
    $('.select2').select2();

    $('#dokumentasi_id').change(function() {
        let selectedOption = $(this).find('option:selected');
        let covers = selectedOption.data('covers');
        
        $('#cover_id').empty().append('<option value="" disabled selected>Pilih Cover</option>');
        $('#versi_cover_id').empty().append('<option value="" disabled selected>Pilih Versi</option>');

        if (covers && Object.keys(covers).length > 0) {
            $.each(covers, function(id, name) {
                $('#cover_id').append(`<option value="${id}">${name}</option>`);
            });
            $('#cover_id').prop('disabled', false);
        } else {
            $('#cover_id').prop('disabled', true);
            $('#versi_cover_id').prop('disabled', true);
        }
    });

    $('#cover_id').change(function() {
        let coverId = $(this).val();
        
        $('#versi_cover_id').empty().append('<option value="" disabled selected>Pilih Versi</option>');
        
        if (coverId) {
            $.ajax({
                url: `/api/get-versi/${coverId}`, // Sesuaikan dengan endpoint API backend
                type: 'GET',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(index, versi) {
                            $('#versi_cover_id').append(`<option value="${versi.id}">${versi.nama}</option>`);
                        });
                        $('#versi_cover_id').prop('disabled', false);
                    } else {
                        $('#versi_cover_id').prop('disabled', true);
                    }
                },
                error: function() {
                    console.error('Gagal mengambil data versi.');
                }
            });
        } else {
            $('#versi_cover_id').prop('disabled', true);
        }
    });
});

    </script>
</body>

</html>
