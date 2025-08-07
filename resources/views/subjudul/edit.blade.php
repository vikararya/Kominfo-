<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Dokumentasi</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body style="background: lightgray">
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Edit List</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subjudul.update', $subjudul->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Pilih Judul Dokumentasi -->
                            <div class="form-group">
                                <label class="font-weight-bold">Judul Dokumentasi</label>
                                <select name="dokumentasi_id" id="dokumentasi_id" class="form-control select2" required>
                                    <option value="" disabled>Pilih Judul Dokumentasi</option>
                                    @foreach ($dokumentasis as $dokumentasi)
                                        <option value="{{ $dokumentasi->id }}" {{ $subjudul->dokumentasi_id == $dokumentasi->id ? 'selected' : '' }}>{{ $dokumentasi->judul }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input Subjudul -->
                            <div class="form-group">
                                <label class="font-weight-bold">Subjudul</label>
                                <input type="text" class="form-control @error('subjudul') is-invalid @enderror" name="subjudul" value="{{ old('subjudul', $subjudul->subjudul) }}" placeholder="Masukkan Subjudul">
                                @error('subjudul')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Textarea Isi Halaman -->
                            <div class="form-group">
                                <label class="font-weight-bold">Isi Halaman</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $subjudul->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilih Status -->
                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="draft" {{ $subjudul->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ $subjudul->status == 'publish' ? 'selected' : '' }}>Publish</option>
                                </select>
                            </div>

                            <!-- Tombol Simpan dan Batal -->
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('subjudul.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- TinyMCE JS -->
    <script src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    
    <script>
        tinymce.init({
            selector: '#deskripsi', // Target textarea dengan id="deskripsi"
            height: 500, // Tinggi editor
            menubar: true, // Tampilkan menubar
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                'emoticons', // Plugin emoticon
                'codesample', // Plugin code sample
                'media', // Plugin media (video)
                'hr', // Plugin horizontal line
                'textcolor', // Plugin warna teks
                'pagebreak', // Plugin page break
                'directionality', // Plugin arah teks (RTL/LTR)
                'fullpage', // Plugin untuk mengelola seluruh halaman HTML
                'image' // Plugin untuk upload gambar
            ],
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | link image media | \
                      forecolor backcolor emoticons codesample | \
                      table tabledelete | tableprops tablerowprops tablecellprops | \
                      tableinsertrowbefore tableinsertrowafter tabledeleterow | \
                      tableinsertcolbefore tableinsertcolafter tabledeletecol | \
                      pagebreak hr | ltr rtl | fullpage | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
    
                    fetch("{{ route('subjudul.uploadImage') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response:', response); // Debug respons dari server
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data:', data); // Debug data yang dikembalikan
                        if (data.url) {
                            resolve(data.url); // Jika berhasil, kembalikan URL gambar
                        } else {
                            reject('Gagal mengupload gambar'); // Jika gagal, tampilkan pesan error
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error); // Debug error
                        reject('Error: ' + error.message); // Tangani error
                    });
                });
            }
        });
    </script>

    

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Cari Judul Dokumentasi...",
            allowClear: true
        });
    });
</script>


</body>
</html>
