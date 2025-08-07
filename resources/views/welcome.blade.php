{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Docs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-lightBg text-darkText font-sans">

    <!-- Navbar -->
    <header class="flex justify-between items-center px-8 py-6 shadow-sm bg-white sticky top-0 z-50">
        <div onclick="showAuth()" class="flex items-center gap-3 cursor-pointer">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            <h1 class="text-2xl font-extrabold text-primary hover:text-secondary transition">
                Manual Docs
            </h1>
        </div>
        <div id="auth-buttons" class="space-x-4 hidden">
            <a href="/login" class="px-4 py-2 text-sm font-medium text-primary border border-primary rounded hover:bg-primary hover:text-white transition">
                Login
            </a>
            <a href="/register" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded hover:bg-secondary transition">
                Register
            </a>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center px-4 py-24 bg-gradient-to-br from-sky-600 via-blue-500 to-indigo-500
 text-white">
        <h2 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6 drop-shadow">
            Welcome to <span class="underline decoration-white/40">Manual Docs</span>
        </h2>
        <p class="text-lg md:text-xl max-w-2xl mb-8 text-blue-100">
            Your centralized place to read, write, and manage all technical documentation with ease.
        </p>
        <a href="/home" class="bg-white text-primary px-6 py-3 rounded-lg font-semibold text-lg shadow hover:bg-gray-100 transition mb-12">
            Get Started
        </a>

        <!-- Image Row -->
        <div class="flex flex-col md:flex-row gap-6 items-center justify-center">
            <img src="{{ asset('storage/images/home.png') }}" alt="Documentation Illustration 1" class="w-full md:w-[100%] max-w-md rounded-lg shadow-xl">
            <img src="{{ asset('storage/images/show.png') }}" alt="Documentation Illustration 2" class="w-full md:w-[100%] max-w-md rounded-lg shadow-xl">
        </div>
    </section>

    <!-- Features Section -->
    <section class="px-8 py-20 bg-gradient-to-r from-white via-slate-50 to-white">
        <div class="max-w-6xl mx-auto text-center">
            <h3 class="text-3xl font-bold mb-14 text-darkText">Why Manual Docs?</h3>
            <div class="grid gap-10 md:grid-cols-3 text-left">
                <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h4 class="text-xl font-semibold mb-3 text-primary">Easy Navigation</h4>
                    <p class="text-gray-600">Structured layout that helps users find information quickly and efficiently.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h4 class="text-xl font-semibold mb-3 text-primary">Collaborative Editing</h4>
                    <p class="text-gray-600">Built-in tools to allow teams to write and update docs in real-time.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h4 class="text-xl font-semibold mb-3 text-primary">Clean & Clear Design</h4>
                    <p class="text-gray-600">Minimalist and distraction-free UI for a better reading experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 py-6 bg-gradient-to-r from-slate-100 via-gray-50 to-white">
        &copy; {{ date('Y') }} Manual Docs. All rights reserved.
    </footer>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        function showAuth() {
            const el = document.getElementById("auth-buttons");
            el.classList.toggle("hidden");
        }
    </script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
                colors: {
                    primary: '#3B82F6',
                    secondary: '#6366F1',
                    lightBg: '#F9FAFB',
                    darkText: '#1F2937',
                }
            }
        }
    }
</script>

</body>
</html>
