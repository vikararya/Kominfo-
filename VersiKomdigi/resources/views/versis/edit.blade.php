<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Versi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background: lightgray">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h1 class="h5 mb-3">Edit Versi</h1>
                
                <form action="{{ route('versis.update', $versi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" value="{{ $type }}">
                    
                    @if ($type === 'covers')
    <div class="form-group mb-3">
        <label class="font-weight-bold">Versi</label>
        <input type="text" name="versi" class="form-control" value="{{ old('versi', $versi->versi) }}" required>
    </div>
@endif
    
                    @if ($type === 'dokumentasis')
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Pilih Versi</label>
                            <select name="versi_cover_id" id="versi_cover_id" class="form-control" required>
                                <option value="" disabled>Pilih Versi</option>
                                @foreach ($filteredVersiCovers as $versiCover)
                                    <option value="{{ $versiCover->id }}" {{ $versi->id == $versiCover->id ? 'selected' : '' }}>
                                        {{ $versiCover->versi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
    
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
