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
        --color-primary: #9f7f3b;
        --color-secondary: #A38E5C;
        --color-third: #735b0a;
        --color-text: #5C2828;
        --color-bg: #151515;

        --border-primary: #9f7f3b;

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
        background-color: var(--color-primary);
    }

    .theme-bg {
        background-color: var(--color-primary);
    }

    .bg-gold {
        background: linear-gradient(to right, #BF953F, #eee689, #B38728, #FBF5B7, #AA771C);
    }

    .border-gold {
        border-color: var(--color-primary);
    }

    .gold-gradient-text {
        background: linear-gradient(to bottom, #cfc09f 0%, #ffecb3 20%, #c4a04d 50%, #7c5c16 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .shadow-inset {
        box-shadow: inset 0 1px 20px rgba(0, 0, 0, 0.529);
    }

    .rounded-gate {
        border-radius: 100px 100px 0px 0px;
    }

    .glass-card {
        background: rgba(20, 20, 20, 0.6);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(191, 149, 63, 0.3);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .shadow-dark {
        box-shadow: 2px 11px 15px -4px rgba(0, 0, 0, 0.89);
        -webkit-box-shadow: 2px 11px 15px -4px rgba(0, 0, 0, 0.89);
        -moz-box-shadow: 2px 11px 15px -4px rgba(0, 0, 0, 0.89);
    }

    .shadow-dark-top {
        box-shadow: -1px -2px 19px -2px rgba(0, 0, 0, 0.83);
        -webkit-box-shadow: -1px -2px 19px -2px rgba(0, 0, 0, 0.83);
        -moz-box-shadow: -1px -2px 19px -2px rgba(0, 0, 0, 0.83);
    }

    /* Input Reset for Neo Brutalism */
    input,
    textarea,
    select {
        border: var(--border-primary) !important;
        outline: var(--border-primary) !important;
        border-radius: 10px !important;
        background: rgb(37, 37, 37) !important;
        box-shadow: 2px 2px 0px 0px var(--c-dark) !important;
        color: #fff !important;
    }

    input:focus,
    textarea:focus {
        /* background: rgba(0, 0, 0, 0.707) !important; */
        border: var(--border-primary) !important;
        outline: var(--border-primary) !important;
    }

    label {
        color: var(--color-primary) !important;
    }

    .created-at-text-color {
        color: var(--color-primary) !important;
    }
</style>

<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#151515] flex items-center justify-center transition-opacity duration-700">
    <div class="text-center space-y-5">
        <span class="font-title italic text-xl gold-gradient-text p-7">Wedding Invitation</span>
        <h2 class="font-serif text-3xl gold-gradient-text mt-5">{{ $groom['nickname'] ?? 'Groom' }} &
            {{ $bride['nickname'] ?? 'Bride' }}
        </h2>
        <div class="space-y-1">
            <p class="text-white/70 font-sans text-sm">Kepada Yang Terhormat:</p>
            <p class="font-sans text-sm text-white/70">{{ $guest->name ?? 'Tamu Undangan' }}</p>
        </div>
        <div class="w-64 mx-auto h-2 bg-[#222] rounded-full overflow-hidden border border-gold/30">
            <div id="loading-progress-bar" class="h-full bg-gold" style="width: 0%"></div>
        </div>
        <div id="loading-progress-text" class="text-[10px] text-white/60 font-bold tracking-widest">0%</div>
        <button id="open-invitation-btn"
            class="mt-2 px-6 py-2 rounded-full bg-gold text-black font-bold text-xs tracking-wider hover:scale-105 transition-transform"
            style="display:none">Buka Undangan</button>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-fixed bg-contain relative bg-arvaya-300">

    <div class="absolute top-0 left-0 w-full h-full bg-radial from-black/40 via-black/70 to-black z-0">
    </div>

    <div
        class="relative min-h-svh font-title lg:max-w-sm mx-auto shadow-xl shadow-black/80 overflow-hidden bg-zinc-900">

        {{-- 1. COVER SECTION --}}
        <section class="min-h-svh relative bg-theme p-4">

            {{--cover image & overlay --}}
            <img src="{{ $coverImage }}" alt="cover" class="absolute top-0 left-0 w-full h-full object-cover z-9">
            <div class="absolute top-0 left-0 w-full h-full bg-radial from-black/10 via-black/50 to-black z-10">
            </div>

            {{-- cover content --}}
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 flex flex-col items-center justify-between h-3/4 w-full">
                <div>
                    <h1 class="font-title text-2xl text-center text-white/70 animate-float" data-anim="fade-down"
                        data-duration="1.5s">Wedding Invitation</h1>
                </div>

                <div>
                    <div data-anim="zoom-in" data-duration="1.5s">
                        <img src="img/assets/golden-mocking-bird.png" alt=""
                            class="w-10  h-10  mb-1 mx-auto animate-float">
                        <h1 class="font-serif text-5xl gold-gradient-text text-center py-3">
                            <span class="">{{ $groom['nickname'] ?? 'Groom' }}</span>
                            <span class="text-3xl font-title">&</span>
                            <span class="">{{ $bride['nickname'] ?? 'Bride' }}</span>
                        </h1>
                        @if($eventDate)
                            <div class="tracking-tighter text-center border-y border-accent/50 pb-2 mb-10">
                                <span class="inline-block pl-5 text-white/80">
                                    <span>{{ $eventDate->translatedFormat('d') }}</span>
                                    <span class="size-[5px] bg-theme rounded-full inline-block align-middle mx-1"></span>
                                    <span>{{ $eventDate->translatedFormat('F') }}</span>
                                    <span class="size-[5px] bg-theme rounded-full inline-block align-middle mx-1"></span>
                                    <span>{{ $eventDate->translatedFormat('Y') }}</span>
                                </span>
                            </div>
                        @endif
                        <div class="w-full text-white/70 text-center">
                            <p class="text-[10px] uppercase tracking-wider mb-2">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                            <h3 class="font-title text-xl">{{ $guest->name ?? 'Tamu Undangan' }}
                            </h3>
                        </div>
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            {{-- cover content --}}


        </section>
        {{-- 1. COVER SECTION --}}

        {{-- 2. QUOTE SECTION --}}
        <section class="bg-zinc-900 px-6 py-16 shadow-inset">
            <div class="text-center px-5 pt-24 border-2 flex flex-col justify-center rounded-t-full border-gold shadow-inset mb-5"
                data-anim="fade-up" data-duration="1.5s">
                @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
                <i class="fa-solid fa-quote-left text-2xl theme-text opacity-30 mb-4 block"></i>
                @if ($qs && ($qs['type'] ?? '') === 'quran')
                    <p class="font-serif text-2xl gold-gradient-text mb-4 leading-relaxed">{{ $qs['arabic'] ?? '' }}</p>
                    <p class="font-sans text-md text-white/60 mb-4 leading-relaxed">{{ $qs['translation'] ?? '' }}</p>
                    <p class="font-title text-lg theme-text mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
                @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                    <p class="font-serif text-lg theme-text mb-4 leading-relaxed">{{ $qs['verse_text'] ?? '' }}</p>
                    @if (!empty($qs['translation']))
                        <p class="font-sans text-lg theme-text mb-4 leading-relaxed">{{ $qs['translation'] }}</p>
                    @endif
                    <p class="font-serif text-sm theme-text mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
                @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                    <p class="font-sans text-xl theme-text mb-4 leading-relaxed">“{{ $qs['quote_text'] ?? '' }}”</p>
                    <p class="font-serif text-sm theme-text mb-8 leading-relaxed">{{ $qs['source'] ?? 'Unknown' }}</p>
                @else
                    <p class="font-sans text-xl theme-text mb-8 leading-relaxed">
                        "{{ $invitation->couple_data['quote'] ?? 'The Wedding' }}"</p>
                @endif
                <div class="w-24 h-1 bg-gold mx-auto rounded-full mb-10"></div>
            </div>
        </section>
        <div class="relative">
            <img class="aspect-[3/4] object-cover"
                src="{{ isset($moments[0]) ? asset($moments[0]) : asset($coverImage) }}" alt="">
            <div class="absolute top-0 left-0 w-full h-full bg-radial from-black/20 via-black/40 to-black/90 z-10">
            </div>
            <div class="absolute w-full bottom-10 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 text-center px-6"
                data-anim="fade-up" data-duration="1.5s">
                <i class="fa-solid fa-quote-left text-2xl text-white/70 opacity-30 mb-4 block"></i>
                <p class="font-title text-sm text-white/70 mb-4 leading-relaxed">"Cinta bukan tentang menemukan
                    seseorang yang sempurna, tapi belajar melihat kekurangan sebagai keindahan."</p>
                <div class="w-32 h-[2px] bg-gold mx-auto rounded-full"></div>
            </div>
        </div>
        {{-- 2. QUOTE SECTION --}}


        {{-- 3.COUPLE SECTION --}}
        <section class="bg-zinc-900 px-6 py-10  shadow-inset space-y-5">
            <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                <img class="h-20 mx-auto" src="img/assets/golden-spacer.png" alt="">
                <div class="absolute w-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 text-center px-6">
                    <h1 class="font-title text-xl text-white/70 leading-relaxed">Mempelai Pria</h1>
                </div>
            </div>
            <div data-anim="zoom-in" data-duration="1.5s">
                <img class="w-52 p-2 aspect-[3/4] rounded-gate mx-auto object-cover border-2 border-gold shadow-dark"
                    src="{{ asset($groomImage) }}" alt="">
            </div>
            <div>
                <div data-anim="fade-left" data-duration="1.5s" class="w-full text-center p-3">
                    <h2 class="text-2xl mb-2 gold-gradient-text">{{ $groom['fullname'] }}</h2>
                    <p class="text-sm text-white/60">Putra dari:</p>
                    <p class="text-md leading-relaxed mb-2 text-white/60">Bpk. {{ $groom['father'] }} &<br> Ibu
                        {{ $groom['mother'] }}
                    </p>
                </div>
            </div>
        </section>
        <section class="bg-gradient-to-br from-zinc-800 to-zinc-900 px-6 py-10 space-y-5 shadow-black/70">
            <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                <img class="h-20 mx-auto" src="img/assets/golden-spacer.png" alt="">
                <div class="absolute w-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 text-center px-6">
                    <h1 class="font-title text-xl text-white/70 leading-relaxed">Mempelai Wanita</h1>
                </div>
            </div>
            <div data-anim="zoom-in" data-duration="1.5s">
                <img class="w-52 aspect-[3/4] rounded-gate mx-auto object-cover border-2 p-2 border-gold shadow-dark"
                    src="{{ asset($brideImage) }}" alt="">
            </div>
            <div>
                <div data-anim="fade-left" data-duration="1.5s" class="w-full text-center p-3">
                    <h2 class="text-2xl mb-2 gold-gradient-text">{{ $bride['fullname'] }}</h2>
                    <p class="text-sm text-white/60">Putri dari:</p>
                    <p class="text-md leading-relaxed mb-2 text-white/60">Bpk. {{ $bride['father'] }} &<br> Ibu
                        {{ $bride['mother'] }}
                    </p>
                </div>
            </div>
        </section>
        {{-- 3.COUPLE SECTION --}}


        {{-- 3.INVITATION SECTION --}}
        @if($invitation->theme_config['events_enabled'] ?? true)
            <section class="min-h-screen bg-zinc-900 px-6 py-16 space-y-5">
                <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-4xl text-center gold-gradient-text leading-relaxed">Acara Pernikahan</h1>
                    <div class="w-32 h-[2px] bg-gold mx-auto rounded-full"></div>
                </div>

                @if(!empty($invitation->event_data) && is_array($invitation->event_data))
                    @foreach($invitation->event_data as $event)
                        @php
                            $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
                        @endphp
                        @if($eventDate)
                            <div class="text-center space-y-6" data-anim="fade-up" data-duration="1.5s">
                                <div
                                    class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-6 border-y-4 border-gold shadow-black/50 shadow-xl rounded-xl">
                                    <h2 class="font-title text-2xl text-white/80 mb-2">{{ $event['title'] ?? 'The Wedding' }}</h2>
                                    <div class="w-full h-px bg-white/10 my-4"></div>

                                    <div class="space-y-1 mb-6">
                                        <p class="font-title text-xl theme-text">{{ $eventDate->translatedFormat('l, d F Y') }}</p>
                                        <p class="font-sans text-sm text-white/60">Pukul {{ $eventDate->format('H:i') }} WIB - Selesai
                                        </p>
                                    </div>

                                    <div class="space-y-2 mb-8">
                                        <i class="fa-solid fa-location-dot text-2xl gold-gradient-text animate-bounce"></i>
                                        <p class="font-bold text-white/80">{{ $event['location'] ?? 'Lokasi Belum Ditentukan' }}</p>
                                        <p class="font-sans text-xs text-white/50 max-w-[200px] mx-auto">{{ $event['address'] ?? '' }}
                                        </p>
                                    </div>

                                    @if(!empty($event['map_link']))
                                        <a href="{{ $event['map_link'] }}" target="_blank"
                                            class="inline-block px-8 py-3 bg-gold text-black font-bold uppercase tracking-widest text-xs hover:bg-white transition rounded-full shadow-[0_0_15px_rgba(212,175,55,0.5)]">
                                            Google Maps
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
                class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-t-[80px] px-6 py-16 shadow-black/60 shadow-dark-top space-y-8">
                <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-4xl text-center gold-gradient-text leading-relaxed">Dress Code</h1>
                    <div class="w-32 h-[2px] bg-gold mx-auto rounded-full"></div>
                </div>

                <div class="text-center max-w-lg mx-auto" data-anim="fade-up" data-duration="1.5s">
                    <div class="bg-zinc-900 border border-gold/20 p-8 rounded-gate shadow-inset relative">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-zinc-900 rounded-full border p-2">
                            <i class="fa-solid fa-shirt theme-text text-2xl"></i>
                        </div>

                        <p class="font-title text-lg text-white/90 mb-6 leading-relaxed">
                            "{{ $dressCode['description'] ?? 'Mohon mengenakan pakaian formal.' }}"
                        </p>

                        @if(!empty($dressCode['colors']))
                            <div class="flex flex-wrap justify-center gap-4 mb-8">
                                @foreach($dressCode['colors'] as $color)
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-12 h-12 rounded-full border-2 border-gold/40 shadow-[0_0_15px_rgba(212,175,55,0.2)]"
                                            style="background-color: {{ $color }}"></div>
                                        <span class="text-[10px] text-white/40 uppercase tracking-widest">{{ $color }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(!empty($dressCode['image']))
                            <div
                                class="mb-8 p-2 bg-zinc-800 border border-gold/20 inline-block transform -rotate-1 hover:rotate-0 transition duration-500 shadow-lg">
                                <img src="{{ asset($dressCode['image']) }}"
                                    class="max-w-[200px] max-h-[300px] object-cover filter grayscale hover:grayscale-0 transition duration-500">
                            </div>
                        @endif

                        @if(!empty($dressCode['notes']))
                            <div class="border-t border-white/10 pt-4 mt-4">
                                <p class="font-sans text-xs text-gold/80">
                                    <span class="font-bold uppercase tracking-widest mr-1">Note:</span>
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
            <div class="pt-10 p-6" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Video</h1>
                <div class="bg-zinc-900 p-2 rounded-2xl border-gold border overflow-hidden shadow-inner">
                    <div class="aspect-video rounded-xl overflow-hidden">
                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </div>
            </div>
        @endif

        {{-- 4. GALLERY SECTION --}}
        @if (!empty($moments) && ($invitation->gallery_data['enabled'] ?? true))
            <section class="min-h-screen bg-zinc-800 px-6 py-16 space-y-5" x-data="{ photoOpen: false, photoSrc: '' }">
                <div class="relative mb-14" data-anim="fade-up" data-duration="1.5s">
                    <h1 class="font-serif text-5xl text-center gold-gradient-text leading-relaxed">Galeri Foto</h1>
                    <div class="w-32 h-[2px] bg-gold mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    @foreach ($moments as $index => $photo)
                        <div class="relative aspect-[3/4] overflow-hidden border-2 p-2 border-gold group cursor-pointer {{ $index % 3 == 0 ? 'col-span-2 aspect-square' : '' }}"
                            @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'" data-anim="fade-up"
                            data-duration="1.5s">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition duration-500 z-10">
                            </div>
                            <img src="{{ asset($photo) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-1000">
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox -->
                <div x-show="photoOpen" x-transition.opacity
                    class="fixed inset-0 z-[9999] bg-black/95 backdrop-blur-md flex items-center justify-center p-4">
                    <button @click="photoOpen = false"
                        class="absolute top-6 right-6 text-white/50 hover:text-gold text-4xl">&times;</button>
                    <img :src="photoSrc"
                        class="max-w-full max-h-[85vh] border-2 border-gold shadow-[0_0_30px_rgba(212,175,55,0.3)] rounded-lg">
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
            <section class="bg-zinc-900 px-6 py-16 shadow-dark-top space-y-10">
                {{-- GIFTS --}}
                @if($hasGifts && !empty($gifts))
                    <div class="text-center" data-anim="fade-up" data-duration="1.5s">
                        <h1 class="font-serif text-4xl gold-gradient-text mb-6">Wedding Gift</h1>
                        <p class="font-sans text-xs text-white/60 mb-8 leading-relaxed">Tanpa mengurangi rasa hormat, bagi anda
                            yang ingin memberikan tanda kasih, dapat melalui:</p>

                        <div class="space-y-6">
                            @foreach ($gifts as $gift)
                                <div class="relative w-full max-w-[340px] mx-auto aspect-[1.58/1] rounded-2xl overflow-hidden shadow-[0_15px_40px_-5px_rgba(0,0,0,0.8)] transform transition duration-500 hover:scale-[1.02] group"
                                    data-anim="zoom-in" data-duration="1.5s">

                                    <div class="absolute inset-0 bg-gradient-to-br from-[#2b2b2b] via-[#050505] to-[#1a1a1a]"></div>

                                    <div
                                        class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] mix-blend-overlay">
                                    </div>

                                    <div
                                        class="absolute -top-[100%] -left-[100%] w-[300%] h-[300%] bg-gradient-to-br from-transparent via-[#BF953F]/10 to-transparent rotate-45 pointer-events-none group-hover:translate-x-10 group-hover:translate-y-10 transition-transform duration-1000">
                                    </div>

                                    <div class="absolute inset-0 border border-[#BF953F]/30 rounded-2xl z-20"></div>

                                    <div class="relative z-10 h-full p-6 flex flex-col justify-between">

                                        <div class="flex justify-between items-start">
                                            <div
                                                class="w-10 h-8 rounded-md bg-gradient-to-br from-[#FFE5B4] via-[#BF953F] to-[#7d5d18] border border-black/20 shadow-inner flex items-center justify-center overflow-hidden relative">
                                                <div class="absolute w-full h-[1px] bg-black/30 top-1/3"></div>
                                                <div class="absolute w-full h-[1px] bg-black/30 bottom-1/3"></div>
                                                <div class="absolute h-full w-[1px] bg-black/30 left-1/3"></div>
                                                <div class="absolute h-full w-[1px] bg-black/30 right-1/3"></div>
                                                <div class="w-4 h-3 border border-black/30 rounded-[2px]"></div>
                                            </div>

                                            <div class="text-right">
                                                <i class="fa-solid fa-wifi rotate-90 text-white/30 text-lg mb-1 block"></i>
                                                <span
                                                    class="font-bold text-[#BF953F] uppercase tracking-widest text-sm drop-shadow-md">
                                                    {{ $gift['bank_name'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span
                                                class="font-mono text-xl md:text-2xl text-transparent bg-clip-text bg-gradient-to-b from-white via-gray-200 to-gray-400 tracking-[0.15em] drop-shadow-[1px_2px_2px_rgba(0,0,0,0.8)] w-full text-center">
                                                {{ $gift['account_number'] }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-end">
                                            <div>
                                                <p class="text-[7px] text-[#BF953F] uppercase tracking-[0.2em] mb-1 opacity-80">Card
                                                    Holder</p>
                                                <p
                                                    class="font-sans text-left font-bold text-white/90 uppercase tracking-widest text-xs drop-shadow-md">
                                                    {{ $gift['account_name'] }}
                                                </p>
                                            </div>

                                            <div class="flex flex-col items-end gap-2">
                                                <span class="text-[8px] text-gray-400 italic font-serif">Platinum</span>
                                                <button
                                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Nomor Rekening Tersalin!')"
                                                    class="group/btn flex items-center gap-2 bg-[#BF953F]/10 hover:bg-[#BF953F] border border-[#BF953F]/50 hover:border-[#BF953F] backdrop-blur-sm px-3 py-1.5 rounded-full transition-all duration-300">
                                                    <span
                                                        class="text-[9px] uppercase tracking-widest text-[#BF953F] group-hover/btn:text-black font-bold">Copy</span>
                                                    <i
                                                        class="fa-regular fa-copy text-[#BF953F] group-hover/btn:text-black text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (!empty($theme['gift_address']))
                            <div class="mt-8 bg-gradient-to-br from-[#1e1e1e] via-[#181818] to-[#1b1b1b] border border-gold text-center rounded-2xl p-6 shadow-sm"
                                data-anim="fade-up" data-duration="1.5s">
                                <div class="flex justify-center items-center gap-2 mb-2 theme-text">
                                    <i class="fa-solid fa-gift"></i>
                                    <span class="font-title font-bold">Alamat Pengiriman Kado</span>
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
            <div class="pt-10 p-6 rounded-lg shadow-inset" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Konfirmasi Kehadiran</h1>

                <div class="p-6 rounded-2xl border-gold border shadow-xl">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        @endif



        {{-- WISHES --}}
        @if($hasGuestbook)
            <div class="pt-10 p-6" data-anim="fade-up" data-duration="1.5s">
                <h1 class="font-serif text-4xl text-center gold-gradient-text mb-8">Ucapan & Doa</h1>
                <div class="bg-zinc-900 p-4 rounded-2xl border-gold border overflow-y-auto custom-scrollbar shadow-inner">
                    @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        @endif

        {{-- 5. THANK YOU MESSAGE --}}
        <section class="relative py-20 px-6 bg-neutral-950 overflow-hidden" data-anim="fade-up" data-duration="1.5s">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-amber-500/10 blur-[100px] rounded-full pointer-events-none">
            </div>

            <div class="relative z-10 max-w-2xl mx-auto text-center">
                <div class="mb-6 flex justify-center opacity-80">
                    <svg class="w-8 h-8 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </div>

                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-6 tracking-wide">
                    <span
                        class="bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#B38728] bg-clip-text text-transparent drop-shadow-sm">
                        Terima Kasih
                    </span>
                </h2>

                <p class="font-sans text-sm md:text-base text-amber-100/70 leading-loose italic mb-10 px-4">
                    "{{ $invitation->theme_config['thank_you_message'] ?? 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kami.' }}"
                </p>

                <div
                    class="w-24 h-[1px] bg-gradient-to-r from-transparent via-amber-500/50 to-transparent mx-auto mb-10">
                </div>

                <h2 class="font-serif text-3xl gold-gradient-text mb-2">{{ $groom['nickname'] }} &
                    {{ $bride['nickname'] }}
                </h2>
            </div>
        </section>
        {{-- 5. THANK YOU MESSAGE --}}

        {{-- 6. FOOTER --}}
        <footer class="bg-zinc-900 py-8 text-center border-t border-gold">
            <a href="https://arvaya.id" target="_blank"
                class="font-sans text-[10px] text-white/30 uppercaseatracking-[0.3em]">Powered By Arvaya.id</a>
            <div class="mt-4">
                <img src="img/assets/golden-mocking-bird.png" class="w-8 h-8 mx-auto opacity-50 grayscale">
            </div>
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
            class="w-10 h-10 theme-bg rounded-full flex items-center justify-center pointer-events-auto">
            <i class="fa-solid text-white text-xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
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
            timerId: null,
            days: '00', hours: '00', minutes: '00', seconds: '00',
            start() {
                const tick = () => {
                    const now = Date.now();
                    let diff = this.target - now;
                    if (diff <= 0) {
                        this.days = this.hours = this.minutes = this.seconds = '00';
                        if (this.timerId) clearInterval(this.timerId);
                        return;
                    }
                    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                    diff -= d * (1000 * 60 * 60 * 24);
                    const h = Math.floor(diff / (1000 * 60 * 60));
                    diff -= h * (1000 * 60 * 60);
                    const m = Math.floor(diff / (1000 * 60));
                    diff -= m * (1000 * 60);
                    const s = Math.floor(diff / 1000);
                    this.days = String(d).padStart(2, '0');
                    this.hours = String(h).padStart(2, '0');
                    this.minutes = String(m).padStart(2, '0');
                    this.seconds = String(s).padStart(2, '0');
                };
                tick();
                this.timerId = setInterval(tick, 1000);
            }
        }
    }
</script>