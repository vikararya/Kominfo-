<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cover->name }} - Manual Docs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .sidebar-link {
            transition: all 0.2s ease;
        }
        
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(2px);
        }
        
        .content-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .chevron-transition {
            transition: transform 0.2s ease;
        }
        
        .group.active .chevron-transition {
            transform: rotate(90deg);
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.2);
            border-left: 3px solid var(--primary-color);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 shadow-md">
            <div class="w-full flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/' . $cover->logo) }}" alt="Logo Cover"
                             class="rounded-full w-12 h-12 border-2 border-white shadow-sm">
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold">{{ $cover->name }}</h1>
                            @if($selectedVersi)
                                <p class="text-sm text-blue-100">Versi {{ $selectedVersi->versi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                
                <div class="flex items-center gap-4">
                    <form method="GET" action="{{ route('home.show', ['cover' => $cover->id]) }}" class="flex items-center gap-2">
                        <div class="relative">
                            <select name="versi_id" id="versi_id" onchange="this.form.submit()" 
                                class="appearance-none bg-white text-gray-800 rounded-md pl-3 pr-8 py-2 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="" {{ !$versiId ? 'selected' : '' }}>Versi Terbaru</option>
                                @foreach ($versis as $versi)
                                    <option value="{{ $versi->id }}" {{ $versiId == $versi->id ? 'selected' : '' }}>
                                        {{ $versi->versi }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </form>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('home.index') }}" 
                           class="bg-gray-800 hover:bg-gray-900 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center gap-1">
                            <i class="fas fa-home"></i>
                            <span class="hidden md:inline">Beranda</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex h-screen">
            <!-- Sidebar + Main Content -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Sidebar -->
                <aside class="bg-gray-800 text-white w-64 flex-shrink-0 hidden md:block overflow-y-auto">
                    <nav class="p-4">
                        <!-- Link Selamat Datang -->
                        <a href="#welcome-section" 
                           class="block p-3 hover:bg-gray-700 rounded-lg sidebar-link transition-colors duration-200">
                            <strong class="text-gray-100">Selamat Datang</strong>
                        </a>
    
                        @if($dokumentasis->isEmpty())
                            <div class="bg-gray-700 p-4 rounded-lg mt-2">
                                <p class="text-gray-300 text-sm">Belum ada dokumentasi untuk versi ini.</p>
                            </div>
                        @else
                            <div class="flex flex-col gap-1 mt-2">
                                @foreach ($dokumentasis as $dokumentasi)
                                    @if ($dokumentasi->subjudulList->count() > 0)
                                        <div class="group rounded-lg overflow-hidden">
                                            <button class="w-full text-left p-3 hover:bg-gray-700 rounded-lg flex justify-between items-center transition-colors duration-200">
                                                <strong class="break-words whitespace-normal text-left text-gray-100">{{ $dokumentasi->judul }}</strong>
                                                <i class="fas fa-chevron-right text-xs chevron-transition"></i>
                                            </button>
                                            <div class="ml-4 hidden group-[.active]:block">
                                                @foreach ($dokumentasi->subjudulList as $subjudul)
                                                    <a href="#subjudul-{{ $subjudul->id }}" 
                                                       class="block p-2 pl-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-md sidebar-link transition-colors duration-200 break-words whitespace-normal">
                                                        {{ $subjudul->subjudul }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <a href="#dokumentasi-{{ $dokumentasi->id }}" 
                                           class="block p-3 hover:bg-gray-700 rounded-lg sidebar-link transition-colors duration-200">
                                            <strong class="text-gray-100">{{ $dokumentasi->judul }}</strong>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </nav>
                </aside>
    
                <!-- Mobile Sidebar Toggle -->
                <button id="sidebarToggle" class="md:hidden fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg z-50">
                    <i class="fas fa-bars"></i>
                </button>
    
                <!-- Mobile Sidebar -->
                <div id="mobileSidebar" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-40 hidden md:hidden">
                    <div class="absolute left-0 top-0 h-full w-3/4 bg-gray-800 shadow-lg overflow-y-auto">
                        <div class="p-4 flex justify-between items-center border-b border-gray-700">
                            <h2 class="text-xl font-bold">Menu</h2>
                            <button id="closeSidebar" class="text-gray-300 hover:text-white">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <nav class="p-4">
                            <a href="#welcome-section" 
                               class="block p-3 hover:bg-gray-700 rounded-lg sidebar-link transition-colors duration-200">
                                <strong class="text-gray-100">Selamat Datang</strong>
                            </a>
    
                            @if($dokumentasis->isEmpty())
                                <div class="bg-gray-700 p-4 rounded-lg mt-2">
                                    <p class="text-gray-300 text-sm">Belum ada dokumentasi untuk versi ini.</p>
                                </div>
                            @else
                                <div class="flex flex-col gap-1 mt-2">
                                    @foreach ($dokumentasis as $dokumentasi)
                                        @if ($dokumentasi->subjudulList->count() > 0)
                                            <div class="group rounded-lg overflow-hidden">
                                                <button class="w-full text-left p-3 hover:bg-gray-700 rounded-lg flex justify-between items-center transition-colors duration-200">
                                                    <strong class="break-words whitespace-normal text-left text-gray-100">{{ $dokumentasi->judul }}</strong>
                                                    <i class="fas fa-chevron-right text-xs chevron-transition"></i>
                                                </button>
                                                <div class="ml-4 hidden group-[.active]:block">
                                                    @foreach ($dokumentasi->subjudulList as $subjudul)
                                                        <a href="#subjudul-{{ $subjudul->id }}" 
                                                           class="block p-2 pl-3 text-gray-300 hover:text-white hover:bg-gray-700 rounded-md sidebar-link transition-colors duration-200 break-words whitespace-normal">
                                                            {{ $subjudul->subjudul }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="#dokumentasi-{{ $dokumentasi->id }}" 
                                               class="block p-3 hover:bg-gray-700 rounded-lg sidebar-link transition-colors duration-200">
                                                <strong class="text-gray-100">{{ $dokumentasi->judul }}</strong>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </nav>
                    </div>
                </div>
    
                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-8 bg-white overflow-y-auto">
                    <div id="welcome-section" class="bg-white p-6 rounded-xl shadow-sm content-card mb-6 border border-gray-100">
                        <!-- Judul Selamat Datang -->
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang</h2>
                    
                        <!-- Konten utama -->
                        <div class="prose max-w-none text-gray-700 mb-4">
                            {!! $cover->content !!}
                        </div>
                    
                        <hr class="my-4 border-gray-200">
                    
                        <!-- Informasi tambahan -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-bold">Version :</span> <span>{{ $cover->versi }}</span>
                            </div>
                            <div>
                                <span class="font-bold">Created :</span> <span>{{ $cover->created_at->format('Y') }}</span>
                            </div>
                            <div>
                                <span class="font-bold">Update :</span> <span>{{ \Carbon\Carbon::parse($cover->edited_at)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    
                        <div class="mt-2">
                            <span class="font-bold">Author :</span>
                            <span class="text-blue-600 font-semibold">{{ $cover->author }}</span>
                        </div>
                    
                        <!-- Pesan tambahan -->
                        <div class="bg-blue-100 text-blue-700 p-4 rounded-lg mt-6 text-sm">
                            Buku Manual Elektronik ini akan diupdate secara berkala. Jika anda menemukan kesalahan penulisan atau tidak kesesuaian, mohon hubungi kami melalui 
                            <a href="mailto:support@example.com" class="font-bold underline">Email</a>.
                        </div>
                    </div>
                    
    
                    @if($dokumentasis->isEmpty())
                        <div class="flex flex-col items-center justify-center h-full text-center py-12">
                            <i class="fas fa-book-open text-5xl text-gray-400 mb-4"></i>
                            <h2 class="text-2xl font-semibold text-gray-700 mb-2">Dokumentasi Tidak Tersedia</h2>
                            <p class="text-gray-500 max-w-md">Belum ada dokumentasi yang tersedia untuk versi ini. Silakan pilih versi lain atau periksa kembali nanti.</p>
                        </div>
                    @else
                        <div class="max-w-7xl mx-auto">
                            @foreach ($dokumentasis as $dokumentasi)
                                @if ($dokumentasi->subjudulList->isEmpty())
                                    <div class="bg-white p-6 rounded-xl shadow-sm content-card mb-6 border border-gray-100" id="dokumentasi-{{ $dokumentasi->id }}">
                                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                            {{ $dokumentasi->judul }}
                                        </h2>
                                        <div class="prose max-w-none text-gray-700">
                                            {!! $dokumentasi->deskripsi !!}
                                        </div>
                                    </div>
                                @else
                                    @foreach ($dokumentasi->subjudulList as $subjudul)
                                        <div class="bg-white p-6 rounded-xl shadow-sm content-card mb-6 border border-gray-100" id="subjudul-{{ $subjudul->id }}">
                                            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                <i class="fas fa-file-alt text-blue-500"></i>
                                                {{ $subjudul->subjudul }}
                                            </h2>
                                            @if ($subjudul->deskripsi)
                                                <div class="prose max-w-none text-gray-700">
                                                    {!! $subjudul->deskripsi !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
    
                        <!-- Back to top button -->
                        <button id="backToTop" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden md:hidden">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                    @endif
                </main>
            </div>
        </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Toggle dropdown sidebar
    document.querySelectorAll("aside nav .group > button").forEach(button => {
        button.addEventListener("click", function () {
            const parentGroup = this.closest(".group");
            parentGroup.classList.toggle("active");
        });
    });

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    
    sidebarToggle.addEventListener('click', () => {
        mobileSidebar.classList.remove('hidden');
    });
    
    closeSidebar.addEventListener('click', () => {
        mobileSidebar.classList.add('hidden');
    });

    // Back to top button
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('hidden');
        } else {
            backToTop.classList.add('hidden');
        }
    });
    
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Highlight current section in sidebar
    const sections = document.querySelectorAll('main > div > div[id]');
    const sidebarLinks = document.querySelectorAll('aside nav a[href^="#"]');
    
    function highlightCurrentSection() {
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (window.scrollY >= sectionTop - 200) {
                currentSection = '#' + section.getAttribute('id');
            }
        });
        
        sidebarLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === currentSection) {
                link.classList.add('active');
                
                // Open parent dropdown if exists
                const parentGroup = link.closest('.group');
                if (parentGroup && !parentGroup.classList.contains('active')) {
                    parentGroup.classList.add('active');
                }
            }
        });
    }
    
    window.addEventListener('scroll', highlightCurrentSection);
    highlightCurrentSection(); // Run once on load
    
    // Close mobile sidebar when clicking a link
    document.querySelectorAll('#mobileSidebar a').forEach(link => {
        link.addEventListener('click', () => {
            mobileSidebar.classList.add('hidden');
        });
    });
});
    </script>
</body>
</html>