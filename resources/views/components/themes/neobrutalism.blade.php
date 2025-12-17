@props(['invitation', 'guest'])

@php
    // Data setup
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];

    // Neo-Brutalism Pop Palette
    $colors = [
        'bg' => '#FFFDF5', // Cream White
        'main' => '#FF6B6B', // Pop Red/Pink
        'accent' => '#4ECDC4', // Teal/Cyan
        'yellow' => '#FFE66D', // Pop Yellow
        'dark' => '#1A1A1A', // Almost Black
    ];

    $galleryData = $invitation->gallery_data ?? [];
    $defaultCover =
        'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=FFE66D&color=1A1A1A&bold=true&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - GETTING HITCHED!</title>

    <!-- Fonts: Lexend Mega (Headlines), Space Mono (Body/Tech), Archivo Black (Big Impact) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Lexend+Mega:wght@300;700&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        --c-bg: #FFFDF5;
        --c-dark: #1A1A1A;
        --c-pink: #FF6B6B;
        --c-blue: #4ECDC4;
        --c-yellow: #FFE66D;

        --f-head: 'Archivo Black', sans-serif;
        --f-sub: 'Lexend Mega', sans-serif;
        --f-mono: 'Space Mono', monospace;

        --brutal-shadow: 4px 4px 0px 0px var(--c-dark);
        --brutal-shadow-hover: 6px 6px 0px 0px var(--c-dark);
        --brutal-border: 3px solid var(--c-dark);
    }

    body {
        font-family: var(--f-mono);
        background-color: var(--c-bg);
        color: var(--c-dark);
    }

    /* Typography Utilities */
    .font-head {
        font-family: var(--f-head);
    }

    .font-sub {
        font-family: var(--f-sub);
    }

    .font-mono {
        font-family: var(--f-mono);
    }

    .theme-bg {
        background: var(--c-pink)
    }

    /* Brutalism Utilities */
    .brutal-box {
        border: var(--brutal-border);
        box-shadow: var(--brutal-shadow);
        background-color: white;
        transition: all 0.2s ease;
    }

    .brutal-box:hover {
        transform: translate(-2px, -2px);
        box-shadow: var(--brutal-shadow-hover);
    }

    .brutal-box:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px var(--c-dark);
    }

    .brutal-btn {
        display: inline-block;
        padding: 12px 24px;
        font-family: var(--f-sub);
        font-weight: bold;
        text-transform: uppercase;
        border: var(--brutal-border);
        box-shadow: var(--brutal-shadow);
        cursor: pointer;
        transition: all 0.2s;
    }

    .brutal-btn:active {
        transform: translate(4px, 4px);
        box-shadow: none;
    }

    .bg-grid-pattern {
        background-image:
            linear-gradient(var(--c-dark) 1px, transparent 1px),
            linear-gradient(90deg, var(--c-dark) 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: center center;
        opacity: 0.05;
    }

    /* Marquee Animation */
    @keyframes marquee {
        0% {
            transform: translateX(0%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .animate-marquee {
        animation: marquee 15s linear infinite;
    }

    /* Glitch Effect on Hover (Optional) */
    .hover-glitch:hover {
        animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
    }

    @keyframes shake {

        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }

        20%,
        80% {
            transform: translate3d(2px, 0, 0);
        }

        30%,
        50%,
        70% {
            transform: translate3d(-4px, 0, 0);
        }

        40%,
        60% {
            transform: translate3d(4px, 0, 0);
        }
    }

    /* Input Reset for Neo Brutalism */
    input,
    textarea,
    select {
        border: var(--brutal-border) !important;
        border-radius: 0 !important;
        background: white !important;
        box-shadow: 2px 2px 0px 0px var(--c-dark) !important;
    }

    input:focus,
    textarea:focus {
        background: var(--c-yellow) !important;
        outline: none !important;
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN (RETRO POPUP) --}}
{{-- ======================================================================= --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#4ECDC4] flex flex-col items-center justify-center transition-all duration-500">

    <!-- Retro Window -->
    <div class="bg-white border-[3px] border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-0 w-[90vw] max-w-[360px]">
        <!-- Title Bar -->
        <div class="bg-[#FF6B6B] border-b-[3px] border-black p-2 flex justify-between items-center">
            <span class="font-bold font-mono text-white text-xs">SYSTEM_BOOT.EXE</span>
            <div class="flex gap-1">
                <div class="w-3 h-3 bg-white border border-black"></div>
                <div class="w-3 h-3 bg-white border border-black"></div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 sm:p-8 flex flex-col items-center">
            <h1 class="font-head text-4xl mb-4 animate-pulse">LOADING</h1>

            <!-- Progress Bar -->
            <div class="w-full h-6 border-[3px] border-black p-1 bg-white relative">
                <div id="progress-fill"
                    class="h-full bg-[#FFE66D] w-0 transition-all duration-[1500ms] border-r-[2px] border-black"></div>
            </div>

            <p id="loading-text" class="font-mono text-xs mt-4 text-center">INITIALIZING LOVE PROTOCOLS...</p>
            <div id="loading-info" class="mt-2 text-center">
                <p class="font-sub text-sm sm:text-base">
                    {{ $invitation->event_data[0]['title'] ?? 'Wedding Invitation' }}</p>
                <p class="font-head text-lg sm:text-xl">{{ $groom['nickname'] ?? 'Groom' }} &
                    {{ $bride['nickname'] ?? 'Bride' }}</p>
            </div>

            <button id="open-invitation-btn" class="hidden mt-6 brutal-btn bg-[#FF6B6B] text-white hover:bg-[#ff5252]">
                ENTER PARTY
            </button>
        </div>
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function() {
        // Fill bar
        document.getElementById('progress-fill').style.width = '100%';

        setTimeout(() => {
            const textEl = document.getElementById('loading-text');
            const infoEl = document.getElementById('loading-info');
            const btnEl = document.getElementById('open-invitation-btn');
            textEl.innerText = "READY TO ROCK!";
            if (infoEl) infoEl.style.display = 'none';
            btnEl.classList.remove('hidden');
        }, 1500);

        document.getElementById('open-invitation-btn').addEventListener('click', function() {
            const overlay = document.getElementById('loading-overlay');
            overlay.style.transform = 'translateY(-100%)'; // Slide up effect
            document.body.style.overflow = 'auto';
            setTimeout(() => {
                overlay.remove();
            }, 500);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>


<div class="relative bg-[#FFFDF5] min-h-screen overflow-x-hidden">

    {{-- MUSIC PLAYER (Retro Cassette Style) --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 right-6 z-50">
            <button @click="togglePlay"
                class="w-14 h-14 bg-[#FF6B6B] border-[3px] border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-center hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                <i class="fa-solid text-white text-xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
            </button>
            <div class="hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>
        <script>
            function youtubePlayer(url) {
                return {
                    isPlaying: false,
                    togglePlay() {
                        this.isPlaying = !this.isPlaying;
                    },
                    playMusic() {
                        this.isPlaying = true;
                    }
                }
            }
        </script>
    @endif

    {{-- 1. HERO SECTION --}}
    <section class="min-h-screen relative flex flex-col pt-10">
        <!-- Background Grid -->
        <div class="absolute inset-0 bg-grid-pattern z-0 pointer-events-none"></div>

        <!-- Marquee Top -->
        <div class="bg-[#FFE66D] border-y-[3px] border-black overflow-hidden py-2 relative z-10 rotate-1 scale-105"
            data-anim="fade-up" data-duration="0.6s">
            <div class="whitespace-nowrap animate-marquee font-head text-2xl text-black">
                JUST MARRIED • SAVE THE DATE • PARTY TIME • NO BORING STUFF • {{ strtoupper($groom['nickname']) }} &
                {{ strtoupper($bride['nickname']) }} •
                JUST MARRIED • SAVE THE DATE • PARTY TIME • NO BORING STUFF • {{ strtoupper($groom['nickname']) }} &
                {{ strtoupper($bride['nickname']) }} •
            </div>
        </div>

        <div class="flex-1 flex flex-col justify-center items-center px-4 relative z-10">
            <!-- Main Title Box -->
            <div class="bg-white border-[4px] border-black shadow-[10px_10px_0px_0px_#4ECDC4] p-6 md:p-12 text-center max-w-2xl transform hover:-rotate-1 transition-transform duration-300"
                data-anim="zoom-in" data-duration="0.8s">
                <p class="font-mono bg-black text-white inline-block px-2 py-1 mb-4 text-sm">OFFICIAL ANNOUNCEMENT</p>

                <h1 class="font-head text-6xl md:text-8xl leading-[0.9] mb-2 text-black">
                    WE ARE<br><span class="text-[#FF6B6B] text-stroke-2">GETTING</span><br>HITCHED!
                </h1>

                <div class="mt-6 flex flex-wrap justify-center gap-4">
                    <div
                        class="bg-[#FFE66D] border-[3px] border-black px-6 py-2 font-bold font-sub shadow-[4px_4px_0px_0px_black]">
                        {{ strtoupper($groom['nickname']) }}
                    </div>
                    <div class="font-head text-4xl">&</div>
                    <div
                        class="bg-[#4ECDC4] border-[3px] border-black px-6 py-2 font-bold font-sub shadow-[4px_4px_0px_0px_black]">
                        {{ strtoupper($bride['nickname']) }}
                    </div>
                </div>

                <div class="mt-8 font-mono font-bold border-t-[3px] border-black pt-4">
                    {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        @if ($guest)
            <div class="py-10 text-center relative z-10">
                <div
                    class="inline-block bg-white border-[3px] border-black shadow-[6px_6px_0px_0px_#FF6B6B] px-8 py-4 rotate-2">
                    <p class="font-mono text-xs mb-1">YO, SPECIAL GUEST:</p>
                    <h3 class="font-head text-2xl">{{ $guest->name }}</h3>
                </div>
            </div>
        @endif
    </section>

    @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
    <section class="px-4 pb-16">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border-[4px] border-black shadow-[10px_10px_0px_0px_#FFE66D] p-6 md:p-10 text-center"
                data-anim="fade-up">
                <i class="fa-solid fa-quote-left text-3xl text-black/40 mb-4 block"></i>
                @if ($qs && ($qs['type'] ?? '') === 'quran')
                    <p class="font-head text-2xl md:text-3xl mb-4">{{ $qs['arabic'] ?? '' }}</p>
                    <p class="font-mono text-base md:text-lg mb-2">{{ $qs['translation'] ?? '' }}</p>
                    <span
                        class="inline-block bg-[#FFE66D] border-[3px] border-black px-3 py-1 font-bold text-xs">{{ $qs['source'] ?? '' }}</span>
                @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                    <p class="font-mono text-base md:text-lg mb-2">{{ $qs['verse_text'] ?? '' }}</p>
                    @if (!empty($qs['translation']))
                        <p class="font-mono text-sm md:text-base mb-2">{{ $qs['translation'] }}</p>
                    @endif
                    <span
                        class="inline-block bg-[#4ECDC4] border-[3px] border-black px-3 py-1 font-bold text-xs">{{ $qs['source'] ?? '' }}</span>
                @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                    <p class="font-head text-2xl md:text-3xl mb-4">“{{ $qs['quote_text'] ?? '' }}”</p>
                    <span
                        class="inline-block bg-[#FF6B6B] text-white border-[3px] border-black px-3 py-1 font-bold text-xs">{{ $qs['source'] ?? 'Unknown' }}</span>
                @else
                    @if (!empty($invitation->couple_data['quote'] ?? ''))
                        <p class="font-head text-2xl md:text-3xl mb-2">“{{ $invitation->couple_data['quote'] }}”</p>
                    @endif
                @endif
            </div>
        </div>
    </section>

    {{-- 2. COUPLE PROFILE ("CHARACTER SELECT" STYLE) --}}
    <section class="py-20 px-4 bg-[#FF6B6B] border-t-[4px] border-black relative overflow-hidden">
        <!-- Decoration Dots -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-black rounded-full mix-blend-overlay opacity-20"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-[#FFE66D] rounded-full border-[3px] border-black z-0">
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            <h2 class="font-head text-5xl text-white text-stroke-black mb-12 text-center drop-shadow-[4px_4px_0px_black]"
                data-anim="fade-up">
                THE PLAYERS</h2>

            <div class="flex flex-col md:flex-row gap-8 justify-center items-stretch">

                {{-- Groom Card --}}
                <div class="brutal-box bg-white p-4 flex-1 max-w-md mx-auto rotate-[-2deg] hover:rotate-0 hover:z-20"
                    data-anim="zoom-in" data-delay="0.1s">
                    <div class="aspect-square bg-gray-200 border-[3px] border-black mb-4 overflow-hidden relative">
                        <img src="{{ asset($groomImage) }}"
                            class="w-full h-full object-cover grayscale contrast-125 hover:grayscale-0 transition-all duration-300">
                        <div
                            class="absolute bottom-0 left-0 bg-[#4ECDC4] border-t-[3px] border-r-[3px] border-black px-3 py-1 font-bold font-sub text-sm">
                            GROOM
                        </div>
                    </div>
                    <h3 class="font-head text-3xl mb-1">{{ $groom['nickname'] }}</h3>
                    <div class="font-mono text-sm border-t-[2px] border-black pt-2 mt-2">
                        <p class="font-bold">SON OF:</p>
                        <p>{{ $groom['father'] }} & {{ $groom['mother'] }}</p>
                    </div>
                    <a href="https://instagram.com/{{ $groom['instagram'] }}"
                        class="mt-4 block bg-black text-white text-center py-2 font-mono hover:bg-[#FFE66D] hover:text-black transition-colors">
                        @ {{ $groom['instagram'] }}
                    </a>
                </div>

                {{-- VS Graphic --}}
                <div class="flex items-center justify-center" data-anim="fade-up" data-delay="0.2s">
                    <div
                        class="bg-black text-white font-head text-5xl p-4 rounded-full border-[3px] border-white animate-bounce">
                        &
                    </div>
                </div>

                {{-- Bride Card --}}
                <div class="brutal-box bg-white p-4 flex-1 max-w-md mx-auto rotate-[2deg] hover:rotate-0 hover:z-20"
                    data-anim="zoom-in" data-delay="0.3s">
                    <div class="aspect-square bg-gray-200 border-[3px] border-black mb-4 overflow-hidden relative">
                        <img src="{{ asset($brideImage) }}"
                            class="w-full h-full object-cover grayscale contrast-125 hover:grayscale-0 transition-all duration-300">
                        <div
                            class="absolute bottom-0 right-0 bg-[#FF6B6B] border-t-[3px] border-l-[3px] border-black px-3 py-1 font-bold font-sub text-sm text-white">
                            BRIDE
                        </div>
                    </div>
                    <h3 class="font-head text-3xl mb-1">{{ $bride['nickname'] }}</h3>
                    <div class="font-mono text-sm border-t-[2px] border-black pt-2 mt-2">
                        <p class="font-bold">DAUGHTER OF:</p>
                        <p>{{ $bride['father'] }} & {{ $bride['mother'] }}</p>
                    </div>
                    <a href="https://instagram.com/{{ $bride['instagram'] }}"
                        class="mt-4 block bg-black text-white text-center py-2 font-mono hover:bg-[#FFE66D] hover:text-black transition-colors">
                        @ {{ $bride['instagram'] }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. EVENT INFO (NOTEBOOK/TERMINAL STYLE) --}}
    <section class="py-20 px-4 bg-[#4ECDC4] border-t-[4px] border-black">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border-[4px] border-black shadow-[12px_12px_0px_0px_#1A1A1A]" data-anim="fade-up">
                <!-- Window Header -->
                <div class="bg-[#FFE66D] border-b-[4px] border-black p-3 flex items-center justify-between">
                    <h2 class="font-head text-2xl">EVENT_DETAILS.TXT</h2>
                    <div class="w-6 h-6 bg-[#FF6B6B] border-[3px] border-black rounded-full"></div>
                </div>

                <div class="p-6 md:p-12 text-center">
                    <h3 class="font-sub text-3xl md:text-5xl mb-6 underline decoration-[6px] decoration-[#FF6B6B]">
                        {{ $invitation->event_data[0]['title'] }}
                    </h3>

                    <!-- Calendar Block -->
                    <div class="inline-flex flex-col bg-white border-[3px] border-black mb-8 shadow-[6px_6px_0px_0px_rgba(0,0,0,0.2)]"
                        data-anim="zoom-in" data-delay="0.1s">
                        <div class="bg-[#FF6B6B] text-white font-head text-xl py-2 px-8 border-b-[3px] border-black">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('F') }}
                        </div>
                        <div class="font-head text-6xl py-4">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('d') }}
                        </div>
                        <div class="bg-black text-white font-mono py-1">
                            {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('l') }}
                        </div>
                    </div>

                    <div class="font-mono text-lg mb-8" data-anim="fade-up" data-delay="0.2s">
                        <p class="bg-[#FFE66D] inline-block px-2 border border-black transform -rotate-1">
                            TIME: {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('H:i') }} WIB -
                            DROPPING BODIES
                        </p>
                        <div class="mt-4">
                            <p class="font-bold text-xl">{{ $invitation->event_data[0]['location'] }}</p>
                            <p class="text-sm max-w-md mx-auto mt-2">{{ $invitation->event_data[0]['address'] }}</p>
                        </div>
                    </div>

                    @if (!empty($invitation->event_data[0]['map_link']))
                        <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                            class="brutal-btn bg-white hover:bg-black hover:text-white">
                            <i class="fa-solid fa-map-pin mr-2"></i> GET DIRECTIONS
                        </a>
                    @endif

                    <!-- Countdown Box -->
                    <div x-data="countdown('{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->toIso8601String() }}')" x-init="start()"
                        class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 border-t-[3px] border-black pt-8"
                        data-anim-stagger="0.1">
                        @foreach (['Days', 'Hours', 'Minutes', 'Seconds'] as $label)
                            <div class="bg-black text-[#4ECDC4] p-2 border-[3px] border-transparent hover:border-[#FF6B6B]"
                                data-anim="fade-up">
                                <span class="block font-head text-3xl" x-text="{{ strtolower($label) }}">0</span>
                                <span class="font-mono text-xs uppercase">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATIC LOVE QUOTE --}}
    <section class="py-16 px-4 bg-white border-t-[4px] border-black relative overflow-hidden">
        <div class="absolute -top-6 left-6 w-16 h-16 bg-[#FFE66D] border-[3px] border-black rounded-full opacity-40">
        </div>
        <div class="absolute -bottom-8 right-10 w-24 h-24 bg-[#4ECDC4] border-[3px] border-black rotate-6 opacity-30">
        </div>
        <div class="max-w-4xl mx-auto">
            <div class="bg-white border-[4px] border-black shadow-[10px_10px_0px_0px_#FF6B6B] p-8 text-center transform -rotate-1"
                data-anim="fade-up">
                <i class="fa-solid fa-heart text-[#FF6B6B] text-2xl mb-3"></i>
                <p class="font-head text-2xl md:text-3xl leading-relaxed">“In you, I’ve found the love of my life and
                    my closest, truest friend.”</p>
                <div
                    class="mt-4 inline-flex items-center gap-2 bg-black text-white px-3 py-1 border-[3px] border-white font-mono text-xs">
                    LOVE QUOTE</div>
            </div>
        </div>
    </section>

    {{-- 4. GALLERY (POLAROID SCATTER) --}}
    @if (!empty($moments))
        <section class="py-20 px-4 bg-white border-t-[4px] border-black overflow-hidden" x-data="{ photoOpen: false, photoSrc: '' }"
            @keydown.escape.window="photoOpen = false">
            <div class="max-w-6xl mx-auto text-center mb-12" data-anim="fade-up">
                <h2
                    class="font-head text-5xl bg-[#FFE66D] inline-block px-4 border-[3px] border-black shadow-[4px_4px_0px_0px_black] transform -rotate-1">
                    EVIDENCE
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-4" data-anim-stagger="0.12">
                @foreach ($moments as $index => $photo)
                    @php $rot = rand(-3, 3); @endphp
                    <div class="bg-white p-3 border-[3px] border-black shadow-[6px_6px_0px_0px_black] transform rotate-[{{ $rot }}deg] hover:rotate-0 hover:scale-105 transition-transform duration-300 cursor-pointer"
                        data-anim="fade-up" @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                        <div
                            class="aspect-[4/5] overflow-hidden border-[2px] border-black grayscale hover:grayscale-0 transition-all">
                            <img src="{{ asset($photo) }}" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-2 text-center font-mono font-bold text-sm">FIG. 0{{ $index + 1 }}</div>
                    </div>
                @endforeach
            </div>

            <div x-show="photoOpen" x-transition.opacity class="fixed inset-0 z-[9999]">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="photoOpen = false"></div>
                <div class="absolute inset-0 flex items-center justify-center p-4">
                    <div class="relative w-full max-w-6xl">
                        <button @click="photoOpen = false"
                            class="absolute -top-6 right-0 bg-white text-black hover:bg-[#FFE66D] w-10 h-10 rounded-full shadow-md flex items-center justify-center border border-black">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img :src="photoSrc"
                            class="w-full max-h-[85vh] object-contain rounded-xl shadow-[10px_10px_0px_0px_black] border-[3px] border-black bg-white">
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- 5. GIFTS (CREDIT CARD POP) --}}
    @if (!empty($gifts))
        <section class="py-20 px-6 bg-[#FFE66D] border-t-[4px] border-black">
            <div class="max-w-3xl mx-auto text-center" data-anim="fade-up">
                <h2 class="font-head text-4xl mb-2">SEND SOME LOVE</h2>
                <p class="font-mono text-sm mb-10 bg.white inline-block border-[2px] border-black px-2">aka MONEY
                    (Optional but cool)</p>

                <div class="flex flex-col gap-6 items-center">
                    @foreach ($gifts as $gift)
                        <!-- Brutal Credit Card -->
                        <div class="relative w-full max-w-[400px] h-[220px] bg-[#FF6B6B] border-[4px] border-black rounded-xl shadow-[8px_8px_0px_0px_black] p-6 text-white overflow-hidden group hover:translate-x-[-4px] hover:translate-y-[-4px] hover:shadow-[12px_12px_0px_0px_black] transition-all"
                            data-anim="flip-up">

                            <!-- Card Decoration -->
                            <div
                                class="absolute top-0 right-0 w-20 h-20 bg-[#4ECDC4] rounded-bl-full border-b-[3px] border-l-[3px] border-black z-0">
                            </div>

                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div class="flex justify-between items-start">
                                    <span class="font-head text-2xl tracking-tighter">{{ $gift['bank_name'] }}</span>
                                    <div
                                        class="w-10 h-10 border-[3px] border-white rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                    </div>
                                </div>

                                <div class="font-mono text-2xl tracking-widest text-shadow-sm cursor-pointer"
                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('COPIED!');">
                                    {{ chunk_split($gift['account_number'], 4, ' ') }}
                                    <i class="fa-regular fa-copy text-sm ml-2 opacity-50"></i>
                                </div>

                                <div class="flex justify-between items-end font-mono text-sm">
                                    <div class="uppercase">{{ $gift['account_name'] }}</div>
                                    <div
                                        class="bg-black text-[#FFE66D] px-2 py-1 text-xs font-bold border border-white">
                                        DEBIT</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (!empty($theme['gift_address']))
                    <div class="mt-10 text-left max-w-xl mx-auto">
                        <div class="bg-white border-[3px] border-black shadow-[6px_6px_0px_0px_black] p-4 transform -rotate-1"
                            data-anim="fade-up">
                            <div class="font-head text-xl mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-gift text-[#FF6B6B]"></i>
                                SHIP A GIFT
                            </div>
                            <p class="font-mono text-sm">{{ $theme['gift_address'] }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- 6. RSVP & FORM --}}
    <section class="py-20 px-4 bg-[#FFFDF5] border-t-[4px] border-black">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white border-[4px] border-black p-6 md:p-10 shadow-[10px_10px_0px_0px_#FF6B6B]"
                data-anim="fade-up">
                <h2 class="font-head text-4xl mb-8 text-center bg-black text-white py-2 transform -rotate-2">ARE YOU
                    COMING?</h2>

                <div class="mb-12">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>

                <div class="border-t-[4px] border-dashed border-black pt-8">
                    <h2 class="font-head text-3xl mb-6 text-center" data-anim="fade-up">DROP A WISH</h2>
                    <div class="bg-[#4ECDC4] p-4 border-[3px] border-black" data-anim="zoom-in">
                        @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-black text-white py-12 border-t-[4px] border-white text-center font-mono">
        <h2 class="font-head text-4xl text-[#FFE66D] mb-4">GAME OVER</h2>
        <p class="text-sm text-gray-400">THANK YOU FOR PLAYING.</p>

        <div class="mt-8">
            <a href="https://arvayadeaure.com"
                class="inline-block border border-white px-4 py-1 hover:bg-white hover:text-black transition-colors text-xs">
                POWERED BY ARVAYA DE AURE
            </a>
        </div>
    </footer>

</div>

{{-- Logic Script --}}
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
