@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    // Fallback Images
    $defaultCover =
        'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=000000&color=D4AF37&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }

    // Date Parsing
    $eventDate = \Carbon\Carbon::parse($invitation->event_data[0]['date']);
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Royal Wedding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Fonts: Cinzel (Luxury Serif), Great Vibes (Elegant Script), Raleway (Clean Sans) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Great+Vibes&family=Raleway:wght@300;400;600&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        --c-black: #050505;
        --c-charcoal: #121212;
        --c-gold-dark: #8E6E34;
        --c-gold-light: #F4E2AB;

        --font-main: 'Cinzel', serif;
        --font-script: 'Great Vibes', cursive;
        --font-body: 'Raleway', sans-serif;
    }

    body {
        background-color: var(--c-black);
        color: #e0e0e0;
        font-family: var(--font-body);
        overflow-x: hidden;
    }

    /* GOLD TEXT GRADIENT (FOIL EFFECT) */
    .text-gold {
        background: linear-gradient(to right, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: 0px 0px 10px rgba(255, 215, 0, 0.2);
    }

    .border-gold {
        border-image: linear-gradient(to right, #bf953f, #fcf6ba, #b38728, #fbf5b7, #aa771c) 1;
    }

    .bg-gold-gradient {
        background: linear-gradient(135deg, #bf953f 0%, #fcf6ba 50%, #aa771c 100%);
    }

    /* SUBTLE NOISE TEXTURE FOR BACKGROUND */
    .bg-noise {
        background-color: var(--c-black);
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
    }

    .font-main {
        font-family: var(--font-main);
    }

    .font-script {
        font-family: var(--font-script);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #000;
    }

    ::-webkit-scrollbar-thumb {
        background: #555;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #8E6E34;
    }

    /* Animations */
    @keyframes shine {
        0% {
            background-position: -200%;
        }

        100% {
            background-position: 200%;
        }
    }

    .gold-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        background-size: 200%;
        animation: shine 3s infinite linear;
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN (ELEGANT MONOGRAM) --}}
{{-- ======================================================================= --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#050505] flex flex-col items-center justify-center transition-opacity duration-1000">

    <!-- Monogram Circle -->
    <div class="relative w-32 h-32 mb-8">
        <div class="absolute inset-0 border border-[#8E6E34] rounded-full opacity-30 animate-ping"></div>
        <div class="absolute inset-2 border border-[#F4E2AB] rounded-full flex items-center justify-center">
            <span class="font-main text-3xl text-[#F4E2AB] font-bold">
                {{ substr($groom['nickname'] ?? 'G', 0, 1) }}&{{ substr($bride['nickname'] ?? 'B', 0, 1) }}
            </span>
        </div>
    </div>

    <!-- Elegant Progress Line -->
    <div class="w-48 h-[1px] bg-[#333] relative overflow-hidden">
        <div id="gold-line"
            class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#bf953f] to-[#fcf6ba] w-0 transition-all duration-[2000ms] ease-out">
        </div>
    </div>

    <p id="loading-text" class="mt-4 text-[#8E6E34] font-main text-xs tracking-[0.3em] uppercase animate-pulse">
        Loading Elegance...
    </p>

    <button id="open-invitation-btn"
        class="hidden mt-8 px-10 py-3 border border-[#8E6E34] text-[#F4E2AB] font-main tracking-widest text-sm hover:bg-[#8E6E34]/20 transition-all duration-500 uppercase">
        Open Invitation
    </button>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function() {
        const line = document.getElementById('gold-line');
        const text = document.getElementById('loading-text');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');

        line.style.width = '100%';

        setTimeout(() => {
            text.style.opacity = '0';
            btn.classList.remove('hidden');
        }, 1500);

        btn.addEventListener('click', function() {
            overlay.style.opacity = '0';
            document.body.style.overflow = 'auto';
            setTimeout(() => {
                overlay.remove();
            }, 1000);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>

<div class="relative bg-noise text-gray-300 selection:bg-[#8E6E34] selection:text-black">

    {{-- MUSIC PLAYER (MINIMAL GOLD DISC) --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-8 left-8 z-[900] print:hidden">

            <button @click="togglePlay" class="group relative w-12 h-12 flex items-center justify-center">
                <!-- Outer Ring (Spinning) -->
                <div class="absolute inset-0 rounded-full border border-[#8E6E34]/50 group-hover:border-[#F4E2AB] transition-colors duration-500"
                    :class="isPlaying ? 'animate-[spin_4s_linear_infinite]' : ''"></div>

                <!-- Inner Dot -->
                <div class="w-3 h-3 bg-[#F4E2AB] rounded-full shadow-[0_0_10px_#F4E2AB]"></div>

                <!-- Icon -->
                <i
                    class="fa-solid fa-music absolute -top-4 -right-4 text-[10px] text-[#8E6E34] opacity-0 group-hover:opacity-100 transition-opacity"></i>
            </button>
            <div class="hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>
    @endif

    {{-- HERO SECTION --}}
    <section
        class="relative h-screen w-full overflow-hidden flex flex-col justify-center items-center text-center px-6">
        <!-- Parallax Background -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $coverImage }}"
                class="w-full h-full object-cover opacity-40 scale-105 animate-[pulse_10s_ease-in-out_infinite]"
                style="animation-duration: 20s;">
            <!-- Dark Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#050505] via-[#050505]/70 to-[#050505]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_0%,#050505_100%)]"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 space-y-6" data-anim="fade-up" data-duration="1.5s">
            <p class="font-body text-[#8E6E34] uppercase tracking-[0.4em] text-xs md:text-sm">The Wedding Of</p>

            <div class="py-4">
                <h1 class="font-main text-5xl md:text-7xl lg:text-8xl text-gold leading-tight">
                    {{ $groom['nickname'] }} <br>
                    <span class="font-script text-4xl md:text-6xl text-white/50 block my-2">&</span>
                    {{ $bride['nickname'] }}
                </h1>
            </div>

            <div
                class="flex items-center justify-center gap-4 text-[#F4E2AB]/80 font-main text-sm md:text-base tracking-widest">
                <span>{{ $eventDate->format('d') }}</span>
                <span class="w-1 h-1 bg-[#8E6E34] rounded-full"></span>
                <span>{{ strtoupper($eventDate->translatedFormat('F')) }}</span>
                <span class="w-1 h-1 bg-[#8E6E34] rounded-full"></span>
                <span>{{ $eventDate->format('Y') }}</span>
            </div>

            @if ($guest)
                <div class="mt-12 pt-8 border-t border-[#8E6E34]/30 w-full max-w-md mx-auto">
                    <p class="font-body text-xs text-gray-500 mb-2 italic">Dear Honored Guest,</p>
                    <h3 class="font-main text-2xl text-white">{{ $guest->name }}</h3>
                </div>
            @endif
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce text-[#8E6E34]">
            <i class="fa-thin fa-chevron-down text-2xl"></i>
        </div>
    </section>

    {{-- QUOTE SECTION --}}
    <section class="py-24 px-6 bg-[#0a0a0a] relative">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[1px] h-20 bg-gradient-to-b from-transparent to-[#8E6E34]">
        </div>

        <div class="max-w-3xl mx-auto text-center relative z-10" data-anim="fade-up">
            <i class="fa-solid fa-quote-left text-4xl text-[#8E6E34]/20 mb-6 block"></i>
            <p class="font-main text-lg md:text-2xl leading-relaxed text-[#dcdcdc] italic">
                "{{ $invitation->couple_data['quote'] ?? 'And of His signs is that He created for you from yourselves mates that you may find tranquillity in them...' }}"
            </p>
            <div class="mt-8 flex items-center justify-center gap-4">
                <div class="h-[1px] w-12 bg-[#8E6E34]"></div>
                <span class="font-body text-xs tracking-widest text-[#8E6E34]">QS AR-RUM : 21</span>
                <div class="h-[1px] w-12 bg-[#8E6E34]"></div>
            </div>
        </div>
    </section>

    {{-- COUPLE PROFILE (DARK VIGNETTE) --}}
    <section class="py-20 bg-[#050505]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">

                <!-- Groom -->
                <div class="text-center md:text-right order-2 md:order-1" data-anim="fade-right">
                    <h2 class="font-main text-4xl text-gold mb-2">{{ $groom['fullname'] }}</h2>
                    <p class="font-body text-sm text-[#8E6E34] uppercase tracking-widest mb-4">The Groom</p>
                    <p class="font-body text-gray-400 text-sm leading-6">
                        Son of Mr. {{ $groom['father'] }} <br> & Mrs. {{ $groom['mother'] }}
                    </p>
                </div>
                <div class="relative group order-1 md:order-2 mx-auto md:mx-0 w-64 h-80 md:w-80 md:h-[450px]"
                    data-anim="zoom-in">
                    <div
                        class="absolute -inset-2 border border-[#8E6E34]/30 rounded-t-[100px] rounded-b-[0px] group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="w-full h-full overflow-hidden rounded-t-[100px] relative">
                        <img src="{{ $groomImage }}"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                </div>

                <!-- Bride -->
                <div class="relative group order-3 mx-auto md:mx-0 w-64 h-80 md:w-80 md:h-[450px]" data-anim="zoom-in">
                    <div
                        class="absolute -inset-2 border border-[#8E6E34]/30 rounded-t-[100px] rounded-b-[0px] group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="w-full h-full overflow-hidden rounded-t-[100px] relative">
                        <img src="{{ $brideImage }}"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-left order-4" data-anim="fade-left">
                    <h2 class="font-main text-4xl text-gold mb-2">{{ $bride['fullname'] }}</h2>
                    <p class="font-body text-sm text-[#8E6E34] uppercase tracking-widest mb-4">The Bride</p>
                    <p class="font-body text-gray-400 text-sm leading-6">
                        Daughter of Mr. {{ $bride['father'] }} <br> & Mrs. {{ $bride['mother'] }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- EVENT DETAILS (GOLDEN TICKET) --}}
    <section class="py-24 relative bg-cover bg-fixed bg-center"
        style="background-image: url('{{ $coverImage }}');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-[#050505]/90 backdrop-blur-sm"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-white">
            <h2 class="font-script text-5xl md:text-6xl text-[#F4E2AB] mb-10" data-anim="fade-up">Save The Date</h2>

            <div class="border border-[#8E6E34]/40 bg-[#0a0a0a]/80 p-8 md:p-12 relative" data-anim="zoom-in">
                <!-- Corner Ornaments -->
                <div class="absolute top-2 left-2 w-4 h-4 border-t border-l border-[#F4E2AB]"></div>
                <div class="absolute top-2 right-2 w-4 h-4 border-t border-r border-[#F4E2AB]"></div>
                <div class="absolute bottom-2 left-2 w-4 h-4 border-b border-l border-[#F4E2AB]"></div>
                <div class="absolute bottom-2 right-2 w-4 h-4 border-b border-r border-[#F4E2AB]"></div>

                <h3 class="font-main text-3xl md:text-4xl uppercase tracking-widest mb-4">
                    {{ $invitation->event_data[0]['title'] }}</h3>

                <div class="flex flex-col md:flex-row justify-center items-center gap-8 my-8 font-main">
                    <div class="text-center">
                        <span class="block text-sm text-[#8E6E34] uppercase tracking-widest">Date</span>
                        <span class="text-2xl">{{ $eventDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="w-[1px] h-10 bg-[#8E6E34] hidden md:block"></div>
                    <div class="text-center">
                        <span class="block text-sm text-[#8E6E34] uppercase tracking-widest">Time</span>
                        <span class="text-2xl">{{ $eventDate->format('H:i') }} WIB</span>
                    </div>
                </div>

                <div class="mb-8">
                    <span class="block text-sm text-[#8E6E34] uppercase tracking-widest mb-2">Venue</span>
                    <p class="font-body text-lg font-bold">{{ $invitation->event_data[0]['location'] }}</p>
                    <p class="font-body text-sm text-gray-400 mt-1">{{ $invitation->event_data[0]['address'] }}</p>
                </div>

                <!-- Gold Button -->
                @if (!empty($invitation->event_data[0]['map_link']))
                    <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                        class="inline-block px-8 py-3 bg-gradient-to-r from-[#8E6E34] to-[#aa771c] text-black font-main font-bold uppercase tracking-wider hover:opacity-90 transition shadow-[0_0_15px_rgba(142,110,52,0.4)]">
                        View Map
                    </a>
                @endif
            </div>

            <!-- Minimal Countdown -->
            <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()"
                class="flex justify-center gap-8 md:gap-16 mt-16 font-main text-[#F4E2AB]">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="days"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#8E6E34]">Days</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="hours"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#8E6E34]">Hours</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="minutes"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#8E6E34]">Mins</div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY (MASONRY WITH GOLD HOVER) --}}
    @if (!empty($moments))
        <section class="py-24 px-4 bg-[#080808]">
            <div class="text-center mb-16" data-anim="fade-up">
                <h2 class="font-main text-4xl text-gold uppercase tracking-widest">Our Moments</h2>
                <div class="w-24 h-[1px] bg-[#8E6E34] mx-auto mt-4"></div>
            </div>

            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4 max-w-7xl mx-auto">
                @foreach ($moments as $index => $photo)
                    <div class="break-inside-avoid relative group overflow-hidden cursor-pointer">
                        <div
                            class="absolute inset-0 border-[1px] border-[#F4E2AB] opacity-0 scale-95 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 z-10">
                        </div>
                        <img src="{{ asset($photo) }}"
                            class="w-full grayscale brightness-75 group-hover:grayscale-0 group-hover:brightness-100 transition-all duration-700">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- GIFT SECTION (BLACK CARD STYLE) --}}
    @if (!empty($gifts))
        <section class="py-24 px-6 bg-[#050505]">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-script text-5xl text-[#F4E2AB] mb-4">Wedding Gift</h2>
                <p class="font-body text-gray-400 mb-12 max-w-lg mx-auto">Your presence is the greatest gift. However,
                    if you wish to honor us with a gift, a digital envelope is available.</p>

                <div class="flex flex-wrap justify-center gap-8">
                    @foreach ($gifts as $gift)
                        <!-- Card Container -->
                        <div class="group relative w-full max-w-[360px] h-[220px] rounded-xl bg-gradient-to-br from-[#1a1a1a] to-[#000] border border-[#333] shadow-2xl p-6 flex flex-col justify-between text-left hover:-translate-y-2 transition-transform duration-500"
                            data-anim="flip-up">

                            <!-- Gold Border Glow on Hover -->
                            <div
                                class="absolute inset-0 rounded-xl border border-[#8E6E34] opacity-0 group-hover:opacity-30 transition duration-500">
                            </div>

                            <!-- Top: Chip & Bank -->
                            <div class="flex justify-between items-start">
                                <div
                                    class="w-10 h-8 bg-gradient-to-br from-[#F4E2AB] to-[#8E6E34] rounded-md relative overflow-hidden">
                                    <div class="absolute top-1/2 w-full h-[1px] bg-black/20"></div>
                                    <div class="absolute left-1/2 h-full w-[1px] bg-black/20"></div>
                                </div>
                                <span
                                    class="font-main font-bold text-gray-400 tracking-wider text-sm">{{ strtoupper($gift['bank_name']) }}</span>
                            </div>

                            <!-- Middle: Number -->
                            <div class="font-main text-2xl text-gold tracking-[0.15em] drop-shadow-md cursor-pointer group-hover:text-white transition-colors"
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied!');">
                                {{ chunk_split($gift['account_number'], 4, ' ') }}
                            </div>

                            <!-- Bottom: Name & Copy -->
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[0.6rem] text-[#8E6E34] uppercase tracking-widest mb-1">Card Holder
                                    </p>
                                    <p class="font-body text-sm text-gray-300 uppercase tracking-wider">
                                        {{ $gift['account_name'] }}</p>
                                </div>
                                <i class="fa-regular fa-clone text-[#8E6E34] cursor-pointer hover:text-white transition"
                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}')"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- RSVP & WISHES (MINIMAL DARK FORM) --}}
    <section class="py-24 px-6 bg-[#0a0a0a]">
        <div class="max-w-2xl mx-auto border border-[#8E6E34]/20 p-8 md:p-12 bg-[#050505]" data-anim="fade-up">
            <h2 class="font-main text-3xl text-center text-gold mb-10 uppercase tracking-widest">RSVP</h2>

            <!-- Form Styles Injection -->
            <div
                class="font-body text-gray-300 
                [&_input]:bg-transparent [&_input]:border-b [&_input]:border-[#333] [&_input]:text-[#F4E2AB] [&_input]:w-full [&_input]:py-3 [&_input]:focus:border-[#8E6E34] [&_input]:outline-none [&_input]:transition-colors
                [&_select]:bg-[#050505] [&_select]:border-b [&_select]:border-[#333] [&_select]:text-[#F4E2AB] [&_select]:w-full [&_select]:py-3 [&_select]:focus:border-[#8E6E34] [&_select]:outline-none
                [&_textarea]:bg-transparent [&_textarea]:border-b [&_textarea]:border-[#333] [&_textarea]:text-[#F4E2AB] [&_textarea]:w-full [&_textarea]:py-3 [&_textarea]:focus:border-[#8E6E34] [&_textarea]:outline-none
                [&_label]:text-[#8E6E34] [&_label]:text-xs [&_label]:uppercase [&_label]:tracking-widest
                [&_button]:w-full [&_button]:mt-6 [&_button]:py-4 [&_button]:bg-[#8E6E34] [&_button]:text-black [&_button]:font-main [&_button]:font-bold [&_button]:uppercase [&_button]:tracking-widest [&_button]:hover:bg-[#aa771c] [&_button]:transition">

                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>

            <div class="my-16 flex items-center gap-4">
                <div class="h-[1px] flex-1 bg-[#333]"></div>
                <div class="font-script text-2xl text-[#8E6E34]">Wishes</div>
                <div class="h-[1px] flex-1 bg-[#333]"></div>
            </div>

            <div
                class="font-body 
                [&_.card]:bg-[#111] [&_.card]:border-l-2 [&_.card]:border-[#8E6E34] [&_.card]:p-4 [&_.card]:mb-4 [&_.card]:rounded-r-md">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 bg-black text-center border-t border-[#8E6E34]/20">
        <h3 class="font-main text-xl text-[#8E6E34] mb-2 tracking-[0.2em] uppercase">Arvaya De Aure</h3>
        <p class="font-body text-[10px] text-gray-600 tracking-widest">Exclusive Wedding Invitation &copy; 2025</p>
    </footer>

</div>

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
