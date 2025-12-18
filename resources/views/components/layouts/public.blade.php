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

<body class="font-sans text-gray-800 antialiased bg-arvaya-50 overflow-x-hidden">

    <!-- NAVBAR (New Addition) -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300" x-data="{ scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/80 backdrop-blur-md shadow-lg py-3' : 'bg-transparent py-6'">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/" class="font-serif text-2xl font-bold text-arvaya-900 tracking-tight">
                <img class="h-10" src="img/large-favicon/logo-transparent.png" alt="">
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-arvaya-500 transition">Fitur</a>
                <a href="#themes" class="hover:text-arvaya-500 transition">Tema</a>
                <a href="#pricing" class="hover:text-arvaya-500 transition">Harga</a>
                <a href="#testimonials" class="hover:text-arvaya-500 transition">Testimoni</a>
            </div>
            <a href="{{ route('dashboard.index') }}"
                class="px-6 py-2 bg-arvaya-900 text-white rounded-full text-sm font-bold hover:bg-arvaya-700 transition shadow-lg hover:shadow-arvaya-900/30">
                Login / Buat
            </a>
        </div>
    </nav>

    {{ $slot }}

    <!-- FOOTER -->
    <footer class="bg-arvaya-900 text-arvaya-100 pt-24 pb-12 relative overflow-hidden">
        <!-- Decoration -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-arvaya-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="font-serif text-4xl md:text-6xl font-bold mb-8" data-aos="zoom-in">Siap Menebar <br>Kabar
                Bahagia?</h2>
            <p class="text-arvaya-200 mb-12 max-w-xl mx-auto text-lg">
                Buat momen spesialmu abadi dalam balutan teknologi dan seni. Mulai sekarang, gratis coba tema.
            </p>

            <a href="{{ route('dashboard.index') }}"
                class="inline-block px-10 py-5 bg-arvaya-500 text-white rounded-full text-lg font-bold hover:bg-white hover:text-arvaya-900 transition duration-300 shadow-[0_0_40px_-10px_rgba(212,175,55,0.6)] mb-20 animate-bounce hover:animate-none">
                Buat Undangan Sekarang
            </a>

            <div class="grid md:grid-cols-4 gap-8 text-left border-t border-arvaya-800 pt-16 text-sm">
                <div class="col-span-1 md:col-span-2">
                    <span class="font-serif font-bold text-2xl text-white block mb-4">ARVAYA.</span>
                    <p class="text-arvaya-400 max-w-xs">Platform undangan digital #1 di Indonesia dengan fitur AI dan
                        desain premium.</p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Company</h4>
                    <ul class="space-y-2 text-arvaya-400">
                        <li><a href="#" class="hover:text-arvaya-200">About Us</a></li>
                        <li><a href="#" class="hover:text-arvaya-200">Pricing</a></li>
                        <li><a href="#" class="hover:text-arvaya-200">Affiliate</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-arvaya-400">
                        <li><a href="#" class="hover:text-arvaya-200">FAQ</a></li>
                        <li><a href="#" class="hover:text-arvaya-200">Contact</a></li>
                        <li><a href="#" class="hover:text-arvaya-200">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 text-center text-xs text-arvaya-600">
                &copy; {{ date('Y') }} Arvaya. All rights reserved. Made with <i
                    class="fa-solid fa-heart text-arvaya-500 mx-1"></i>.
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
