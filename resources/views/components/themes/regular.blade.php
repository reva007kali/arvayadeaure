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
    $defaultProfile = 'https://ui-avatars.com/api/?background=1a1a1a&color=D4AF37&size=200&name=';

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
    <!-- Fonts: Cinzel (Luxury Serif), Great Vibes (Script), Lato (Readable Body) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Great+Vibes&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        /* DARK ROYAL PALETTE */
        --c-bg-main: #121212;
        /* Deep Black/Charcoal */
        --c-bg-card: #1E1E1E;
        /* Slightly lighter for cards */
        --c-text-main: #E0E0E0;
        /* Soft White for readability */
        --c-text-muted: #A0A0A0;
        /* Light Gray */

        /* LUXURY GOLD */
        --c-gold-dark: #8E6E34;
        --c-gold-main: #D4AF37;
        --c-gold-light: #F9E79F;

        --font-main: 'Cinzel', serif;
        --font-script: 'Great Vibes', cursive;
        --font-body: 'Lato', sans-serif;
    }

    body {
        background-color: var(--c-bg-main);
        color: var(--c-text-main);
        font-family: var(--font-body);
        overflow-x: hidden;
    }

    /* PREMIUM GOLD GRADIENT TEXT */
    .text-gold {
        background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        /* Fallback color if gradient fails */
        color: #D4AF37;
        text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Solid gold color for icons/borders */
    .color-gold {
        color: var(--c-gold-main);
    }

    .border-gold {
        border-color: var(--c-gold-dark);
    }

    /* Subtlest Pattern overlay */
    .bg-pattern {
        background-color: var(--c-bg-main);
        background-image: radial-gradient(#D4AF37 0.5px, transparent 0.5px), radial-gradient(#D4AF37 0.5px, #121212 0.5px);
        background-size: 40px 40px;
        background-position: 0 0, 20px 20px;
        opacity: 1;
    }

    .bg-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.9);
        /* Heavy tint to make background pattern subtle */
        z-index: -1;
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
        background: #D4AF37;
    }

    /* Animations */
    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: floating 4s ease-in-out infinite;
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN --}}
{{-- ======================================================================= --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#050505] flex flex-col items-center justify-center transition-opacity duration-1000">
    <div class="relative w-24 h-24 mb-6">
        <div class="absolute inset-0 border-t-2 border-b-2 border-[#D4AF37] rounded-full animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center text-[#D4AF37] font-main font-bold text-xl">
            {{ substr($groom['nickname'] ?? 'G', 0, 1) }}&{{ substr($bride['nickname'] ?? 'B', 0, 1) }}
        </div>
    </div>
    <p class="text-[#D4AF37] font-main text-xs tracking-[0.4em] uppercase">Loading Invitation</p>

    <button id="open-invitation-btn"
        class="hidden mt-10 px-8 py-3 bg-gradient-to-r from-[#8E6E34] to-[#D4AF37] text-black font-main font-bold uppercase tracking-widest hover:brightness-110 transition shadow-[0_0_20px_rgba(212,175,55,0.4)]">
        Open Invitation
    </button>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function() {
        const btn = document.getElementById('open-invitation-btn');
        setTimeout(() => {
            btn.classList.remove('hidden');
        }, 1000);

        btn.addEventListener('click', function() {
            document.getElementById('loading-overlay').style.opacity = '0';
            document.body.style.overflow = 'auto';
            setTimeout(() => {
                document.getElementById('loading-overlay').remove();
            }, 1000);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>

<div class="relative bg-pattern min-h-screen">
    <div class="bg-overlay"></div> <!-- Darkens the pattern -->

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 right-6 z-[900] print:hidden">
            <button @click="togglePlay"
                class="w-12 h-12 bg-black/50 backdrop-blur-md border border-[#D4AF37] rounded-full flex items-center justify-center text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black transition-all shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-music'"></i>
            </button>
        </div>
    @endif

    {{-- HERO SECTION --}}
    <section
        class="relative min-h-screen w-full flex flex-col justify-center items-center text-center px-4 overflow-hidden">
        <!-- Background Image with Heavy Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $coverImage }}" class="w-full h-full object-cover opacity-60" alt="Cover">
            <!-- Gradient to fade into black at the bottom -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-[#121212]"></div>
        </div>

        <div class="relative z-10 space-y-4" data-anim="fade-up">
            <p class="font-main text-[#D4AF37] uppercase tracking-[0.3em] text-xs md:text-sm animate-float">The Wedding
                Of</p>

            <h1 class="font-main text-5xl md:text-7xl lg:text-8xl text-gold leading-tight py-4 drop-shadow-2xl">
                {{ $groom['nickname'] }} <br>
                <span class="font-script text-4xl md:text-5xl text-white/80 font-normal my-2 block">&</span>
                {{ $bride['nickname'] }}
            </h1>

            <div
                class="inline-flex items-center justify-center gap-6 border-y border-[#D4AF37]/30 py-3 px-8 mt-6 backdrop-blur-sm bg-black/20">
                <span
                    class="text-white font-body tracking-widest text-sm md:text-lg">{{ $eventDate->format('d') }}</span>
                <span class="text-[#D4AF37]">•</span>
                <span
                    class="text-white font-body tracking-widest text-sm md:text-lg uppercase">{{ $eventDate->translatedFormat('F') }}</span>
                <span class="text-[#D4AF37]">•</span>
                <span
                    class="text-white font-body tracking-widest text-sm md:text-lg">{{ $eventDate->format('Y') }}</span>
            </div>

            @if ($guest)
                <div
                    class="mt-16 bg-black/40 backdrop-blur-md border border-[#D4AF37]/30 p-4 rounded-lg inline-block min-w-[280px]">
                    <p class="text-[#A0A0A0] text-xs uppercase tracking-widest mb-2">Honored Guest</p>
                    <h3 class="text-white font-main text-xl md:text-2xl">{{ $guest->name }}</h3>
                </div>
            @endif
        </div>

        <div class="absolute bottom-10 animate-bounce text-[#D4AF37]">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </section>

    {{-- QUOTE SECTION --}}
    <section class="py-20 px-6 bg-[#121212] relative border-b border-[#333]">
        <div class="max-w-3xl mx-auto text-center">
            <div class="text-[#D4AF37] text-4xl mb-6 opacity-80">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
            @if ($qs && ($qs['type'] ?? '') === 'quran')
                <p class="font-main text-2xl leading-relaxed text-[#D4AF37]">{{ $qs['arabic'] ?? '' }}</p>
                <p class="font-body text-md leading-relaxed text-[#E0E0E0] mt-3">{{ $qs['translation'] ?? '' }}</p>
                <p class="font-body text-xs tracking-[0.2em] text-[#A0A0A0] mt-4">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                <p class="font-body text-md leading-relaxed text-[#E0E0E0]">{{ $qs['verse_text'] ?? '' }}</p>
                @if (!empty($qs['translation']))
                    <p class="font-body text-sm leading-relaxed text-[#CFCFCF] mt-3">{{ $qs['translation'] }}</p>
                @endif
                <p class="font-body text-xs tracking-[0.2em] text-[#A0A0A0] mt-4">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                <p class="font-main text-lg md:text-xl leading-loose text-[#E0E0E0] italic">
                    “{{ $qs['quote_text'] ?? '' }}”</p>
                <p class="font-body text-xs tracking-[0.2em] text-[#A0A0A0] mt-4">{{ $qs['source'] ?? 'Unknown' }}</p>
            @else
                <p class="font-main text-lg md:text-xl leading-loose text-[#E0E0E0] italic">
                    "{{ $invitation->couple_data['quote'] ?? '' }}"
                </p>
            @endif
            <div class="mt-8">
                <span class="block w-16 h-[2px] bg-[#D4AF37] mx-auto"></span>
            </div>
        </div>
    </section>

    {{-- COUPLE PROFILE --}}
    <section class="py-24 bg-[#0a0a0a]">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="font-script text-5xl text-center text-[#D4AF37] mb-16" data-anim="fade-up">The Happy Couple</h2>

            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Groom -->
                <div class="flex flex-col items-center md:items-end text-center md:text-right" data-anim="fade-right">
                    <div class="relative w-64 h-80 mb-6 group">
                        <!-- Gold Border Frame -->
                        <div
                            class="absolute -inset-3 border border-[#D4AF37] rounded-tl-[80px] rounded-br-[80px] opacity-60 group-hover:inset-0 transition-all duration-700">
                        </div>
                        <img src="{{ $groomImage }}"
                            class="w-full h-full object-cover rounded-tl-[80px] rounded-br-[80px] shadow-2xl brightness-90 group-hover:brightness-100 transition duration-500"
                            alt="Groom">
                    </div>
                    <h3 class="font-main text-3xl text-gold mb-2">{{ $groom['fullname'] }}</h3>
                    <p class="font-body text-[#D4AF37] text-sm uppercase tracking-widest mb-3">The Groom</p>
                    <p class="font-body text-[#A0A0A0] text-sm">Son of Mr. {{ $groom['father'] }} <br>& Mrs.
                        {{ $groom['mother'] }}</p>
                </div>

                <!-- Bride -->
                <div class="flex flex-col items-center md:items-start text-center md:text-left" data-anim="fade-left">
                    <div class="relative w-64 h-80 mb-6 group">
                        <!-- Gold Border Frame -->
                        <div
                            class="absolute -inset-3 border border-[#D4AF37] rounded-tr-[80px] rounded-bl-[80px] opacity-60 group-hover:inset-0 transition-all duration-700">
                        </div>
                        <img src="{{ $brideImage }}"
                            class="w-full h-full object-cover rounded-tr-[80px] rounded-bl-[80px] shadow-2xl brightness-90 group-hover:brightness-100 transition duration-500"
                            alt="Bride">
                    </div>
                    <h3 class="font-main text-3xl text-gold mb-2">{{ $bride['fullname'] }}</h3>
                    <p class="font-body text-[#D4AF37] text-sm uppercase tracking-widest mb-3">The Bride</p>
                    <p class="font-body text-[#A0A0A0] text-sm">Daughter of Mr. {{ $bride['father'] }} <br>& Mrs.
                        {{ $bride['mother'] }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- EVENT DETAILS (DARK CARD) --}}
    <section class="py-24 relative">
        <div
            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/black-linen.png')] opacity-20">
        </div>

        <div class="max-w-4xl mx-auto px-6 relative z-10">
            <div
                class="bg-[#1E1E1E] border border-[#333] p-8 md:p-14 rounded-sm shadow-[0_0_30px_rgba(0,0,0,0.5)] text-center relative overflow-hidden">
                <!-- Decorative Gold Lines -->
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#8E6E34] via-[#F4E2AB] to-[#8E6E34]">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-[#8E6E34] via-[#F4E2AB] to-[#8E6E34]">
                </div>

                <h2 class="font-main text-3xl md:text-4xl text-white uppercase tracking-[0.2em] mb-10">Save The Date
                </h2>

                <div class="space-y-8">
                    <div>
                        <p class="text-[#D4AF37] font-script text-3xl mb-2">Holy Matrimony & Reception</p>
                        <h3 class="text-white font-main text-xl md:text-2xl">
                            {{ $eventDate->translatedFormat('l, d F Y') }}</h3>
                        <p class="text-[#A0A0A0] mt-2 font-body tracking-widest">{{ $eventDate->format('H:i') }} WIB
                        </p>
                    </div>

                    <div class="w-24 h-[1px] bg-[#333] mx-auto"></div>

                    <div>
                        <p class="text-[#D4AF37] text-sm uppercase tracking-widest mb-3">Venue</p>
                        <p class="text-white font-bold text-lg">{{ $invitation->event_data[0]['location'] }}</p>
                        <p class="text-[#A0A0A0] text-sm mt-1 max-w-md mx-auto">
                            {{ $invitation->event_data[0]['address'] }}</p>
                    </div>

                    @if (!empty($invitation->event_data[0]['map_link']))
                        <div class="pt-6">
                            <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                                class="inline-block px-8 py-3 border border-[#D4AF37] text-[#D4AF37] hover:bg-[#D4AF37] hover:text-black transition-colors duration-300 font-main font-bold uppercase text-sm tracking-widest">
                                Open Map
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Countdown -->
                <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()"
                    class="flex justify-center gap-6 mt-12 border-t border-[#333] pt-8">
                    <div class="text-center">
                        <span class="block text-2xl md:text-3xl text-white font-main" x-text="days">0</span>
                        <span class="text-[10px] text-[#8E6E34] uppercase">Days</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl md:text-3xl text-white font-main" x-text="hours">0</span>
                        <span class="text-[10px] text-[#8E6E34] uppercase">Hrs</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl md:text-3xl text-white font-main" x-text="minutes">0</span>
                        <span class="text-[10px] text-[#8E6E34] uppercase">Min</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl md:text-3xl text-white font-main" x-text="seconds">0</span>
                        <span class="text-[10px] text-[#8E6E34] uppercase">Sec</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY --}}
    @if (!empty($moments))
        <section class="py-24 bg-[#0a0a0a]" x-data="{ photoOpen: false, photoSrc: '' }" @keydown.escape.window="photoOpen = false">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="font-main text-3xl text-center text-gold mb-12 uppercase tracking-widest">Our Gallery</h2>
                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                    @foreach ($moments as $photo)
                        <div class="break-inside-avoid relative group overflow-hidden border border-[#333] rounded-sm cursor-pointer"
                            @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                            <img src="{{ asset($photo) }}"
                                class="w-full grayscale group-hover:grayscale-0 transition-all duration-700"
                                loading="lazy" decoding="async" alt="Gallery moment">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div x-show="photoOpen" x-transition.opacity class="fixed inset-0 z-[9999]">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="photoOpen = false"></div>
                <div class="absolute inset-0 flex items-center justify-center p-4">
                    <div class="relative w-full max-w-6xl">
                        <button @click="photoOpen = false"
                            class="absolute -top-6 right-0 bg-white text-[#222] hover:bg-[#eee] w-10 h-10 rounded-full shadow-md flex items-center justify-center border border-white/70">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img :src="photoSrc" alt="Preview"
                            class="w-full max-h-[85vh] object-contain rounded-xl shadow-2xl border border-white/40 bg-white/5">
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- GIFT SECTION (BLACK CARD STYLE) --}}
    @if (!empty($gifts))
        <section class="py-24 px-6 bg-[#121212] border-t border-[#222]">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-script text-5xl text-[#D4AF37] mb-6">Wedding Gift</h2>
                <p class="text-[#A0A0A0] text-sm mb-12">Your blessing is enough, but if you wish to share love through
                    a gift:</p>

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach ($gifts as $gift)
                        <!-- Premium Black Card Design -->
                        <div
                            class="relative w-full max-w-[340px] h-[200px] bg-gradient-to-br from-[#2a2a2a] to-[#1a1a1a] rounded-xl border border-[#D4AF37]/40 shadow-xl p-6 flex flex-col justify-between text-left group hover:-translate-y-1 transition-transform duration-300">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <i class="fa-brands fa-cc-visa text-6xl text-white"></i>
                            </div>

                            <div class="flex justify-between items-start z-10">
                                <div
                                    class="w-12 h-9 bg-gradient-to-r from-[#D4AF37] to-[#F9E79F] rounded-md shadow-sm">
                                </div>
                                <span
                                    class="font-main font-bold text-white/80 tracking-wider">{{ strtoupper($gift['bank_name']) }}</span>
                            </div>

                            <div class="font-mono text-xl md:text-2xl text-[#D4AF37] tracking-widest drop-shadow-md cursor-pointer z-10"
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied!');">
                                {{ chunk_split($gift['account_number'], 4, ' ') }}
                            </div>

                            <div class="flex justify-between items-end z-10">
                                <div>
                                    <p class="text-[0.6rem] text-[#8E6E34] uppercase tracking-widest">Card Holder</p>
                                    <p class="font-body text-sm text-white uppercase tracking-wider">
                                        {{ $gift['account_name'] }}</p>
                                </div>
                                <button
                                    class="text-[#D4AF37] hover:text-white text-xs uppercase tracking-widest border border-[#D4AF37] px-2 py-1 rounded"
                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}')">
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (!empty($theme['gift_address']))
                    <div class="mt-10 bg-[#0f0f0f] border border-[#333] rounded-xl p-6 shadow-sm max-w-xl mx-auto">
                        <div class="flex items-center gap-2 mb-2 text-[#D4AF37]">
                            <i class="fa-solid fa-gift"></i>
                            <span class="font-main font-bold">Gift Shipping Address</span>
                        </div>
                        <p class="font-body text-sm text-[#CFCFCF] leading-relaxed">{{ $theme['gift_address'] }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- RSVP FORM --}}
    <section class="py-24 px-6 bg-[#0F0F0F]">
        <div class="max-w-2xl mx-auto border border-[#333] bg-[#1a1a1a] p-8 md:p-12 shadow-2xl">
            <h2 class="font-main text-3xl text-center text-gold mb-10 uppercase tracking-widest">RSVP</h2>

            <!-- Dark Mode Form Styling -->
            <div
                class="font-body text-[#E0E0E0]
                [&_input]:bg-[#2a2a2a] [&_input]:border [&_input]:border-[#444] [&_input]:text-white [&_input]:w-full [&_input]:px-4 [&_input]:py-3 [&_input]:rounded-sm [&_input]:focus:border-[#D4AF37] [&_input]:focus:ring-0 [&_input]:outline-none [&_input]:mt-2 [&_input]:mb-4
                [&_select]:bg-[#2a2a2a] [&_select]:border [&_select]:border-[#444] [&_select]:text-white [&_select]:w-full [&_select]:px-4 [&_select]:py-3 [&_select]:rounded-sm [&_select]:focus:border-[#D4AF37] [&_select]:outline-none [&_select]:mt-2 [&_select]:mb-4
                [&_textarea]:bg-[#2a2a2a] [&_textarea]:border [&_textarea]:border-[#444] [&_textarea]:text-white [&_textarea]:w-full [&_textarea]:px-4 [&_textarea]:py-3 [&_textarea]:rounded-sm [&_textarea]:focus:border-[#D4AF37] [&_textarea]:outline-none [&_textarea]:mt-2 [&_textarea]:mb-4
                [&_label]:text-[#D4AF37] [&_label]:text-xs [&_label]:uppercase [&_label]:tracking-widest
                [&_button]:w-full [&_button]:mt-4 [&_button]:py-3 [&_button]:bg-[#D4AF37] [&_button]:text-[#000] [&_button]:font-bold [&_button]:uppercase [&_button]:hover:bg-[#F9E79F] [&_button]:transition">

                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>

            <div class="my-12 text-center">
                <p class="font-script text-3xl text-[#D4AF37]">Wishes</p>
            </div>

            <div
                class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar
                [&_.card]:bg-[#222] [&_.card]:border-l-2 [&_.card]:border-[#D4AF37] [&_.card]:p-4 [&_.card]:rounded-r-md [&_.card]:text-[#ccc]">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>

    {{-- THANK YOU NOTE --}}
    <section class="py-20 bg-[#0a0a0a] border-t border-[#222]">
        <div class="max-w-xl mx-auto px-6" data-anim="fade-up" data-duration="1s">
            <div class="text-center mb-8">
                <p class="font-script text-4xl text-[#D4AF37]">Thank You</p>
            </div>
            <div class="relative bg-[#121212] border border-[#333] shadow-[0_8px_30px_rgba(0,0,0,0.4)] p-8 rounded-xl">
                <div
                    class="absolute top-0 left-0 right-0 h-4 bg-gradient-to-r from-[#0f0f0f] via-[#121212] to-[#0f0f0f] rounded-t-xl">
                </div>
                <p class="font-body text-[#E0E0E0] leading-relaxed">
                    for being part of our lives and supporting us through our journey.
                </p>
                <p class="font-body text-[#E0E0E0] leading-relaxed mt-4">
                    We were so blessed to have you celebrate and be a part of our wedding day.
                </p>
                <div class="text-right mt-6">
                    <span class="font-script text-3xl text-[#D4AF37]">See you!</span>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-12 bg-black text-center border-t border-[#222]">
        <h3 class="font-main text-xl text-[#D4AF37] mb-2 tracking-[0.2em] uppercase">Arvaya De Aure</h3>
        <p class="font-body text-[10px] text-[#555] tracking-widest">Premium Wedding Invitation &copy; 2025</p>
    </footer>
</div>

{{-- SCRIPTS --}}
<script>
    function countdown(eventDate) {
        return {
            eventTime: new Date(eventDate).getTime(),
            now: Date.now(),
            start() {
                setInterval(() => {
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
