<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center" style="background-image: url('/storage/images/office.jpg')">
            <!-- Overlay gelap -->
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>

            <!-- Konten utama -->
            <div class="relative z-10 flex flex-col items-center space-x-3">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-10 h-10">
                    <p class="mt-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Manual Docs</p>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 bg-white dark:bg-gray-800 bg-opacity-90 backdrop-blur-md shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Welcome Back</h2>
                </div>
                <div class="px-6 py-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
