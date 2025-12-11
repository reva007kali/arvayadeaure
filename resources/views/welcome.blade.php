<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arvaya De Aure - Undangan Pernikahan Digital Eksklusif</title>
    {{-- <link rel="icon" href="/favicon.ico" sizes="any"> --}}
    <link rel="icon" href="/logo.png" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/logo.png">


    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ANIMATION LIBRARY (AOS) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- TAILWIND CSS (Configured for Arvaya) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        arvaya: {
                            50: '#F9F7F2', // Cream Background
                            100: '#F2ECDC',
                            200: '#E6D9B8',
                            500: '#B89760', // GOLD Primary
                            600: '#9A7D4C',
                            800: '#5E4926',
                            900: '#2D2418', // Dark Brown Text
                        },
                        dark: '#1A1A1A'
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        display: ['Cinzel Decorative', 'cursive'],
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <!-- ALPINE JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #F9F7F2;
        }

        ::-webkit-scrollbar-thumb {
            background: #B89760;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9A7D4C;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="bg-arvaya-50 text-arvaya-900 font-sans antialiased overflow-x-hidden">

    <!-- NAVIGATION -->
    <nav x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'glass shadow-sm py-3' : 'bg-transparent py-6'"
        class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-6 flex justify-between items-center">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-2 group">
                <div
                    class="w-10 h-10 rounded-full border border-arvaya-500 flex items-center justify-center text-arvaya-500 group-hover:bg-arvaya-500 group-hover:text-white transition duration-500">
                    <span class="font-display font-bold text-lg">A</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-serif font-bold text-xl tracking-widest leading-none">ARVAYA</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] text-arvaya-600">de aure</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#features"
                    class="hover:text-arvaya-600 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-px after:bg-arvaya-500 hover:after:w-full after:transition-all">Fitur</a>
                <a href="#themes"
                    class="hover:text-arvaya-600 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-px after:bg-arvaya-500 hover:after:w-full after:transition-all">Tema</a>
                <a href="#testimonials"
                    class="hover:text-arvaya-600 transition relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-px after:bg-arvaya-500 hover:after:w-full after:transition-all">Kata
                    Mereka</a>

                @auth
                    <a href="{{ route('dashboard.index') }}"
                        class="px-6 py-2.5 bg-arvaya-500 text-white rounded-full hover:bg-arvaya-600 transition shadow-lg shadow-arvaya-500/30 hover:shadow-arvaya-500/50 transform hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-arvaya-800 hover:text-arvaya-600 font-semibold">Login</a>
                        <a href="{{ route('register') }}"
                            class="px-6 py-2.5 bg-arvaya-900 text-white rounded-full hover:bg-arvaya-800 transition shadow-lg transform hover:-translate-y-0.5">
                            Buat Undangan
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-2xl text-arvaya-800 focus:outline-none">
                <i class="fa-solid" :class="mobileOpen ? 'fa-times' : 'fa-bars-staggered'"></i>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200 " x-cloak
            x-transition:enter-start="opacity-0 -translate-y-5" x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden absolute top-full left-0 w-full bg-white/95 backdrop-blur-xl border-b border-arvaya-200 shadow-xl py-6 px-6 flex flex-col gap-4 text-center">
            <a href="#features" @click="mobileOpen = false" class="py-2 hover:text-arvaya-600">Fitur</a>
            <a href="#themes" @click="mobileOpen = false" class="py-2 hover:text-arvaya-600">Tema</a>
            @auth
                <a href="{{ route('dashboard.index') }}"
                    class="py-2.5 bg-arvaya-500 text-white rounded-full hover:bg-arvaya-600">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-arvaya-800 hover:text-arvaya-600 font-semibold">Login</a>
                <a href="{{ route('register') }}" class="py-2.5 bg-arvaya-900 text-white rounded-full hover:bg-arvaya-800 ">
                    Buat Undangan
                </a>
            @endauth
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="relative min-h-svh flex items-center justify-center pt-20 overflow-hidden">
        <!-- Abstract Background Blobs -->
        <div
            class="absolute top-0 -left-4 w-96 h-96 bg-arvaya-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-4 w-96 h-96 bg-yellow-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>

        <div class="container mx-auto px-6 relative z-10 grid md:grid-cols-2 gap-12 items-center">

            <!-- Left: Text Content -->
            <div data-aos="fade-right" data-aos-duration="1000">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-arvaya-200 text-arvaya-600 text-xs font-bold uppercase tracking-wider mb-6 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-arvaya-500 animate-pulse"></span>
                    Undangan Digital Next-Gen
                </div>

                <h1 class="font-serif text-5xl md:text-7xl font-bold leading-tight mb-6 text-arvaya-900">
                    Sampaikan Kabar <br>
                    <span class="italic font-normal text-arvaya-500">Bahagia</span> dengan <br>
                    Estetika.
                </h1>

                <p class="text-lg text-gray-600 mb-8 max-w-lg leading-relaxed">
                    Arvaya De Aure hadir buat kamu yang mau undangan digital <i>aesthetic</i>, fitur canggih, tapi tetap
                    sopan & <i>respectful</i> untuk keluarga besar. No ribet, just elegant.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('dashboard.index') }}"
                        class="px-8 py-4 bg-arvaya-900 text-white rounded-full font-medium hover:bg-arvaya-800 transition shadow-xl hover:shadow-2xl text-center transform hover:-translate-y-1">
                        Buat Undangan
                    </a>
                    <a href="#themes"
                        class="px-8 py-4 bg-white border border-arvaya-200 text-arvaya-800 rounded-full font-medium hover:bg-arvaya-50 transition shadow-sm text-center flex items-center justify-center gap-2 group">
                        <i
                            class="fa-solid fa-play text-xs p-2 rounded-full bg-arvaya-100 group-hover:bg-arvaya-500 group-hover:text-white transition"></i>
                        Lihat Contoh
                    </a>
                </div>

                <!-- Social Proof -->
                <div class="mt-10 flex items-center gap-4 text-sm text-gray-500">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1"
                            alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=5"
                            alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=8"
                            alt="">
                    </div>
                    <p>Digunakan oleh <span class="font-bold text-arvaya-800">100+ Pasangan</span> bulan ini.</p>
                </div>
            </div>

            <!-- Right: Visual Mockup (Floating) -->
            <div class="relative hidden md:block" data-aos="fade-left" data-aos-duration="1200">
                <div class="relative z-10 animate-float">
                    <img src="img/hero.png" alt="Mockup Undangan"
                        class="rounded-[2.5rem] max-h-[500px] shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] border-[8px] border-white max-w-sm mx-auto rotate-[-6deg] hover:rotate-0 transition duration-500">
                </div>

                <!-- Decorative Elements behind mockup -->
                <div
                    class="absolute top-10 right-10 bg-white p-4 rounded-xl shadow-lg animate-bounce z-20 max-w-[250px]">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-arvaya-500"></i>
                        <span class="text-xs font-bold">AI Feature</span>
                    </div>
                    <p class="text-[10px] text-gray-500">"Buatkan kata-kata romantis islami..."</p>
                </div>
            </div>
        </div>
    </header>

    <!-- FEATURES SECTION -->
    <section id="features" class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4 text-arvaya-900">Fitur Canggih, <br> <span
                        class="italic text-arvaya-500">Experience</span> Mewah.</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Kami menggabungkan teknologi modern dengan tradisi undangan yang sakral.
                    Hasilnya? Undangan yang bikin tamu terkesan, dan kamu tenang.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1: AI -->
                <div class="group p-8 rounded-3xl bg-white border border-arvaya-100 shadow-sm hover:shadow-xl hover:shadow-arvaya-200/50 transition duration-300"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-3 group-hover:text-arvaya-600 transition">Writer's
                        Block? Lewat.</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Bingung nulis kata mutiara? Fitur <b>AI Assistant</b> kami siap buatin kata-kata puitis, islami,
                        atau casual dalam hitungan detik. <i>Literally magic.</i>
                    </p>
                </div>

                <!-- Card 2: WhatsApp -->
                <div class="group p-8 rounded-3xl bg-white border border-arvaya-100 shadow-sm hover:shadow-xl hover:shadow-arvaya-200/50 transition duration-300"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-3 group-hover:text-arvaya-600 transition">Kirim via WA
                        Personal</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Generate link unik untuk setiap tamu (e.g., <i>to=Bapak Budi</i>). Kirim langsung ke WhatsApp
                        mereka dengan template sopan sekali klik.
                    </p>
                </div>

                <!-- Card 3: Amplop Digital -->
                <div class="group p-8 rounded-3xl bg-white border border-arvaya-100 shadow-sm hover:shadow-xl hover:shadow-arvaya-200/50 transition duration-300"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-14 h-14 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-3 group-hover:text-arvaya-600 transition">Cashless Gift
                        Ready</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Tamu bisa copy nomor rekening atau e-wallet dengan mudah. Solusi praktis buat yang mau kirim
                        tanda kasih tanpa amplop fisik.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- THEMES SHOWCASE (Parallax Feel) -->
    <section id="themes" class="py-24 bg-arvaya-900 text-arvaya-50 overflow-hidden relative">
        <!-- Decoration -->
        <div
            class="absolute top-0 right-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5">
        </div>

        <div class="container mx-auto px-6 relative z-10 grid md:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <span class="text-arvaya-500 font-bold tracking-widest uppercase text-sm mb-2 block">Tema
                    Eksklusif</span>
                <h2 class="font-serif text-4xl md:text-5xl font-bold mb-6">Satu Akun, <br>Beragam <span
                        class="text-arvaya-400 italic">Vibe.</span></h2>
                <p class="text-gray-400 mb-8 text-lg">
                    Mau gaya <i>Rustic</i> yang hangat atau <i>Elegant Gold</i> yang mewah? Ganti tema kapan aja tanpa
                    perlu input data ulang.
                    Semua tema didesain responsive dan <i>mobile-first</i>.
                </p>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-arvaya-500"></i>
                        <span>Musik Latar (YouTube Integration)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-arvaya-500"></i>
                        <span>Galeri Foto & Video</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-arvaya-500"></i>
                        <span>RSVP & Buku Tamu Realtime</span>
                    </li>
                </ul>

                <a href="{{ route('dashboard.index') }}"
                    class="inline-block px-8 py-3 border border-arvaya-500 text-arvaya-500 rounded-full hover:bg-arvaya-500 hover:text-white transition">
                    Coba Tema
                </a>
            </div>

            <!-- Image Stack -->
            <div class="relative" data-aos="zoom-in">
                <img src="img/img1.png"
                    class="rounded-xl shadow-2xl border-4 h-[500px] border-arvaya-800 transform translate-x-10 translate-y-20 rotate-3 opacity-80"
                    alt="Theme 1">
                <img src="img/img2.png"
                    class="rounded-xl shadow-2xl border-4 h-[500px] border-arvaya-500 relative z-10" alt="Theme Main">
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS (Marquee Style) -->
    <section id="testimonials" class="py-24 bg-white overflow-hidden">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-serif text-4xl font-bold text-arvaya-900">Kata Mereka yang <span
                    class="text-arvaya-600">Happy</span></h2>
            <p class="text-gray-500">Real couples, real stories.</p>
        </div>

        <!-- Marquee Container -->
        <div class="relative w-full overflow-hidden">
            <div class="flex animate-marquee gap-8 w-max">
                <!-- Review Card 1 -->
                <div class="w-80 p-6 bg-arvaya-50 rounded-2xl border border-arvaya-100 flex-shrink-0">
                    <div class="flex text-yellow-400 mb-3 text-xs"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-4">"Gila sih, fiturnya lengkap banget! Tamu pada muji
                        undangannya estetik parah. Fitur kirim WA-nya ngebantu banget manage tamu VIP."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <div class="text-xs font-bold text-gray-900">Sarah & Dimas</div>
                    </div>
                </div>
                <!-- Review Card 2 -->
                <div class="w-80 p-6 bg-arvaya-50 rounded-2xl border border-arvaya-100 flex-shrink-0">
                    <div class="flex text-yellow-400 mb-3 text-xs"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-4">"Awalnya ragu bisa bikin sendiri, ternyata gampang banget.
                        AI-nya pinter banget bikin kata-kata sambutan yang sopan buat keluarga."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <div class="text-xs font-bold text-gray-900">Rizky & Amanda</div>
                    </div>
                </div>
                <!-- Review Card 3 -->
                <div class="w-80 p-6 bg-arvaya-50 rounded-2xl border border-arvaya-100 flex-shrink-0">
                    <div class="flex text-yellow-400 mb-3 text-xs"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-4">"The best investment for our wedding! Murah tapi ga murahan.
                        Supportnya juga cepet banget pas nanya soal musik."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <div class="text-xs font-bold text-gray-900">Budi & Citra</div>
                    </div>
                </div>
                <!-- Duplicate for infinite loop effect -->
                <div class="w-80 p-6 bg-arvaya-50 rounded-2xl border border-arvaya-100 flex-shrink-0">
                    <div class="flex text-yellow-400 mb-3 text-xs"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-4">"Gila sih, fiturnya lengkap banget! Tamu pada muji
                        undangannya estetik parah. Fitur kirim WA-nya ngebantu banget manage tamu VIP."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                        <div class="text-xs font-bold text-gray-900">Sarah & Dimas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA FOOTER -->
    <footer class="bg-arvaya-900 text-arvaya-100 pt-20 pb-10">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-serif text-4xl md:text-6xl font-bold mb-6" data-aos="zoom-in">Siap Menebar Kabar Bahagia?
            </h2>
            <p class="text-arvaya-200 mb-10 max-w-xl mx-auto text-lg">
                Jangan biarkan momen spesialmu berlalu biasa saja. Buat undangan yang berkesan selamanya di Arvaya De
                Aure.
            </p>

            <a href="{{ route('dashboard.index') }}"
                class="inline-block px-10 py-4 bg-arvaya-500 text-white rounded-full text-lg font-bold hover:bg-white hover:text-arvaya-900 transition duration-300 shadow-lg shadow-arvaya-500/50 mb-16 animate-bounce">
                Buat Undangan Sekarang
            </a>

            <div
                class="border-t border-arvaya-800 pt-10 flex flex-col md:flex-row justify-between items-center text-sm text-arvaya-400">
                <div class="mb-4 md:mb-0">
                    <span class="font-serif font-bold text-lg text-white">ARVAYA</span> de aure
                </div>
                <div>
                    &copy; {{ date('Y') }} All rights reserved. Made with <i
                        class="fa-solid fa-heart text-red-500"></i> in Indonesia.
                </div>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-white"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#" class="hover:text-white"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- CSS Animation Keyframes for Marquee -->
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 25s linear infinite;
        }

        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    <!-- SCRIPTS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 100,
        });
    </script>
</body>

</html>
