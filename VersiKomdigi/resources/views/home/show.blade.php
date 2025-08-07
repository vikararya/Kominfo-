<!DOCTYPE html>
<html>
<head>
    <title>Manual Docs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-3 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('storage/' . $cover->logo) }}" alt="Logo Cover" class="rounded-full me-3 w-12 h-12">
                <h1 class="text-xl font-semibold">{{ $cover->name }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('home.show', ['cover' => $cover->id]) }}">
                    <select name="versi_id" id="versi_id" onchange="this.form.submit()" 
                        class="border rounded px-2 py-1 text-sm text-black">
                        <!-- Perbaikan: Opsi "Versi Terbaru" dengan value kosong -->
                       <option value="" {{ !$versiId ? 'selected' : '' }}>Versi Terbaru</option>
                        @foreach ($versis as $versi)
                            <option value="{{ $versi->id }}" {{ $versiId == $versi->id ? 'selected' : '' }}>
                                {{ $versi->versi }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('home.index') }}" class="bg-gray-800 px-4 py-2 rounded text-sm">Beranda</a>
                <a href="#" class="text-white hover:text-gray-200">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-white hover:text-gray-200">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="bg-gray-800 text-white w-64 p-4 flex-none">
                <nav>
                    <div class="flex flex-col gap-2">
                        @forelse ($dokumentasis as $dokumentasi)
                            @if ($dokumentasi->subjudulList->count() > 0)
                                <div class="group">
                                    <button class="w-full text-left p-2 hover:bg-gray-700 rounded flex justify-between items-center">
                                        <strong>{{ $dokumentasi->judul }}</strong>
                                        <i class="fas fa-chevron-right text-xs transition-transform"></i>
                                    </button>
                                    <div class="ml-3 hidden group-[.active]:block">
                                        @foreach ($dokumentasi->subjudulList as $subjudul)
                                            <a href="#subjudul-{{ $subjudul->id }}" class="block p-2 hover:bg-gray-700 rounded">
                                                {{ $subjudul->subjudul }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="#dokumentasi-{{ $dokumentasi->id }}" class="block p-2 hover:bg-gray-700 rounded">
                                    <strong>{{ $dokumentasi->judul }}</strong>
                                </a>
                            @endif
                        @empty
                            <p class="text-white p-4">Belum ada dokumentasi untuk versi ini.</p>
                        @endforelse
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 bg-white">
                @foreach ($dokumentasis as $dokumentasi)
                    @if ($dokumentasi->subjudulList->isEmpty())
                        <!-- Tambahkan ID untuk anchor -->
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4" id="dokumentasi-{{ $dokumentasi->id }}">
                            <h2 class="text-2xl font-semibold mb-3">{{ $dokumentasi->judul }}</h2>
                            <p class="text-lg text-gray-700 max-w-3xl break-words">{!! $dokumentasi->deskripsi !!}</p>
                        </div>
                    @else
                        @foreach ($dokumentasi->subjudulList as $subjudul)
                            <!-- Tambahkan ID untuk anchor -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4" id="subjudul-{{ $subjudul->id }}">
                                <h2 class="text-2xl font-semibold mb-3">{{ $subjudul->subjudul }}</h2>
                                @if ($subjudul->deskripsi)
                                    <p class="text-lg text-gray-700 max-w-3xl">{!! $subjudul->deskripsi !!}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </main>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Toggle dropdown sidebar
    document.querySelectorAll("aside nav .group > button").forEach(button => {
        button.addEventListener("click", function () {
            const parentGroup = this.closest(".group");
            const dropdownContent = parentGroup.querySelector("div");
            const icon = this.querySelector("i");
            
            // Toggle class dan icon
            parentGroup.classList.toggle("active");
            dropdownContent.style.display = parentGroup.classList.contains("active") ? "block" : "none";
            icon.classList.toggle("fa-chevron-down");
            icon.classList.toggle("fa-chevron-right");
        });
    });

    // Scroll ke konten saat anchor diklik
    document.querySelectorAll("aside nav a[href^='#']").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href");
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        });
    });
});
    </script>
</body>
</html>