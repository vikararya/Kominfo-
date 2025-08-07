<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $dokumentasi->judul }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-gray-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-white text-xl font-semibold">{{ $dokumentasi->judul }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Version Selector -->
                        <div class="flex items-center space-x-2">
                            <select id="versiSelector" 
                                    class="block w-40 px-2 py-1 border border-gray-300 rounded-md bg-white shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="{{ route('dokumentasis.show', ['dokumentasi' => $dokumentasi->id, 'versi_id' => optional($latestVersi)->id]) }}" 
                                    {{ $versiId == optional($latestVersi)->id ? 'selected' : '' }}>
                                    Versi Terbaru
                                </option>
                                @foreach ($versis as $versi)
                                    <option value="{{ route('dokumentasis.show', ['dokumentasi' => $dokumentasi->id, 'versi_id' => $versi->id]) }}" 
                                        {{ $versiId == $versi->id ? 'selected' : '' }}>
                                        {{ $versi->versi }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" onclick="changeVersion()" 
                                    class="px-3 py-1 text-sm border border-blue-500 text-blue-500 rounded-md hover:bg-blue-50">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Dokumentasi -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white rounded-lg shadow">
                        <div class="bg-blue-500 text-white px-4 py-3 rounded-t-lg">
                            <h5 class="text-lg font-semibold"><i class="fas fa-book mr-2"></i> Daftar Dokumentasi</h5>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <!-- Tampilkan Dokumentasi Asli -->
                            <h6 class="px-4 py-2 bg-gray-100 text-sm font-semibold">Dokumentasi Asli</h6>
                            @foreach($originalDokumentasis->sortBy('order') as $doc)
                                <a href="{{ route('dokumentasis.show', ['dokumentasi' => $doc->id, 'versi_id' => optional($doc->versis)->first()?->id]) }}">
                                    <div class="flex justify-between items-center px-4 py-2 hover:bg-gray-50">
                                        <div>
                                            <span class="text-xs bg-gray-200 rounded px-2 py-1 mr-2">{{ $doc->order }}</span>
                                            {{ $doc->judul }}
                                        </div>
                                        <span class="text-xs bg-gray-200 rounded px-2 py-1">
                                            v{{ optional($doc->versis)->first()?->versi ?? '0.0' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Tampilkan Dokumentasi Duplikat jika ada -->
                            @if($duplicateDokumentasis->isNotEmpty())
                                <h6 class="px-4 py-2 bg-gray-100 text-sm font-semibold">Dokumentasi Duplikat</h6>
                                @foreach($duplicateDokumentasis->sortBy('order') as $doc)
                                    <a href="{{ route('dokumentasis.show', ['dokumentasi' => $doc->id, 'versi_id' => optional($doc->versis)->first()?->id]) }}">
                                        <div class="flex justify-between items-center px-4 py-2 hover:bg-gray-50">
                                            <div>
                                                <span class="text-xs bg-gray-200 rounded px-2 py-1 mr-2">{{ $doc->order }}</span>
                                                {{ $doc->judul }}
                                            </div>
                                            <span class="text-xs bg-gray-200 rounded px-2 py-1">
                                                v{{ optional($doc->versis)->first()?->versi ?? '0.0' }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                                {{ $dokumentasi->judul }}
                            </h1>
                            <div class="text-sm text-gray-500 mb-4">
                                Status: 
                                <span class="ml-1 px-2 py-1 rounded-full text-xs font-medium {{ $dokumentasi->status === 'publish' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $dokumentasi->status === 'publish' ? 'Publish' : 'Draft' }}
                                </span>
                            </div>
                            
                            <!-- Konten -->
                            <div class="space-y-8">
                                <section>
                                    <h2 class="text-lg font-semibold border-b pb-2 text-gray-700">Deskripsi Utama</h2>
                                    <div class="mt-4 prose max-w-none">
                                        {!! $dokumentasi->deskripsi ?? 'Belum ada deskripsi.' !!}
                                    </div>
                                </section>

                                @foreach($dokumentasi->subjudulList as $subjudul)
                                    <section id="subjudul-{{ $subjudul->id }}" class="space-y-4">
                                        <h3 class="text-md font-semibold text-gray-700">
                                            <i class="fas fa-bookmark text-blue-500 mr-2"></i>
                                            {{ $subjudul->subjudul }}
                                        </h3>
                                        <div class="bg-gray-50 p-4 rounded-lg prose max-w-none">
                                            {!! $subjudul->deskripsi ?? 'Belum ada deskripsi.' !!}
                                        </div>
                                    </section>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeVersion() {
            const selectedVersion = document.getElementById('versiSelector').value;
            window.location.href = selectedVersion;
        }
    </script>
</body>
</html>