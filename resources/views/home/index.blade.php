<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manual Docs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/template.css" rel="stylesheet">
    <style>
        .effect-ming figcaption::before {
            border: 2px solid rgba(255, 255, 255, 0.7);
            transform: scale(1.1);
        }
        .effect-ming:hover img {
            opacity: 0.7;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        .effect-ming figcaption {
            background: rgba(37, 99, 235, 0.7);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .effect-ming:hover figcaption {
            opacity: 1;
        }
        .card-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-4 sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
            <!-- Logo dan Teks -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/images/logo.png') }}" 
                     alt="Logo" class="h-10 w-10" />
                <h1 class="text-xl font-bold tracking-tight">Manual Docs</h1>
            </div>
    
            <!-- Sosial Media -->
            <div class="flex space-x-4">
                <a href="#" class="text-white hover:text-blue-200 transition-colors duration-200">
                    <i class="fab fa-twitter text-lg"></i>
                </a>
                <a href="#" class="text-white hover:text-blue-200 transition-colors duration-200">
                    <i class="fab fa-facebook-f text-lg"></i>
                </a>
            </div>
        </div>
    </header>    

    <!-- Hero Section -->
    <section class="relative w-full">
        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
        <img src="{{ asset('storage/images/kominfo.jpg') }}" 
             alt="Car in autumn forest" class="w-full h-96 md:h-[500px] object-cover" />
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white w-full px-4">
            <h2 class="text-4xl md:text-6xl font-bold mb-2">Manual Docs</h2>
            <p class="text-lg md:text-xl italic mb-8">Semua buku manual aplikasi Pemerintah Kabupaten Tuban ada disini</p>
    
            <!-- Form Search dan Filter -->
            <form action="{{ route('home.index') }}" method="GET" class="mt-4 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 items-center justify-center max-w-4xl mx-auto">
                <!-- Input Search dengan Tombol di Dalamnya -->
                <div class="relative w-full md:w-[500px]">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="search-input p-3 rounded-lg w-full pr-12 text-gray-800 focus:ring-2 focus:ring-blue-500" 
                           placeholder="Search Any Documentation" />
                    <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-green-600 hover:bg-green-700 text-white rounded-r-lg transition-colors duration-200">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <!-- Tombol Filter dengan Dropdown -->
                <div class="relative w-full md:w-auto">
                    <button type="button" id="filterButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <div id="filterDropdown" class="absolute left-0 mt-2 w-48 bg-white shadow-xl rounded-lg hidden z-10 p-3">
                        <select name="kategori" class="p-2 w-full rounded border border-gray-300 bg-white text-gray-800 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ $kategoriId == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 mt-2 rounded-lg transition-colors duration-200">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    

    <!-- Content Section -->
    <div class="container mx-auto p-4 md:p-6">
        <!-- Alert jika ada pesan sukses -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button class="ml-auto focus:outline-none" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Tampilkan Semua Cover dalam Card -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach ($covers as $cover)
                <div class="bg-white rounded-lg overflow-hidden card-shadow">
                    <figure class="effect-ming tm-video-item relative overflow-hidden">
                        <!-- Gambar Cover -->
                        @if ($cover->image)
                            <img src="{{ Storage::url($cover->image) }}" alt="{{ $cover->name }}" class="w-full h-48 md:h-56 object-cover" />
                        @else
                            <div class="w-full h-48 md:h-56 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-book text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        <figcaption class="absolute inset-0 flex flex-col items-center justify-center text-center text-white p-4">
                            <h2 class="text-xl font-bold mb-2">{{ $cover->name }}</h2>
                            <a href="{{ route('home.show', ['cover' => $cover->id]) }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-100 transition-colors duration-200">
                                View Details
                            </a>
                        </figcaption>
                    </figure>
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h5 class="text-lg font-bold text-gray-800">
                                {{ $cover->name }}
                            </h5>
                            @if ($cover->versis->isNotEmpty())
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                    v{{ $cover->versis->first()->versi }}
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($cover->content, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $cover->created_at->format('d M Y') }}
                            </span>
                            <a href="{{ route('home.show', ['cover' => $cover->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                                Read More <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if ($covers->count() >= 6)
            <div class="text-center mt-8">
                <a href="{{ route('home.all') }}" class="inline-flex items-center bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    View All Documents
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('storage/images/logo.png') }}" 
                             alt="Logo" class="h-10 w-10" />
                        <h2 class="text-xl font-bold">Manual Docs</h2>
                    </div>
                    <p class="mt-2 text-sm text-blue-100">Sumber informasi manual aplikasi Kabupaten Tuban</p>
                </div>
                
                <div class="flex space-x-6">
                    <a href="#" class="text-white hover:text-blue-200 transition-colors duration-200">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition-colors duration-200">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition-colors duration-200">
                        <i class="fas fa-envelope text-xl"></i>
                    </a>
                </div>
            </div>
            
            <div class="border-t border-blue-500 mt-6 pt-6 text-center text-sm text-blue-100">
                <p>Copyright &copy; 2025 <a href="#" class="font-bold text-white hover:underline">TeamDev Diskominfo Tuban</a>. All Rights Reserved.</p>
            </div>
        </div>
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