<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manual Docs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="css/template.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Content Section -->
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">All Covers</h2>
        
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($covers as $cover)
                <div class="bg-white shadow-lg rounded overflow-hidden">
                    <figure class="effect-ming tm-video-item">
                        @if ($cover->image)
                            <img src="{{ Storage::url($cover->image) }}" alt="{{ $cover->name }}" class="w-full h-48 object-cover" />
                        @endif
                        <figcaption class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
                            <h2>Details</h2>
                            <a href="{{ route('home.show', ['cover' => $cover->id]) }}">View more</a>
                        </figcaption>
                    </figure>
                    <div class="p-4">
                        <h5 class="text-xl font-bold">
                            {{ $cover->name }} 
                            @if ($cover->versis->isNotEmpty())
                                <span class="text-sm text-gray-500">v{{ $cover->versis->first()->versi }}</span>
                            @endif
                        </h5>                        
                        <p class="text-gray-600 text-sm break-words whitespace-normal">{{ Str::limit($cover->content, 100) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    
        <!-- Tambahkan Pagination -->
        <div class="mt-6">
            {{ $covers->links() }}
        </div>
    </div>


</body>
</html>
