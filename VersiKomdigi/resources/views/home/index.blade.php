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
    <!-- Header -->
    <header class="bg-blue-600 text-white py-4">
        <div class="container ml-10 flex justify-between items-center px-4">
            <!-- Logo dan Teks -->
            <div class="flex items-center">
                <img src="https://storage.googleapis.com/a1aa/image/j_JMnXCTwk4pydQNSzHmb7W7A9kGZL27nmyUdyNNAaE.jpg" 
                     alt="Logo" class="rounded-full h-10 w-10" />
                <h1 class="ml-2 text-lg font-semibold">Manual Docs</h1>
            </div>
    
            <!-- Sosial Media -->
            <div class="flex space-x-3">
                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </header>    

    <!-- Hero Section -->
    <section class="relative w-full">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <img src="https://storage.googleapis.com/a1aa/image/YQb8rQjAMtGln8-_B_WCKp-bbLte1JgF1c32aXu0HQs.jpg" 
             alt="Car in autumn forest" class="w-full h-96 object-cover" />
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white">
            <h2 class="text-6xl font-bold">Manual Docs</h2>
            <p class="text-lg italic">Semua buku manual aplikasi Pemerintah Kabupaten Tuban ada disini</p>
    
            <!-- Form Search dan Filter -->
            <form action="{{ route('home.index') }}" method="GET" class="mt-4 flex space-x-2 items-center">
                <!-- Tombol Filter dengan Dropdown -->
                <div class="relative">
                    <button type="button" id="filterButton" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Filter
                    </button>
                    <div id="filterDropdown" class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded hidden">
                        <select name="kategori" class="p-2 w-full rounded bg-white text-black">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $kategoriId == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 mt-2 rounded">Terapkan</button>
                    </div>
                </div>
    
                <!-- Input Search dengan Tombol di Dalamnya -->
                <div class="relative w-[700px]">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="p-2 rounded w-full pr-12 text-black" 
                           placeholder="Search Any Documentation" />
                           <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-green-600 text-white rounded-r">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </section>
    

    <!-- Content Section -->
    <div class="container mx-auto p-6">
        <!-- Alert jika ada pesan sukses -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tampilkan Semua Cover dalam Card -->
        <div class="grid md:grid-cols-3 gap-6 mt-6">
            @foreach ($covers as $cover)
                <div class="bg-white shadow-lg rounded overflow-hidden">
                    <figure class="effect-ming tm-video-item">
                        <!-- Gambar Cover -->
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
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white text-center py-4">
        <p class="mb-0">Copyright &copy; 2022
            <a href="#" class="font-bold text-white">TeamDev Diskominfo Tuban</a>. All Rights Reserved.
        </p>
    </footer>

    <script>
        document.getElementById('filterButton').addEventListener('click', function () {
            document.getElementById('filterDropdown').classList.toggle('hidden');
        });
    
        // Menutup dropdown saat klik di luar area filter
        document.addEventListener('click', function (event) {
            let filterButton = document.getElementById('filterButton');
            let filterDropdown = document.getElementById('filterDropdown');
    
            if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                filterDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
