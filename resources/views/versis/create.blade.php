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
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Tambah Versi</h5>
            </div>
            <div class="card-body">
                <h1 class="h5 mb-3">Tambah Cover</h1>
        
                <!-- Form -->
                <form action="{{ route('versis.store') }}" method="POST" class="mt-4">
                    @csrf
        
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
        
                    <!-- Input Deskripsi -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi"></textarea>
                    </div>
        
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
