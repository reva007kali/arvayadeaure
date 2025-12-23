@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    // Default Images
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=000000&color=D4AF37&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];

    if (isset($galleryData[0]) && empty($moments)) {
        $moments = $galleryData;
    }

    // Event Data Helper
    $event = $invitation->event_data[0] ?? [];
    $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
@endphp

@slot('head')
<title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Wedding Invitation</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Pinyon+Script&family=Lato:wght@300;400;700&display=swap"
    rel="stylesheet">
@endslot

<style>
    :root {
        --font-title: 'Playfair Display', serif;
        --font-serif: 'Pinyon Script', cursive;
        --font-sans: 'Lato', sans-serif;

        /* THEME: NAVY BLUE & GOLD LUXURY */
        --color-primary: #af953e;
        /* Metallic Gold */
        --color-secondary: #C5A028;
        --color-third: #8A6E1E;
        --color-text: #EAEAEA;
        /* Off-white for readability on Navy */
        --color-bg: #021024;
        /* Deep Midnight Navy */
        --color-bg-light: #051a38;
        /* Slightly lighter Navy for cards */

        --border-primary: #D4AF37;
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

    .bg-theme {
        background-color: var(--color-bg);
    }

    .theme-bg {
        background-color: var(--color-primary);
    }

    /* Luxury Gold Gradient */
    .bg-gold {
        background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
    }

    .border-gold {
        border-color: var(--color-primary);
    }

    /* Enhanced Gold Text for Navy Background */
    .gold-gradient-text {
        background: linear-gradient(to bottom, #FBF5B7 0%, #BF953F 30%, #AA771C 70%, #FBF5B7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0px 1px 4px rgba(0, 0, 0, 0.5);
        filter: drop-shadow(0 0 1px rgba(212, 175, 55, 0.3));
    }

    .shadow-inset {
        box-shadow: inset 0 1px 30px rgba(0, 0, 0, 0.8);
    }

    .rounded-gate {
        border-radius: 100px 100px 0px 0px;
    }

    /* Navy Glass Card */
    .glass-card {
        background: rgba(5, 26, 56, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5);
    }

    .shadow-dark {
        box-shadow: 2px 11px 15px -4px rgba(0, 0, 0, 0.95);
        -webkit-box-shadow: 2px 11px 15px -4px rgba(0, 0, 0, 0.95);
    }

    .shadow-dark-top {
        box-shadow: -1px -2px 19px -2px rgba(0, 0, 0, 0.9);
    }

    /* Input Reset for Navy Theme */
    input,
    textarea,
    select {
        border: 1px solid var(--border-primary) !important;
        outline: none !important;
        border-radius: 8px !important;
        background: #051a38 !important;
        /* Lighter Navy */
        box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.5) !important;
        color: #fff !important;
    }

    input:focus,
    textarea:focus {
        border: 1px solid #FCF6BA !important;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.3) !important;
    }

    label {
        color: var(--color-primary) !important;
    }

    /* Floral decorative corner helper */
    .floral-corner {
        position: absolute;
        width: 150px;
        height: 150px;
        background-image: radial-gradient(circle at center, var(--color-primary) 1px, transparent 1.5px);
        background-size: 10px 10px;
        opacity: 0.2;
        z-index: 1;
        pointer-events: none;
        mask-image: radial-gradient(circle, black 30%, transparent 70%);
    }

    .created-at-text-color {
        color: var(--color-primary) !important;
    }
</style>

<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#021024] flex items-center justify-center transition-opacity duration-700">
    <div class="text-center space-y-5">
        <span class="font-title italic text-xl gold-gradient-text p-7">Wedding Invitation</span>
        <h2 class="font-serif text-3xl gold-gradient-text mt-5">{{ $groom['nickname'] ?? 'Groom' }} &
            {{ $bride['nickname'] ?? 'Bride' }}
        </h2>
        <div class="space-y-1">
            <p class="text-[#D4AF37]/70 font-sans text-sm">Kepada Yang Terhormat:</p>
            <p class="font-sans text-sm text-white/90">{{ $guest->name ?? 'Tamu Undangan' }}</p>
        </div>
        <div class="w-64 mx-auto h-2 bg-[#051a38] rounded-full overflow-hidden border border-[#D4AF37]/50">
            <div id="loading-progress-bar" class="h-full bg-gold" style="width: 0%"></div>
        </div>
        <div id="loading-progress-text" class="text-[10px] text-[#D4AF37] font-bold tracking-widest">0%</div>
        <button id="open-invitation-btn"
            class="mt-2 px-6 py-2 rounded-full bg-gold text-[#021024] font-bold text-xs tracking-wider hover:scale-105 transition-transform"
            style="display:none">Buka Undangan</button>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-fixed bg-contain relative overflow-hidden bg-[#021024]">

    {{-- Dark Navy Overlay --}}
    <div class="absolute top-0 left-0 w-full h-full bg-[#021024] z-0">
        <!-- Optional faint pattern effect -->
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('https://www.transparenttextures.com/patterns/black-scales.png');"></div>
    </div>

    <div
        class="relative min-h-svh font-title lg:max-w-sm mx-auto shadow-2xl shadow-black overflow-hidden bg-[#021024] border-x border-[#D4AF37]/20">

        {{-- 1. COVER SECTION --}}
        <section class="min-h-svh relative p-4 bg-[#021024]">

            {{-- Decorative corners simulating the reference --}}
            <div class="floral-corner top-0 left-0" style="top: -50px; left: -50px;"></div>
            <div class="floral-corner top-0 right-0" style="top: -50px; right: -50px;"></div>

            {{--cover image & overlay --}}
            <img src="{{ $coverImage }}" alt="cover"
                class="absolute top-0 left-0 w-full h-full object-cover z-9 opacity-60 mix-blend-overlay">
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-[#021024] via-[#021024]/60 to-[#021024] z-10">
            </div>

            {{-- cover content --}}
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 flex flex-col items-center justify-between h-3/4 w-full">
                <div>
                    <h1 class="font-title text-2xl text-center text-[#D4AF37]/80 animate-float tracking-[0.2em]"
                        data-anim="fade-down" data-duration="1.5s">THE WEDDING</h1>
                </div>

                <div>
                    <div data-anim="zoom-in" data-duration="1.5s" class="relative">
                        <!-- Border Frame decoration -->
                        <div
                            class="absolute -inset-4 border border-[#D4AF37]/30 rounded-t-full rounded-b-full transform scale-y-110 pointer-events-none">
                        </div>

                        <img src="img/assets/golden-mocking-bird.png" alt=""
                            class="w-10 h-10 mb-1 mx-auto animate-float brightness-150 sepia-0">
                        <h1
                            class="font-serif text-6xl gold-gradient-text text-center py-6 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                            <span class="">{{ $groom['nickname'] ?? 'Groom' }}</span>
                            <div class="text-3xl font-title text-[#D4AF37] my-2">&</div>
                            <span class="">{{ $bride['nickname'] ?? 'Bride' }}</span>
                        </h1>
                        @if($eventDate)
                            <div
                                class="tracking-tighter text-center border-y border-[#D4AF37]/50 py-3 mb-10 bg-[#051a38]/30 backdrop-blur-sm">
                                <span class="inline-block pl-5 text-white/90 font-serif text-lg">
                                    <span>{{ $eventDate->translatedFormat('d') }}</span>
                                    <span class="text-[#D4AF37] mx-2">•</span>
                                    <span>{{ $eventDate->translatedFormat('F') }}</span>
                                    <span class="text-[#D4AF37] mx-2">•</span>
                                    <span>{{ $eventDate->translatedFormat('Y') }}</span>
                                </span>
                            </div>
                        @endif
                        <div class="w-full text-white/80 text-center">
                            <p class="text-[10px] uppercase tracking-wider mb-3 text-[#D4AF37]">Kepada Yth.
                                Bapak/Ibu/Saudara/i:</p>
                            <div
                                class="inline-block px-8 py-3">
                                <h3 class="font-title text-xl text-white">{{ $guest->name ?? 'Tamu Undangan' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- 1. COVER SECTION --}}

        {{-- 2. QUOTE SECTION --}}
        <section class="bg-[#021024] px-6 py-16 shadow-inset relative">
            <div class="absolute top-0 w-full h-20 bg-gradient-to-b from-[#021024] to-transparent z-10"></div>

            <div class="text-center px-5 pt-24 pb-12 border border-[#D4AF37] flex flex-col justify-center rounded-t-full shadow-[0_0_20px_rgba(212,175,55,0.1)] bg-[#051a38]/30 mb-5 relative overflow-hidden"
                data-anim="fade-up" data-duration="1.5s">

                <!-- Decorative lines -->
                <div
                    class="absolute top-10 left-1/2 -translate-x-1/2 w-[1px] h-10 bg-gradient-to-b from-transparent to-[#D4AF37]">
                </div>

                @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
                <i class="fa-solid fa-quote-left text-2xl text-[#D4AF37] opacity-50 mb-6 block"></i>

                @if ($qs && ($qs['type'] ?? '') === 'quran')
                    <p class="font-serif text-2xl gold-gradient-text mb-6 leading-relaxed">{{ $qs['arabic'] ?? '' }}</p>
                    <p class="font-sans text-sm text-white/80 mb-6 leading-relaxed">{{ $qs['translation'] ?? '' }}</p>
                    <p class="font-title text-lg theme-text mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
                @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                    <p class="font-serif text-xl theme-text mb-6 leading-relaxed">{{ $qs['verse_text'] ?? '' }}</p>
                    @if (!empty($qs['translation']))
                        <p class="font-sans text-md text-white/80 mb-6 leading-relaxed italic">{{ $qs['translation'] }}</p>
                    @endif
                    <p class="font-serif text-sm theme-text mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
                @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                    <p class="font-sans text-xl text-[#FBF5B7] mb-6 leading-relaxed tracking-wide">
                        “{{ $qs['quote_text'] ?? '' }}”</p>
                    <p class="font-serif text-sm theme-text mb-8 leading-relaxed">- {{ $qs['source'] ?? 'Unknown' }} -</p>
                @else
                    <p class="font-sans text-xl theme-text mb-8 leading-relaxed">
                        "{{ $invitation->couple_data['quote'] ?? 'The Wedding' }}"</p>
                @endif
                <div class="w-16 h-16 border border-[#D4AF37] rotate-45 mx-auto flex items-center justify-center">
                    <div class="w-12 h-12 border border-[#D4AF37] bg-[#021024]"></div>
                </div>
            </div>
        </section>

        <div class="relative border-y-4 border-[#051a38]">
            <img class="aspect-[3/4] object-cover w-full opacity-80"
                src="{{ isset($moments[0]) ? asset($moments[0]) : asset($coverImage) }}" alt="">
            <div class="absolute w-full bottom-10 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 text-center px-6"
                data-anim="fade-up" data-duration="1.5s">
                <i class="fa-solid fa-heart text-2xl text-[#D4AF37] opacity-80 mb-4 block animate-pulse"></i>
                <p class="font-title text-sm text-white/90 mb-4 leading-relaxed tracking-wider italic">"Cinta bukan
                    tentang menemukan
                    seseorang yang sempurna, tapi belajar melihat kekurangan sebagai keindahan."</p>
                <div class="w-32 h-[1px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto"></div>
            </div>
        </div>
        {{-- 2. QUOTE SECTION --}}


        {{-- 3.COUPLE SECTION --}}
        <section class="bg-[#021024] px-6 py-10 shadow-inset space-y-5 relative overflow-hidden">
            <!-- Background Decoration -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-[#051a38] rounded-full blur-[80px] opacity-30 pointer-events-none">
            </div>

            <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                <div class="flex items-center justify-center gap-4">
                    <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                    <h1 class="font-serif text-3xl gold-gradient-text leading-relaxed">Mempelai Pria</h1>
                    <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                </div>
            </div>

            <div data-anim="zoom-in" data-duration="1.5s" class="relative">
                <img class="w-52 p-1 aspect-[3/4] rounded-gate mx-auto object-cover border border-[#D4AF37] shadow-[0_0_25px_rgba(212,175,55,0.15)] bg-[#051a38]"
                    src="{{ asset($groomImage) }}" alt="">
            </div>

            <div>
                <div data-anim="fade-left" data-duration="1.5s" class="w-full text-center p-3">
                    <h2 class="text-3xl mb-2 gold-gradient-text font-serif">{{ $groom['fullname'] }}</h2>
                    <p class="text-xs text-[#D4AF37] uppercase tracking-widest mb-1">Putra dari:</p>
                    <p class="text-md leading-relaxed mb-2 text-white/80 font-sans">Bpk. {{ $groom['father'] }} <span
                            class="text-[#D4AF37]">&</span> Ibu
                        {{ $groom['mother'] }}
                    </p>
                </div>
            </div>
        </section>

        <section
            class="bg-gradient-to-br from-[#051a38] to-[#021024] px-6 py-10 space-y-5 border-t border-[#D4AF37]/20 relative overflow-hidden">
            <!-- Background Decoration -->
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-[#D4AF37] rounded-full blur-[100px] opacity-10 pointer-events-none">
            </div>

            <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                <div class="flex items-center justify-center gap-4">
                    <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                    <h1 class="font-serif text-3xl gold-gradient-text leading-relaxed">Mempelai Wanita</h1>
                    <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                </div>
            </div>

            <div data-anim="zoom-in" data-duration="1.5s" class="relative">
                <img class="w-52 aspect-[3/4] rounded-gate mx-auto object-cover border border-[#D4AF37] p-1 bg-[#051a38] shadow-[0_0_25px_rgba(212,175,55,0.15)]"
                    src="{{ asset($brideImage) }}" alt="">
            </div>

            <div>
                <div data-anim="fade-left" data-duration="1.5s" class="w-full text-center p-3">
                    <h2 class="text-3xl mb-2 gold-gradient-text font-serif">{{ $bride['fullname'] }}</h2>
                    <p class="text-xs text-[#D4AF37] uppercase tracking-widest mb-1">Putri dari:</p>
                    <p class="text-md leading-relaxed mb-2 text-white/80 font-sans">Bpk. {{ $bride['father'] }} <span
                            class="text-[#D4AF37]">&</span> Ibu
                        {{ $bride['mother'] }}
                    </p>
                </div>
            </div>
        </section>
        {{-- 3.COUPLE SECTION --}}


        {{-- 3.INVITATION SECTION --}}
        @if($invitation->theme_config['events_enabled'] ?? true)
            <section class="min-h-screen bg-[#021024] px-6 py-16 space-y-5 relative">
                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20">
                </div>

                <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-5xl text-center gold-gradient-text leading-relaxed">Acara Pernikahan</h1>
                    <div
                        class="w-32 h-[2px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto rounded-full">
                    </div>
                </div>

                @if(!empty($invitation->event_data) && is_array($invitation->event_data))
                    @foreach($invitation->event_data as $event)
                        @php
                            $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
                        @endphp
                        @if($eventDate)
                            <div class="text-center space-y-6" data-anim="fade-up" data-duration="1.5s">
                                <div
                                    class="bg-gradient-to-br from-[#051a38] via-[#021024] to-[#051a38] p-8 border border-[#D4AF37] shadow-[0_0_20px_rgba(0,0,0,0.5)] rounded-t-full rounded-b-[100px] relative overflow-hidden group">

                                    <div
                                        class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent opacity-50">
                                    </div>

                                    <h2 class="font-title text-3xl gold-gradient-text mb-2 tracking-wide">
                                        {{ $event['title'] ?? 'The Wedding' }}</h2>
                                    <div class="w-12 h-px bg-[#D4AF37] mx-auto my-4"></div>

                                    <div class="space-y-1 mb-8">
                                        <p class="font-serif text-2xl text-white">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
                                        <div class="inline-block px-4 py-1 border border-[#D4AF37]/30 rounded-full mt-2">
                                            <p class="font-sans text-sm text-[#D4AF37]">Pukul {{ $eventDate->format('H:i') }} WIB -
                                                Selesai</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3 mb-8">
                                        <div
                                            class="w-10 h-10 mx-auto border border-[#D4AF37] rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-location-dot text-lg text-[#D4AF37]"></i>
                                        </div>
                                        <p class="font-bold text-white text-lg font-title tracking-wide">
                                            {{ $event['location'] ?? 'Lokasi Belum Ditentukan' }}</p>
                                        <p class="font-sans text-xs text-white/60 max-w-[200px] mx-auto leading-relaxed">
                                            {{ $event['address'] ?? '' }}
                                        </p>
                                    </div>

                                    @if(!empty($event['map_link']))
                                        <a href="{{ $event['map_link'] }}" target="_blank"
                                            class="inline-block px-8 py-3 bg-gradient-to-r from-[#BF953F] to-[#AA771C] text-[#021024] font-bold uppercase tracking-widest text-[10px] hover:text-white transition rounded-full shadow-[0_0_15px_rgba(212,175,55,0.4)] transform hover:-translate-y-1 duration-300">
                                            Open Google Maps
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                   {{-- Countdown --}}
                    @php
                        $firstEvt = $invitation->event_data[0] ?? null;
                        $firstDate = isset($firstEvt['date']) ? \Carbon\Carbon::parse($firstEvt['date']) : null;
                    @endphp
                    @if($firstDate)
                        <div class="mt-12" x-data="countdown('{{ $firstDate->toIso8601String() }}')" x-init="start()">
                            <div class="grid grid-cols-4 gap-2">
                                @foreach(['days', 'hours', 'minutes', 'seconds'] as $time)
                                    <div class="text-center p-3 glass-card rounded-lg border-t-2 border-t-[#BF953F]/50">
                                        <span class="block text-2xl font-serif text-white mb-1" x-text="{{ $time }}">00</span>
                                        <span class="text-[8px] uppercase tracking-widest text-[#BF953F]">{{ $time }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </section>
        @endif
        {{-- 3.INVITATION SECTION --}}

        {{-- 3.5 DRESS CODE SECTION --}}
        @php
            $dressCode = $invitation->dress_code_data ?? [];
            $isDressCodeEnabled = $invitation->hasFeature('dress_code') && ($dressCode['enabled'] ?? false);
        @endphp
        @if($isDressCodeEnabled)
            <section
                class="bg-gradient-to-b from-[#021024] to-[#061836] rounded-t-[50px] px-6 py-16 shadow-[0_-10px_30px_rgba(0,0,0,0.5)] space-y-8 border-t border-[#D4AF37]/20">
                <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-4xl text-center gold-gradient-text leading-relaxed">Dress Code</h1>
                    <div class="w-24 h-[1px] bg-[#D4AF37] mx-auto mt-4"></div>
                </div>

                <div class="text-center max-w-lg mx-auto" data-anim="fade-up" data-duration="1.5s">
                    <div
                        class="bg-[#021024] border border-[#D4AF37]/30 p-8 rounded-b-[20px] shadow-inset relative">
                        <div
                            class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#021024] rounded-full border border-[#D4AF37] p-3 shadow-lg">
                            <i class="fa-solid fa-shirt text-[#D4AF37] text-2xl"></i>
                        </div>

                        <p class="font-title text-xl text-white/90 mb-8 mt-4 leading-relaxed italic">
                            "{{ $dressCode['description'] ?? 'Mohon mengenakan pakaian formal.' }}"
                        </p>

                        @if(!empty($dressCode['colors']))
                            <div class="flex flex-wrap justify-center gap-6 mb-8">
                                @foreach($dressCode['colors'] as $color)
                                    <div class="flex flex-col items-center gap-3 group">
                                        <div class="w-14 h-14 rounded-full border-2 border-[#D4AF37]/60 shadow-[0_0_15px_rgba(212,175,55,0.2)] group-hover:scale-110 transition-transform duration-300"
                                            style="background-color: {{ $color }}"></div>
                                        <span class="text-[10px] text-[#D4AF37]/80 uppercase tracking-widest">{{ $color }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(!empty($dressCode['image']))
                            <div
                                class="mb-8 p-1 bg-[#051a38] border border-[#D4AF37]/40 inline-block transform -rotate-1 hover:rotate-0 transition duration-500 shadow-2xl">
                                <img src="{{ asset($dressCode['image']) }}"
                                    class="max-w-[200px] max-h-[300px] object-cover hover:sepia-[.3] transition duration-500">
                            </div>
                        @endif

                        @if(!empty($dressCode['notes']))
                            <div class="border-t border-[#D4AF37]/20 pt-4 mt-4">
                                <p class="font-sans text-xs text-[#D4AF37]/90">
                                    <span class="font-bold uppercase tracking-widest mr-1 text-[#FBF5B7]">Note:</span>
                                    {{ $dressCode['notes'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
        {{-- 3.5 DRESS CODE SECTION --}}

        {{-- VIDEO --}}
        @php
            $videoEnabled = $invitation->theme_config['video_enabled'] ?? true;
            $videoUrl = $invitation->theme_config['video_url'] ?? '';
            $videoId = $videoUrl ? preg_replace('/.*[?&]v=([^&]+).*/', '$1', $videoUrl) : '';
        @endphp
        @if($videoEnabled && !empty($videoId))
            <div class="pt-10 p-6 bg-[#021024]" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Wedding Film</h1>
                <div class="bg-[#051a38] p-2 rounded-xl border border-[#D4AF37] shadow-[0_0_20px_rgba(212,175,55,0.1)]">
                    <div class="aspect-video rounded-lg overflow-hidden border border-[#D4AF37]/20">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </div>
            </div>
        @endif

        {{-- 4. GALLERY SECTION --}}
        @if (!empty($moments) && ($invitation->gallery_data['enabled'] ?? true))
            <section class="min-h-screen bg-[#051a38] px-6 py-16 space-y-8" x-data="{ photoOpen: false, photoSrc: '' }">
                <div class="relative mb-8" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-5xl text-center gold-gradient-text leading-relaxed">Our Moments</h1>
                    <div class="w-32 h-[2px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto"></div>
                </div>

                <div class="grid grid-cols-2 gap-3 p-2 bg-[#021024] border border-[#D4AF37]/30 rounded-lg">
                    @foreach ($moments as $index => $photo)
                        <div class="relative aspect-[3/4] overflow-hidden border border-[#D4AF37]/50 rounded-sm group cursor-pointer {{ $index % 3 == 0 ? 'col-span-2 aspect-[4/3]' : '' }}"
                            @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'" data-anim="fade-up"
                            data-duration="1.5s">
                            <div
                                class="absolute inset-0 bg-[#021024]/30 group-hover:bg-transparent transition duration-500 z-10">
                            </div>
                            <img src="{{ asset($photo) }}"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition duration-1000">
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox -->
                <div x-show="photoOpen" x-transition.opacity
                    class="fixed inset-0 z-[9999] bg-[#021024]/95 backdrop-blur-md flex items-center justify-center p-4">
                    <button @click="photoOpen = false"
                        class="absolute top-6 right-6 text-[#D4AF37] hover:text-white text-4xl font-serif">&times;</button>
                    <img :src="photoSrc"
                        class="max-w-full max-h-[85vh] border-4 border-[#D4AF37] shadow-[0_0_50px_rgba(212,175,55,0.4)] rounded-sm">
                </div>
            </section>
        @endif
        {{-- 4. GALLERY SECTION --}}

        {{-- 5. RSVP & GIFTS --}}
        @php
            $hasRsvp = $invitation->hasFeature('rsvp');
            $hasGuestbook = $invitation->hasFeature('guestbook');
            $gifts = $invitation->gifts_data ?? [];
            $hasGifts = $invitation->theme_config['gifts_enabled'] ?? true;
        @endphp

        @if($hasRsvp || $hasGifts)
            <section class="bg-[#021024] px-6 py-16 shadow-dark-top space-y-10 relative">
                <div
                    class="absolute top-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent opacity-50">
                </div>

                {{-- GIFTS --}}
                @if($hasGifts && !empty($gifts))
                    <div class="text-center" data-anim="fade-up" data-duration="1.5s">
                        <h1 class="font-serif text-4xl gold-gradient-text mb-6">Wedding Gift</h1>
                        <p class="font-sans text-xs text-white/70 mb-8 leading-relaxed max-w-xs mx-auto">Tanpa mengurangi rasa
                            hormat, bagi anda
                            yang ingin memberikan tanda kasih, dapat melalui:</p>

                        <div class="space-y-6">
                            @foreach ($gifts as $gift)
                                <div class="relative w-full max-w-[340px] mx-auto aspect-[1.58/1] rounded-2xl overflow-hidden shadow-[0_10px_30px_-5px_rgba(0,0,0,0.8)] transform transition duration-500 hover:scale-[1.02] group"
                                    data-anim="zoom-in" data-duration="1.5s">

                                    <!-- Card Background Navy -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-[#0a2347] via-[#021024] to-[#051a38]"></div>

                                    <div
                                        class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] mix-blend-overlay">
                                    </div>

                                    <div
                                        class="absolute -top-[100%] -left-[100%] w-[300%] h-[300%] bg-gradient-to-br from-transparent via-[#BF953F]/20 to-transparent rotate-45 pointer-events-none group-hover:translate-x-10 group-hover:translate-y-10 transition-transform duration-1000">
                                    </div>

                                    <div class="absolute inset-0 border border-[#D4AF37]/40 rounded-2xl z-20"></div>

                                    <div class="relative z-10 h-full p-6 flex flex-col justify-between">

                                        <div class="flex justify-between items-start">
                                            <div
                                                class="w-12 h-9 rounded-md bg-gradient-to-br from-[#FFE5B4] via-[#BF953F] to-[#7d5d18] border border-black/20 shadow-inner flex items-center justify-center overflow-hidden relative">
                                                <div class="absolute w-full h-[1px] bg-black/30 top-1/3"></div>
                                                <div class="absolute w-full h-[1px] bg-black/30 bottom-1/3"></div>
                                                <div class="absolute h-full w-[1px] bg-black/30 left-1/3"></div>
                                                <div class="absolute h-full w-[1px] bg-black/30 right-1/3"></div>
                                                <div class="w-5 h-4 border border-black/30 rounded-[2px] bg-yellow-600/50"></div>
                                            </div>

                                            <div class="text-right">
                                                <i class="fa-solid fa-wifi rotate-90 text-[#D4AF37]/50 text-lg mb-1 block"></i>
                                                <span
                                                    class="font-bold text-[#FBF5B7] uppercase tracking-widest text-sm drop-shadow-md">
                                                    {{ $gift['bank_name'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span
                                                class="font-mono text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-b from-white via-[#FBF5B7] to-[#BF953F] tracking-[0.15em] drop-shadow-[1px_2px_2px_rgba(0,0,0,0.8)] w-full text-center">
                                                {{ $gift['account_number'] }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-end">
                                            <div>
                                                <p class="text-[7px] text-[#D4AF37] uppercase tracking-[0.2em] mb-1 opacity-80">Card
                                                    Holder</p>
                                                <p
                                                    class="font-sans text-left font-bold text-white uppercase tracking-widest text-xs drop-shadow-md">
                                                    {{ $gift['account_name'] }}
                                                </p>
                                            </div>

                                            <div class="flex flex-col items-end gap-2">
                                                <button
                                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Nomor Rekening Tersalin!')"
                                                    class="group/btn flex items-center gap-2 bg-[#D4AF37] hover:bg-white border border-[#D4AF37] px-4 py-1.5 rounded-full transition-all duration-300 shadow-[0_0_10px_rgba(212,175,55,0.3)]">
                                                    <span
                                                        class="text-[9px] uppercase tracking-widest text-[#021024] font-bold">Copy</span>
                                                    <i class="fa-regular fa-copy text-[#021024] text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (!empty($theme['gift_address']))
                            <div class="mt-8 bg-[#051a38] border border-[#D4AF37]/30 text-center rounded-2xl p-6 shadow-lg max-w-sm mx-auto"
                                data-anim="fade-up" data-duration="1.5s">
                                <div class="flex justify-center items-center gap-2 mb-2 theme-text">
                                    <i class="fa-solid fa-gift text-[#D4AF37]"></i>
                                    <span class="font-title font-bold text-[#D4AF37]">Alamat Pengiriman Kado</span>
                                </div>
                                <p class="text-sm text-white/80 leading-relaxed font-sans">{{ $theme['gift_address'] }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </section>
        @endif
        {{-- 5. RSVP & GIFTS --}}


        {{-- RSVP FORM --}}
        @if($hasRsvp)
            <div class="pt-10 p-6 rounded-lg bg-[#021024]" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Konfirmasi Kehadiran</h1>

                <div class="p-6 rounded-2xl border border-[#D4AF37] shadow-[0_0_30px_rgba(5,26,56,1)] bg-[#051a38]">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        @endif



        {{-- WISHES --}}
        @if($hasGuestbook)
            <div class="pt-10 p-6 bg-[#021024]" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Ucapan & Doa</h1>
                <div
                    class="bg-[#051a38] p-4 rounded-2xl border border-[#D4AF37] shadow-inner">
                    @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        @endif

        {{-- 5. THANK YOU MESSAGE --}}
        <section class="relative py-24 px-6 bg-[#010a18] overflow-hidden border-t border-[#D4AF37]/20"
            data-anim="fade-up" data-duration="1.5s">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-[#D4AF37] blur-[120px] rounded-full pointer-events-none opacity-20">
            </div>

            <div class="relative z-10 max-w-2xl mx-auto text-center">
                <div class="mb-6 flex justify-center opacity-100">
                    <img src="img/assets/golden-mocking-bird.png" class="w-16 animate-float">
                </div>

                <h2 class="font-serif text-3xl md:text-5xl font-bold mb-8 tracking-wide">
                    <span
                        class="bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#B38728] bg-clip-text text-transparent drop-shadow-md">
                        Terima Kasih
                    </span>
                </h2>

                <p class="font-sans text-sm md:text-base text-[#D4AF37]/80 leading-loose italic mb-10 px-4">
                    "{{ $invitation->theme_config['thank_you_message'] ?? 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kami.' }}"
                </p>

                <div class="w-24 h-[1px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent mx-auto mb-10">
                </div>

                <h2 class="font-serif text-4xl gold-gradient-text mb-2">{{ $groom['nickname'] }} <span
                        class="text-2xl font-title text-white">&</span>
                    {{ $bride['nickname'] }}
                </h2>

                <p class="text-white/30 text-xs tracking-[0.5em] mt-8 uppercase">Keluarga Besar</p>
            </div>
        </section>
        {{-- 5. THANK YOU MESSAGE --}}

        {{-- 6. FOOTER --}}
        <footer class="bg-[#021024] py-8 text-center border-t border-[#D4AF37]/30">
            <a href="https://arvaya.id" target="_blank"
                class="font-sans text-[10px] text-[#D4AF37]/60 uppercase tracking-[0.3em] hover:text-[#D4AF37] transition">Powered
                By Arvaya.id</a>
        </footer>
        {{-- 6. FOOTER --}}
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function () {
        var btn = document.getElementById('open-invitation-btn');
        var overlay = document.getElementById('loading-overlay');
        var bar = document.getElementById('loading-progress-bar');
        var txt = document.getElementById('loading-progress-text');
        var p = 0;
        var interval = setInterval(function () {
            p = Math.min(p + 2, 100);
            if (bar) bar.style.width = p + '%';
            if (txt) txt.textContent = p + '%';
            if (p >= 100) {
                clearInterval(interval);
                if (btn) btn.style.display = 'inline-block';
            }
        }, 40);
        if (btn) {
            btn.addEventListener('click', function () {
                if (overlay) overlay.classList.add('opacity-0');
                document.body.style.overflow = 'auto';
                setTimeout(function () { if (overlay) overlay.style.display = 'none'; }, 700);
            });
        }
    });
</script>

{{-- MUSIC PLAYER --}}
@if (!empty($theme['music_url']))
    <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
        class="fixed bottom-6 z-[990] pointer-events-none w-full max-w-sm mx-auto left-0 right-0 flex justify-end px-6 print:hidden">
        <button @click="togglePlay"
            class="w-10 h-10 bg-[#D4AF37] rounded-full flex items-center justify-center pointer-events-auto border-2 border-[#051a38] shadow-lg">
            <i class="fa-solid text-[#021024] text-xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
        </button>
        <div class="hidden">
            <div id="yt-player-container"></div>
        </div>
    </div>
@endif




<script>
    function countdown(date) {
        return {
            target: new Date(date).getTime(),
            now: new Date().getTime(),
            days: 0, hours: 0, minutes: 0, seconds: 0,
            start() {
                setInterval(() => {
                    this.now = new Date().getTime();
                    const d = this.target - this.now;
                    if (d > 0) {
                        this.days = Math.floor(d / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((d % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((d % (1000 * 60)) / 1000);
                    }
                }, 1000);
            }
        }
    }
</script>
