<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Versi</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: 600;
        }
        .version-input {
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Edit Versi</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('versis.update', $versi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Cover Info (readonly) -->
                            <div class="form-group mb-3">
                                <label for="cover_id" class="form-label">Cover</label>
                                <input type="text" class="form-control" value="{{ $versi->cover->name }}" readonly>
                                <input type="hidden" name="cover_id" value="{{ $versi->cover_id }}">
                            </div>
                            
                            <!-- Current Version (readonly) -->
                            <div class="form-group mb-3">
                                <label for="current_version" class="form-label">Versi Saat Ini</label>
                                <input type="text" class="form-control" value="{{ $versi->versi }}" readonly>
                            </div>
                            
                            <!-- New Version Input -->
                            <div class="form-group mb-3">
                                <label for="versi" class="form-label">Versi Baru</label>
                                <input type="text" 
                                       class="form-control version-input @error('versi') is-invalid @enderror" 
                                       name="versi" 
                                       id="versi" 
                                       value="{{ old('versi', $versi->versi) }}" 
                                       placeholder="Contoh: 1.0.0"
                                       pattern="^\d+\.\d+\.\d+$"
                                       title="Format versi harus X.X.X (contoh: 1.0.0)"
                                       required>
                                @error('versi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: major.minor.patch (contoh: 1.0.0)</small>
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="form-group mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi">{{ old('deskripsi',$versi->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('versis.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <script>
        // Validasi format versi sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const versionInput = document.getElementById('versi');
            const versionPattern = /^\d+\.\d+\.\d+$/;
            
            if (!versionPattern.test(versionInput.value)) {
                e.preventDefault();
                alert('Format versi tidak valid. Harus dalam format X.X.X (contoh: 1.0.0)');
                versionInput.focus();
            }
        });
    </script>
</body>
</html>