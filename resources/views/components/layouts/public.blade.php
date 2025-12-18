<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arvaya De Aure | Undangan Digital Premium</title>

    <meta name="description" content="Platform undangan digital premium dengan fitur AI Assistant, manajemen tamu, dan desain elegan.">
    <meta name="theme-color" content="#1a1a1a">
    <meta property="og:title" content="Arvaya De Aure | Undangan Digital Premium">
    <meta property="og:description" content="Buat undangan pernikahan impianmu dengan Arvaya De Aure.">
    <meta property="og:image" content="/logo.png">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/logo.png">
    <link rel="apple-touch-icon" href="/logo.png">

    <!-- Fonts Global (Optional, biasanya tiap tema punya font sendiri) -->
    <!-- Fonts (Sama seperti Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome (Wajib untuk icon sosmed/navigasi di undangan) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- aos CDN --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Slot untuk style tambahan spesifik tema --}}
    {{ $styles ?? '' }}
</head>

<body class="font-sans text-gray-800 antialiased bg-arvaya-50 overflow-x-hidden selection:bg-arvaya-200 selection:text-arvaya-900">

    <!-- NAVBAR (Regular Clean) -->
    <nav class="w-full bg-arvaya-50/80 backdrop-blur-md border-b border-arvaya-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 group">
                <img class="h-8 w-auto transition-transform group-hover:scale-105" src="/logo.png" alt="Arvaya Logo">
                <span class="font-serif font-bold text-xl text-arvaya-900 tracking-wide">ARVAYA</span>
            </a>
            
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-arvaya-800">
                <a href="#features" class="hover:text-arvaya-600 transition relative group">
                    Fitur
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-arvaya-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#themes" class="hover:text-arvaya-600 transition relative group">
                    Tema
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-arvaya-500 transition-all group-hover:w-full"></span>
                </a>
                <a href="#pricing" class="hover:text-arvaya-600 transition relative group">
                    Harga
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-arvaya-500 transition-all group-hover:w-full"></span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard.index') }}"
                        class="px-5 py-2.5 bg-arvaya-900 text-white rounded-lg text-sm font-bold hover:bg-arvaya-800 transition shadow-lg shadow-arvaya-900/10">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-arvaya-900 hover:text-arvaya-600 transition hidden sm:block">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-arvaya-900 text-white rounded-lg text-sm font-bold hover:bg-arvaya-800 transition shadow-lg shadow-arvaya-900/10">
                        Buat Undangan
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{ $slot }}

    <!-- FOOTER (Clean Minimalist) -->
    <footer class="bg-white border-t border-arvaya-100 pt-16 pb-8">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <img class="h-8 w-auto" src="/logo.png" alt="Arvaya Logo">
                        <span class="font-serif font-bold text-xl text-arvaya-900 tracking-wide">ARVAYA</span>
                    </a>
                    <p class="text-arvaya-700 text-sm leading-relaxed max-w-sm">
                        Platform undangan digital premium dengan sentuhan estetika tinggi dan teknologi AI cerdas. Rayakan momen bahagiamu dengan elegan.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-bold text-arvaya-900 mb-4 text-sm uppercase tracking-wider">Menu</h4>
                    <ul class="space-y-2 text-sm text-arvaya-700">
                        <li><a href="#features" class="hover:text-arvaya-500 transition">Fitur Unggulan</a></li>
                        <li><a href="#themes" class="hover:text-arvaya-500 transition">Koleksi Tema</a></li>
                        <li><a href="#pricing" class="hover:text-arvaya-500 transition">Paket Harga</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-arvaya-900 mb-4 text-sm uppercase tracking-wider">Legal & Support</h4>
                    <ul class="space-y-2 text-sm text-arvaya-700">
                        <li><a href="#" class="hover:text-arvaya-500 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-arvaya-500 transition">Kebijakan Privasi</a></li>
                        <li><a href="https://wa.me/6282260894009" class="hover:text-arvaya-500 transition">Bantuan WhatsApp</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-arvaya-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-arvaya-600">
                <p>&copy; {{ date('Y') }} Arvaya De Aure. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-arvaya-900"><i class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="#" class="hover:text-arvaya-900"><i class="fa-brands fa-tiktok text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>

<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/service-worker.js')
                .catch(function(e) { console.warn('SW registration failed', e) })
        })
    }
</script>

</html>
