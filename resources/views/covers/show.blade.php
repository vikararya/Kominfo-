<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Cover</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Detail Cover</h4>
            </div>
            <div class="card-body">
                <h5><strong>Nama Cover:</strong> {{ $cover->name }}</h5>
                <p><strong>Kategori:</strong> {{ $cover->kategori->name }}</p>
                <p><strong>Status:</strong> {{ ucfirst($cover->status) }}</p>
                <p><strong>Konten:</strong> {{ $cover->content }}</p>
                
                <div class="mb-3">
                    <strong>Cover:</strong><br>
                    <img src="{{ asset('storage/' . $cover->image) }}" class="img-fluid" width="200">
                </div>
                
                <div class="mb-3">
                    <strong>Logo:</strong><br>
                    <img src="{{ asset('storage/' . $cover->logo) }}" class="img-fluid" width="100">
                </div>
                
                <h5><strong>Versi:</strong></h5>
                @if($cover->versis->isNotEmpty())
                    <p>Versi {{ $cover->versis->first()->versi }} - {{ $cover->versis->first()->created_at->format('d M Y') }}</p>
                @else
                    <p>Belum ada versi tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
