@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    $primaryColor = data_get($theme, 'primary_color', '#9A2A2A');
    $galleryData = $invitation->gallery_data ?? [];
    $defaultCover =
        'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=E8DCCA&color=9A2A2A&size=200&name=';
    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'bride' }} Wedding Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&family=Cutive+Mono&family=Parisienne&family=Special+Elite&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400&family=Kalam:wght@300;400;700&family=Nanum+Pen+Script&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        --font-title: 'Parisienne';
        --font-serif: 'Special Elite', serif;
        --font-sans: 'Cutive Mono', sans-serif;
        --color-primary: #9A2A2A;
        /* Deep Red */
        --color-bg: #FFFBF2;
        /* Cream */
        --color-text: #5C2828;
        /* Dark Red/Brown */
    }

    .font-title {
        font-family: var(--font-title);
    }

    .font-serif {
        font-family: var(--font-serif);
    }

    .font-sans {
        font-family: var(--font-sans);
    }

    .theme-text {
        color: var(--color-primary);
    }

    .theme-bg {
        background-color: var(--color-primary);
    }

    .theme-border {
        border-color: var(--color-primary);
    }

    /* Animasi Loading Kopi */
    @keyframes fillCoffee {
        0% {
            height: 0%;
        }

        100% {
            height: 85%;
        }
    }

    .coffee-liquid {
        animation: fillCoffee 2s ease-in-out forwards;
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN SECTION --}}
{{-- ======================================================================= --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#FFFBF2] flex flex-col items-center justify-center transition-opacity duration-700">

    <!-- Logo Kopi Mengisi -->
    <div class="relative w-24 h-24 mb-6">
        <!-- SVG Coffee Cup Outline -->
        <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-lg" fill="none" stroke="none">
            <!-- Defs untuk Masking Cairan -->
            <defs>
                <clipPath id="cup-mask">
                    <path d="M20,30 Q20,80 50,80 Q80,80 80,30 L80,20 L20,20 Z" />
                </clipPath>
            </defs>

            <!-- Gagang Cangkir (Belakang) -->
            <path d="M80,35 Q95,35 95,50 Q95,65 80,65" stroke="#5C2828" stroke-width="6" fill="none"
                stroke-linecap="round" />

            <!-- Cairan Kopi (Animasi Height) -->
            <g clip-path="url(#cup-mask)">
                <!-- Background Putih (Kosong) -->
                <rect x="0" y="0" width="100" height="100" fill="#E6D9B8" opacity="0.2" />
                <!-- Cairan Gelap (Isi) -->
                <rect id="coffee-fill" x="0" y="0" width="100" height="100" fill="#5C2828"
                    class="translate-y-full transition-transform duration-[2000ms] ease-out" />
            </g>

            <!-- Outline Cangkir Depan -->
            <path d="M20,30 Q20,80 50,80 Q80,80 80,30 L80,20 L20,20 Z" stroke="#5C2828" stroke-width="4"
                fill="none" />

            <!-- Asap (Opsional, animasi fade) -->
            <path d="M40,10 Q40,0 30,5" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.2s" />
            <path d="M50,8 Q50,-2 40,3" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.5s" />
            <path d="M60,10 Q60,0 50,5" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.8s" />
        </svg>
    </div>

    <!-- Container Text / Button -->
    <div class="h-16 flex items-center justify-center">
        <!-- Teks Loading -->
        <p id="loading-text" class="text-[#5C2828] font-serif tracking-widest text-sm animate-pulse">
            Loading The Invitation...
        </p>

        <!-- Tombol Buka Undangan (Hidden Default) -->
        <button id="open-invitation-btn"
            class="hidden transform scale-90 opacity-0 transition-all duration-500 bg-[#5C2828] text-[#FFFBF2] px-8 py-2 rounded-full font-sans font-bold shadow-lg hover:bg-[#7C3838] hover:scale-100 hover:shadow-xl uppercase tracking-wider items-center gap-2">
            <i class="fa-solid fa-envelope-open-text"></i> Buka Undangan
        </button>
    </div>
</div>

<script>
    // Kunci Scroll saat loading
    document.body.style.overflow = 'hidden';

    // Logika Loading
    window.addEventListener('load', function() {
        const fill = document.getElementById('coffee-fill');
        const text = document.getElementById('loading-text');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');

        // 1. Penuhi Cangkir (Trigger CSS Class)
        fill.classList.remove('translate-y-full');
        fill.classList.add('translate-y-[15%]'); // Menyisakan sedikit ruang di atas biar realistis

        // 2. Tunggu sebentar (biar user lihat animasi penuh), lalu ganti teks jadi tombol
        setTimeout(() => {
            text.style.display = 'none';
            btn.classList.remove('hidden');
            // Sedikit delay biar transisi CSS tombol smooth
            setTimeout(() => {
                btn.classList.remove('opacity-0', 'scale-90');
                btn.classList.add('opacity-100', 'scale-100');
            }, 50);
        }, 1200);

        // 3. Event Listener Tombol Buka
        btn.addEventListener('click', function() {
            // Fade out overlay
            overlay.style.opacity = '0';

            // Buka Scroll Body
            document.body.style.overflow = 'auto';

            // Hapus overlay dari DOM setelah transisi selesai
            setTimeout(() => {
                overlay.remove();

                // Trigger Scroll Animation (Sesuai Class ScrollAnimator sebelumnya)
                if (typeof ScrollAnimator !== 'undefined') {
                    // Re-scan elemen jika perlu, atau biarkan IntersectionObserver bekerja
                    // Biasanya otomatis jalan saat elemen masuk viewport
                }

                // Mainkan Musik (Trigger Event Alpine)
                window.dispatchEvent(new CustomEvent('play-music'));

            }, 700);
        });
    });
</script>

{{-- content undangan --}}
<div
    class="text-[#5C2828] bg-white h-svh overflow-x-hidden selection:bg-[#c51e1e] selection:text-white font-sans relative">

    {{-- MUSIC PLAYER (CLEAN VINYL WIDGET) --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 left-6 z-[999] font-sans select-none print:hidden">

            <!-- 1. TOGGLE BUTTON (MUNCUL SAAT DITUTUP) -->
            <button x-show="!isOpen" @click="isOpen = true" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
                class="w-12 h-12 bg-[#FDFBF7] text-[#AA8C49] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-[#AA8C49]/20 flex items-center justify-center hover:scale-110 transition-transform animate-[spin_10s_linear_infinite]">
                <i class="fa-solid fa-compact-disc text-2xl"></i>
            </button>

            <!-- 2. PLAYER WIDGET (DESAIN SEPERTI SCREENSHOT) -->
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-90"
                class="relative w-[280px] bg-[#FDFBF7] rounded-3xl shadow-[0_20px_40px_-10px_rgba(0,0,0,0.2)] border border-white/50 overflow-hidden backdrop-blur-md">

                <!-- Close Button (Pojok Kanan Atas Widget) -->
                <button @click="isOpen = false"
                    class="absolute top-4 right-4 text-gray-400 hover:text-[#AA8C49] z-20 transition">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>

                <!-- Background Gradient Halus -->
                <div
                    class="absolute inset-0 bg-gradient-to-b from-white via-[#FDFBF7] to-[#F3E5AB]/20 pointer-events-none">
                </div>

                <div class="relative z-10 p-6 flex flex-col items-center">

                    <!-- CONTAINER VINYL AREA -->
                    <div class="relative w-[200px] h-[200px] mb-4 flex items-center justify-center">

                        <!-- 1. Tone Arm (Jarum) - Animasi Masuk saat Play -->
                        <div class="absolute top-0 -left-2 w-16 h-24 z-20 origin-top-left transition-transform duration-700 ease-in-out"
                            :class="isPlaying ? 'rotate-[-10deg]' : 'rotate-[23deg]'">
                            <!-- Gambar SVG Jarum Sederhana -->
                            <svg viewBox="0 0 50 100" class="w-full h-full drop-shadow-md">
                                <path d="M5,5 C5,5 15,40 25,80 L35,85" stroke="#999" stroke-width="4" fill="none"
                                    stroke-linecap="round" />
                                <circle cx="5" cy="5" r="5" fill="#CCC" />
                                <rect x="20" y="75" width="20" height="15" fill="#333" rx="2" />
                            </svg>
                        </div>

                        <!-- 2. Piringan Hitam (Vinyl) -->
                        <div class="relative w-full h-full rounded-full shadow-xl bg-[#1a1a1a] flex items-center justify-center border-4 border-white/80"
                            :class="isPlaying ? 'animate-[spin_6s_linear_infinite]' : ''"
                            style="background: repeating-radial-gradient(#111 0, #111 2px, #2a2a2a 3px, #2a2a2a 4px);">

                            <!-- Cover Album Tengah (Besar) -->
                            <div
                                class="w-[55%] h-[55%] rounded-full overflow-hidden border-[3px] border-[#111] relative">
                                <img src="{{ isset($galleryData['cover']) ? asset($galleryData['cover']) : 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=300&q=80' }}"
                                    class="w-full h-full object-cover grayscale-100">
                                <!-- Kilauan Vinyl -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent pointer-events-none rounded-full">
                                </div>
                            </div>
                        </div>

                        <!-- Shadow di bawah vinyl agar terlihat melayang -->
                        <div class="absolute -bottom-4 w-[80%] h-4 bg-black/20 blur-xl rounded-full"></div>
                    </div>

                    <!-- INFO LAGU -->
                    <div class="text-center mb-6 w-full">
                        <!-- Judul (Marquee jika panjang) -->
                        <div class="overflow-hidden w-full whitespace-nowrap">
                            <h3 class="font-serif text-xl font-bold text-[#2C2C2C] truncate">
                                The Wedding
                            </h3>
                        </div>
                        <p class="font-sans text-xs text-[#AA8C49] tracking-widest uppercase mt-1">
                            {{ $groom['nickname'] }} & {{ $bride['nickname'] }}
                        </p>
                    </div>

                    <!-- PROGRESS BAR (VISUAL SAJA) -->
                    <div class="w-full h-1 bg-gray-200 rounded-full mb-6 relative overflow-hidden">
                        <div class="h-full bg-[#AA8C49]"
                            :class="isPlaying ? 'w-full transition-all duration-[200s] ease-linear' : 'w-0'"></div>
                    </div>

                    <!-- CONTROLS -->
                    <div class="flex items-center justify-between w-full px-4 text-[#AA8C49]">
                        <!-- Prev -->
                        <button @click="seek(-10)" class="hover:text-[#8C6E33] transition hover:scale-110">
                            <i class="fa-solid fa-backward-step text-xl"></i>
                        </button>

                        <!-- Play/Pause Button (Besar & Solid seperti screenshot) -->
                        <button @click="togglePlay"
                            class="w-16 h-16 rounded-full flex items-center justify-center shadow-[0_8px_20px_rgba(170,140,73,0.3)] hover:scale-105 transition-all duration-300"
                            :class="isPlaying ? 'bg-[#AA8C49] text-white' : 'bg-[#AA8C49] text-white pl-1'">
                            <i class="fa-solid text-2xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                        </button>

                        <!-- Next -->
                        <button @click="seek(10)" class="hover:text-[#8C6E33] transition hover:scale-110">
                            <i class="fa-solid fa-forward-step text-xl"></i>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Hidden Youtube Container -->
            <div class="absolute opacity-0 pointer-events-none w-0 h-0 overflow-hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>

        {{-- SCRIPT YOUTUBE API --}}
        <script>
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            function youtubePlayer(url) {
                return {
                    isOpen: false,
                    isPlaying: false,
                    player: null,
                    videoId: '',

                    initPlayer() {
                        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
                        const match = url.match(regExp);
                        this.videoId = (match && match[2].length === 11) ? match[2] : null;

                        if (!this.videoId) return;

                        window.onYouTubeIframeAPIReady = () => {
                            this.player = new YT.Player('yt-player-container', {
                                height: '0',
                                width: '0',
                                videoId: this.videoId,
                                playerVars: {
                                    'playsinline': 1,
                                    'controls': 0,
                                    'loop': 1,
                                    'playlist': this.videoId
                                },
                                events: {
                                    'onReady': (event) => {
                                        /* Auto-play logic if needed */ },
                                    'onStateChange': (event) => {
                                        if (event.data === YT.PlayerState.PLAYING) {
                                            this.isPlaying = true;
                                            this.isOpen = true;
                                        } else if (event.data === YT.PlayerState.PAUSED || event.data === YT
                                            .PlayerState.ENDED) {
                                            this.isPlaying = false;
                                        }
                                    }
                                }
                            });
                        };
                    },
                    playMusic() {
                        if (this.player && this.player.playVideo) {
                            this.player.playVideo();
                            this.isPlaying = true;
                            this.isOpen = true;
                        }
                    },
                    togglePlay() {
                        if (!this.player) return;
                        this.isPlaying ? this.player.pauseVideo() : this.player.playVideo();
                    },
                    seek(seconds) {
                        if (!this.player) return;
                        this.player.seekTo(this.player.getCurrentTime() + seconds, true);
                    }
                }
            }
        </script>
    @endif

    {{-- 1. HERO / COVER SECTION --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper.png')]">

        {{-- intro --}}
        <div class="h-full flex flex-col md:items-center">
            <div data-anim="fade-up" class="pt-2 w-[300px] lg:w-[400px] text-xl">
                <div class="tracking-tighter font-semibold flex justify-between border-b border-black/50">
                    <span class="inline-block">Your</span>
                    <span class="inline-block">Presence is Requested</span>
                </div>
                <div class="tracking-tighter font-semibold flex border-b border-black/50">
                    <span class="inline-block w-1/3">TO</span>
                    <span class="inline-block">Celebrate</span>
                </div>
                <div class="tracking-tighter font-semibold flex justify-between border-b border-black/50">
                    <span class="inline-block  pl-5 ">THE</span>
                    <span class="inline-block">wedding of</span>
                </div>
                <div class="tracking-tighter py-3 text-center border-b border-black/50">
                    <h1 class="text-4xl theme-text font-title">{{ $groom['nickname'] ?? 'Groom' }} &
                        {{ $bride['nickname'] ?? 'Bride' }}</h1>
                </div>
                <div class="tracking-tighter text-center font-semibold  border-b border-black/50">
                    <span
                        class="inline-block  pl-5 "><span>{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('d') }}</span>
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        <span>{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('F') }}</span>
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        <span>{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('Y') }}</span>
                </div>
            </div>
            <div data-anim="zoom-in" class="flex justify-end py-10">
                <div class="">
                    <img class="grayscale-100 object-cover max-h-[330px] aspect-[3/4] bg-white/90 px-3 pt-3 pb-10 shadow-xl rounded"
                        src="{{ asset($coverImage) }}" alt="">
                </div>
            </div>
            @if ($guest)
                <div data-anim="fade-up" class="origin-top">
                    <p class="text-[10px] uppercase tracking-wider mb-2">Kepada Yth. Bapak/Ibu/Saudara/i:
                    </p>
                    <h3 class="font-serif font-bold text-2xl md:text-3xl">{{ $guest->name ?? 'Tamu Undangan' }}</h3>
                </div>
            @endif
        </div>
        {{-- intro --}}
    </section>

    {{-- Intro 2 --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div class="lg:max-w-4xl lg:mx-auto lg:text-center" data-anim="fade-up" data-duration="1.5s">
            <i class="fa-solid fa-quote-left text-4xl theme-text opacity-30 mb-4 block"></i>
            <p class="font-serif text-md md:text-2xl text-[#7C6339] mb-4 max-w-3xl mx-auto leading-relaxed">
                "{{ $invitation->couple_data['quote'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya...' }}"
            </p>
            <p class="font-serif text-md md:text-2xl text-[#7C6339] mb-8 max-w-3xl mx-auto leading-relaxed">QS
                AR-RUM : 21</p>
            <div class="w-24 h-1 theme-bg mx-auto rounded-full mb-10"></div>
        </div>
        <div data-anim="fade-up">
            <img class="grayscale-100 mx-auto object-cover max-h-[450px] aspect-[3/4] bg-white/90 px-3 pt-3 pb-10 shadow-xl rounded"
                src="{{ $moments[1] ?? 'https://images.unsplash.com/photo-1546032996-6dfacbacbf3f?q=80&w=712&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
                alt="">
        </div>
    </section>

    {{-- the groom and bride --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div>
            <div data-anim="fade-up"
                class="py-4 mx-auto w-fit px-6 flex justify-center items-center text-center bg-contain p-2 bg-no-repeat bg-[url('/public/img/assets/masking-tape-red.png')]">
                <h1 class="font-serif font-semibold mt-3 text-white/80 mb-8 text-2xl">The Groom and Bride</h1>
            </div>
            {{-- grooms --}}
            <div class="flex p-2 lg:max-w-4xl lg:mx-auto">
                <div data-anim="fade-right" class="w-1/2">
                    <img src="{{ asset($groomImage) }}"
                        class="-rotate-2 grayscale-100 object-cover aspect-[3/4] bg-white/90 p-2 shadow-xl rounded">
                </div>
                <div data-anim="fade-left" class="w-1/2 p-3 font-semibold lg:text-4xl">
                    <h2 class="leading-4 lg:leading-8 mb-2 underline">{{ $groom['fullname'] }}</h2>
                    <p>Putra dari:</p>
                    <p class="leading-4 lg:leading-8 mb-2">Bpk. {{ $groom['father'] }} &</p>
                    <p class="leading-4 lg:leading-8">Ibu {{ $groom['mother'] }}</p>
                </div>
            </div>
            {{-- spacer --}}
            <div data-anim="zoom-in">
                <h1 class="text-center text-6xl lg:text-8xl font-bold">&</h1>
            </div>
            {{-- bride --}}
            <div class="flex p-2 lg:max-w-4xl lg:mx-auto">
                <div data-anim="fade-right" class="w-1/2 p-3 font-semibold lg:text-4xl">
                    <h2 class="leading-4 lg:leading-9 mb-2 underline">{{ $bride['fullname'] }}</h2>
                    <p>Putri dari:</p>
                    <p class="leading-4 lg:leading-9 mb-2">Bpk. {{ $bride['father'] }} &</p>
                    <p class="leading-4 lg:leading-9">Ibu {{ $bride['mother'] }}</p>
                </div>
                <div data-anim="fade-left" class="w-1/2">
                    <img src="{{ asset($brideImage) }}"
                        class="rotate-2 grayscale-100 object-cover aspect-[3/4] bg-white/90 p-2 shadow-xl rounded">
                </div>
            </div>
        </div>
    </section>

    {{-- the invitaition --}}
    <section class="bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div data-anim="fade-up" class="text-center p-8 text-3xl font-semibold mb-6">
            <h1 class="uppercase underline">We Invite You to Join Our Wedding</h1>
        </div>
        <div class="mb-4">
            <div class="relative">
                <img class="mx-auto" src="img/assets/white-notebook.png" alt="">
                <div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
                    <div class="mb-5 font-bold">
                        <div data-anim="fade-up" class="flex justify-between items-center">
                            <p>{{ $invitation->event_data[0]['title'] }}</p>
                        </div>
                    </div>
                    <div data-anim="fade-up"
                        class="text-center text-5xl opacity-75 theme-text font-title font-semibold mb-5">
                        <h1 class="mr-10">{{ $groom['nickname'] }}</h1>
                        <span>&</span>
                        <h1 class="ml-10">{{ $bride['nickname'] }}</h1>
                    </div>
                    <div class="flex font-semibold justify-between gap-4">
                        <p data-anim="fade-up" class="font-serif text-lg text-[#5E4926]">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('F') }}
                        </p>
                        <p data-anim="fade-up" class="font-serif text-lg text-[#5E4926]">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('d') }}
                        </p>
                        <p data-anim="fade-up" class="font-serif ml-4 text-lg text-[#5E4926]">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('Y') }}
                        </p>
                    </div>
                    <div data-anim="fade-up">
                        <p>Waktu:</p>
                        <p class="font-serif text-lg text-[#5E4926]">
                            <span
                                class="font-semibold">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('H:i') }}</span>
                            WIB - Selesai
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="countdown('{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->toIso8601String() }}')" x-init="start()"
            class="flex gap-4 font-semibold justify-center text-center items-center text-xl mb-6">
            <div data-anim="fade-up" data-delay="0.3s" class="p-3 bg-white/60 rounded">
                <p>Hari</p>
                <span class="text-2xl" x-text="days"></span>
            </div>

            <div data-anim="fade-up" data-delay="0.5s" class="p-3 bg-white/60 rounded">
                <p>Jam</p>
                <span class="text-2xl" x-text="hours"></span>
            </div>

            <div data-anim="fade-up" data-delay="0.7s" class="p-3 bg-white/60 rounded">
                <p>Menit</p>
                <span class="text-2xl" x-text="minutes"></span>
            </div>

            <div data-anim="fade-up" data-delay="0.9s" class="p-3 bg-white/60 rounded">
                <p>Detik</p>
                <span class="text-2xl text-red-700" x-text="seconds"></span>
            </div>
        </div>

        <div class="px-4 text-center bg-white/70 py-4" data-anim="fade-up">
            <p class="text-2xl font-semibold">Lokasi Acara:</p>
            <div class="mb-5">
                <p class="font-bold text-[#5E4926] mb-1">{{ $invitation->event_data[0]['location'] }}</p>
                <p class="text-md font-medium leading-relaxed">
                    {{ $invitation->event_data[0]['address'] }}</p>
            </div>
            @if (!empty($invitation->event_data[0]['map_link']))
                <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                    class="inline-block px-8 py-3 bg-[#5E4926] text-white rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#403013] transition shadow-lg theme-btn">
                    <i class="fa-solid fa-location-arrow mr-2"></i> Google Maps
                </a>
            @endif
        </div>
    </section>

    {{-- grooms and bride moments --}}
    @if (!empty($moments))
        <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
            <div data-anim="fade-up">
                <img src="img/assets/quote-note.png" alt="">
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 auto-rows-[250px]"
                data-anim-stagger="0.1">
                @foreach ($moments as $index => $photo)
                    <div data-anim="zoom-in" data-delay=""
                        class="relative group overflow-hidden rounded shadow-md {{ $index % 3 == 0 ? 'md:col-span-2 md:row-span-2 h-full' : '' }}">
                        <img src="{{ asset($photo) }}"
                            class="w-full grayscale-100 h-full p-3 pb-10 bg-white/70 object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 group-hover:bg-black/40 transition"></div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- gift sectioin --}}
    @if (!empty($gifts))
        <section class="p-8 lg:max-w-4xl lg:mx-auto">
            <div data-anim-stagger="0.3">
                <h1 data-anim="fade-up" class="text-3xl font-title text-center py-3">Wedding Gift</h1>
                <p data-anim="fade-up" class="font-semibold text-center py-5 border-y border-yellow-900/60">“Your
                    presence means the world
                    to
                    us. But if you wish to share a gift, we receive it with gratitude and love.”</p>
            </div>
            @foreach ($gifts as $gift)
                <div class="relative w-full max-w-[420px] mx-auto my-6 group perspective-1000" data-anim="flip-up"
                    data-duration="0.8s">

                    <!-- Kartu Container -->
                    <div
                        class="relative h-[240px] w-full rounded-2xl bg-gradient-to-br from-[#005c97] to-[#062c4c] shadow-2xl overflow-hidden text-white transition-transform duration-500 group-hover:-translate-y-2 group-hover:shadow-[0_20px_40px_-10px_rgba(0,47,95,0.5)] border border-[#3e7aa8]/30">

                        <!-- Background Pattern (Abstract Curves) -->
                        <div
                            class="absolute top-[-50%] left-[-20%] w-[500px] h-[500px] rounded-full border-[2px] border-white/5">
                        </div>
                        <div
                            class="absolute top-[-40%] left-[-10%] w-[400px] h-[400px] rounded-full border-[2px] border-white/5">
                        </div>
                        <div
                            class="absolute bottom-[-50%] right-[-20%] w-[400px] h-[400px] rounded-full bg-blue-500/10 blur-3xl">
                        </div>

                        <!-- Content Wrapper -->
                        <div class="relative h-full p-6 flex flex-col justify-between z-10">

                            <!-- Top Section: Bank Logo & Chip -->
                            <div class="flex justify-between items-start">
                                <!-- Bank Logo (Text Simulation) -->
                                <div class="italic font-bold text-2xl tracking-tighter" style="font-family: serif;">
                                    {{ $gift['bank_name'] }}
                                </div>

                                <!-- Type -->
                                <div
                                    class="text-xs font-light tracking-widest opacity-80 border border-white/30 px-2 py-0.5 rounded">
                                    DEBIT
                                </div>
                            </div>

                            <!-- Middle Section: Chip & Contactless -->
                            <div class="flex items-center gap-4 mt-2">
                                <!-- CSS Generated Chip (Gold) -->
                                <div
                                    class="w-12 h-9 rounded bg-gradient-to-br from-[#eebf74] via-[#f8eebb] to-[#bfa05f] relative overflow-hidden shadow-sm border border-[#a68644]">
                                    <div class="absolute top-1/2 left-0 w-full h-[1px] bg-[#8c6e33]/50"></div>
                                    <div class="absolute top-0 left-1/2 h-full w-[1px] bg-[#8c6e33]/50"></div>
                                    <div
                                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-5 h-5 border border-[#8c6e33]/50 rounded-sm">
                                    </div>
                                </div>

                                <!-- Contactless Icon -->
                                <i class="fa-solid fa-wifi rotate-90 text-white/70 text-lg"></i>
                            </div>

                            <!-- Account Number (Card Number Style) -->
                            <div class="mt-4 flex items-center justify-between group/number cursor-pointer"
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('No Rekening Disalin!');"
                                title="Klik untuk menyalin">

                                <div class="font-mono text-2xl md:text-3xl tracking-[0.15em] drop-shadow-md text-gray-100"
                                    style="text-shadow: 2px 2px 2px rgba(0,0,0,0.4);">
                                    {{ chunk_split($gift['account_number'], 4, ' ') }}
                                </div>

                                <!-- Copy Icon (Hidden by default, shows on hover) -->
                                <div class="transition-opacity text-xs bg-white/20 px-2 py-1 rounded backdrop-blur-sm">
                                    <i class="fa-regular fa-copy"></i> SALIN
                                </div>
                            </div>

                            <!-- Bottom Section: Validity & Name -->
                            <div class="flex justify-between items-end mt-auto">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-[0.5rem] leading-tight uppercase text-gray-300 w-8">Valid<br>Thru</span>
                                        <span class="font-mono text-sm">Forever</span>
                                        <!-- Atau kasih tanggal dummy 12/30 -->
                                    </div>
                                    <div
                                        class="font-bold tracking-widest uppercase text-sm md:text-base drop-shadow-sm truncate max-w-[200px]">
                                        {{ $gift['account_name'] }}
                                    </div>
                                </div>

                                <!-- Card Provider Logo (Mastercard/GPN Style) -->
                                <div class="flex flex-col items-end">
                                    <!-- GPN / Mastercard Circles -->
                                    <div class="flex -space-x-3 relative">
                                        <div class="w-8 h-8 rounded-full bg-red-600/90 mix-blend-hard-light"></div>
                                        <div class="w-8 h-8 rounded-full bg-blue-600/90 mix-blend-hard-light"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Glossy Shine Effect -->
                        <div
                            class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/10 via-transparent to-black/20 pointer-events-none">
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    {{-- reservasi --}}
    <div class="shadow-2xl shadow-black/50 bg-[url('/public/img/bg/paper2.png')]">
        <div class="lg:max-w-3xl lg:mx-auto" data-anim="fade-up">
            @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
        </div>

        <div class="flex items-center gap-4 mb-10 justify-center opacity-50">
            <div class="h-px theme-bg w-20"></div>
            <i class="fa-solid fa-heart theme-text"></i>
            <div class="h-px theme-bg w-20"></div>
        </div>

        <div class="bg-white/80 lg:max-w-3xl lg:mx-auto" data-aos="fade-up">
            @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </div>

    <!-- Container Utama (Background Kertas Krem) -->
    <div class="min-h-screen bg-[#FDFBF7] flex justify-center items-center py-10 px-4 font-sans text-[#333]">

        <!-- Wrapper Surat -->
        <div class="w-full max-w-md space-y-8" data-anim="fade-up" data-duration="1s">

            <!-- BAGIAN 1: HEADER (DEAR...) -->
            <div class="text-center px-4">
                <div class="font-['Courier_Prime'] text-lg md:text-xl text-gray-700 leading-relaxed">
                    <div class="flex items-end gap-2 mb-1">
                        <span class="font-bold">Dear</span>
                        <div class="flex-1 border-b border-gray-400"></div>
                    </div>
                    <div class="flex items-end gap-2 mb-1">
                        <div class="w-1/4 border-b border-gray-400"></div>
                        <span>our beloved</span>
                        <div class="w-full border-b border-gray-400"></div>
                    </div>
                    <div class="text-right mt-2 text-sm md:text-base tracking-wider text-gray-800">
                        Family & Friends
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: JUDUL (THANK YOU + LINGKARAN) -->
            <div class="relative py-6 flex justify-center">
                <!-- SVG Lingkaran Spidol (Hand Drawn Circle) -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <svg width="280" height="80" viewBox="0 0 300 100"
                        class="w-[80%] max-w-[300px] h-auto rotate-[-2deg]">
                        <path d="M10,50 Q40,10 150,15 T290,50 Q280,90 150,85 T15,50 M20,45 Q50,15 150,20 T285,50"
                            fill="none" stroke="#2c2c2c" stroke-width="2" stroke-linecap="round"
                            style="filter: drop-shadow(1px 2px 2px rgba(0,0,0,0.1));" />
                    </svg>
                </div>

                <!-- Teks Thank You -->
                <h1 class="font-['Kalam'] text-4xl md:text-5xl text-[#C04A3A] rotate-[-3deg] relative z-10 font-bold tracking-wide"
                    style="text-shadow: 1px 1px 0px rgba(0,0,0,0.1);">
                    Thank You
                </h1>
            </div>

            <!-- BAGIAN 3: KERTAS BERGARIS (NOTEBOOK) -->
            <div
                class="relative bg-[#fcf6ef] shadow-[3px_5px_15px_rgba(0,0,0,0.08)] p-6 pt-12 pb-10 rotate-[1deg] transform transition hover:rotate-0 duration-500">

                <!-- Pattern Garis Kertas (CSS Pure) -->
                <div class="absolute inset-0 w-full h-full pointer-events-none"
                    style="background-image: repeating-linear-gradient(transparent, transparent 31px, #9ca3af 32px); background-position: 0 24px;">
                </div>

                <!-- Garis Merah Vertikal (Margin Kiri) -->
                <div class="absolute top-0 bottom-0 left-12 w-[1px] bg-red-300/60 h-full z-0"></div>

                <!-- Klip Kertas (SVG) -->
                <div class="absolute -top-4 left-6 w-10 text-gray-500 drop-shadow-md z-20">
                    <svg viewBox="0 0 24 50" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round">
                        <path d="M8 10 V35 A 8 8 0 0 0 24 35 V5 A 2 2 0 0 0 20 5 V30 A 4 4 0 0 1 12 30 V8" />
                    </svg>
                </div>

                <!-- Isi Surat -->
                <div
                    class="relative z-10 font-['Nanum_Pen_Script'] text-2xl md:text-3xl text-[#b04030] leading-[32px] pl-10 pr-2">
                    <p class="mb-8">
                        for being part of our lives and supporting us through our journey.
                    </p>
                    <p class="mb-8">
                        We were so blessed to have you celebrate and be a part of our wedding day.
                    </p>
                    <div class="text-right pr-4">
                        See you!
                    </div>

                    <!-- Garis Bawah (Signature Line) -->
                    <div class="mt-4 flex justify-end">
                        <div class="w-32 h-1 bg-gray-600/20 rounded-full skew-x-12"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Container -->
    <footer class="w-full py-12 relative" data-anim="fade-up" data-duration="1s" data-offset="0px">

        <!-- Separator Line (Garis tipis pudar di atas) -->
        <div
            class="absolute top-0 left-1/2 transform -translate-x-1/2 w-24 h-[1px] bg-gradient-to-r from-transparent via-[#D4C5A5] to-transparent">
        </div>

        <!-- Link Wrapper -->
        <a href="https://arvayadeaure.com" target="_blank"
            class="group flex flex-col items-center justify-center gap-3 no-underline cursor-pointer">

            <!-- LOGO CONTAINER -->
            <div class="relative">
                <!-- Lingkaran Dekoratif (Spinning effect saat hover) -->
                <div
                    class="absolute inset-0 rounded-full border border-dashed border-[#D4C5A5] opacity-50 group-hover:rotate-180 transition-transform duration-700 ease-in-out">
                </div>

                <!-- PLACEHOLDER LOGO (Ganti src dengan logo asli Anda) -->
                <!-- Class 'p-1 bg-white' memberi jarak antara foto dan border -->
                <img src="img/favicon/1.png" alt="Arvaya De Aure Logo"
                    class="w-12 h-12 rounded-full object-cover p-1 bg-white shadow-sm relative z-10 group-hover:scale-105 transition-transform duration-300">
            </div>

            <!-- BRAND NAME & TEXT -->
            <div class="text-center">
                <!-- Brand Name -->
                <h3
                    class="font-serif text-[#5E4926] text-sm tracking-[0.2em] uppercase group-hover:text-[#8C6E33] transition-colors duration-300 mb-1">
                    Arvaya De Aure
                </h3>

                <!-- Subtext / Copyright -->
                <p class="font-sans text-[10px] text-[#9A7D4C] tracking-wide opacity-70">
                    Official Website &bull; 2025
                </p>
            </div>
        </a>
    </footer>

</div>

{{-- countdown --}}
<script>
    function countdown(eventDate) {
        return {
            eventTime: new Date(eventDate).getTime(),
            now: Date.now(),
            timer: null,

            start() {
                this.timer = setInterval(() => {
                    this.now = Date.now()
                }, 1000)
            },

            get diff() {
                return Math.max(this.eventTime - this.now, 0)
            },

            get days() {
                return Math.floor(this.diff / (1000 * 60 * 60 * 24))
            },

            get hours() {
                return Math.floor((this.diff / (1000 * 60 * 60)) % 24)
            },

            get minutes() {
                return Math.floor((this.diff / (1000 * 60)) % 60)
            },

            get seconds() {
                return Math.floor((this.diff / 1000) % 60)
            }
        }
    }
</script>
