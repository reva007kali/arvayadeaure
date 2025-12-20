@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    $primaryColor = data_get($theme, 'primary_color', '#9A2A2A');
    $galleryData = $invitation->gallery_data ?? [];

    // Default Images
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=E8DCCA&color=9A2A2A&size=200&name=';

    // Resolved Images
    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];

    // Fallback if moments structure is different
    if (empty($moments) && isset($galleryData[0])) {
        $moments = $galleryData;
    }

    // Event Data Helper
    $event = $invitation->event_data[0] ?? [];
    $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
@endphp

@slot('head')
<title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} Wedding Invitation</title>
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
        --color-bg: #FFFBF2;
        --color-text: #5C2828;
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

    /* Loading Animation */
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

    /* Theme Scope Overrides */
    .theme-scope .theme-text {
        color: var(--color-primary);
    }

    .theme-scope .theme-bg {
        background-color: var(--color-primary);
    }

    .theme-scope button {
        background-color: var(--color-primary);
        color: #fff;
    }

    .theme-scope button:hover {
        filter: brightness(0.9);
    }

    .theme-scope input,
    .theme-scope textarea,
    .theme-scope select {
        border: 1px solid var(--color-primary);
    }

    .theme-scope input:focus,
    .theme-scope textarea:focus,
    .theme-scope select:focus {
        outline: none;
        box-shadow: 0 0 0 2px var(--color-primary);
    }
</style>

{{-- LOADING SCREEN --}}
<div id="loading-overlay"
    class="fixed inset-0 z-[9999] bg-[#FFFBF2] flex flex-col items-center justify-center transition-opacity duration-700">
    <div class="relative w-24 h-24 mb-6">
        <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-lg" fill="none" stroke="none">
            <defs>
                <clipPath id="cup-mask">
                    <path d="M20,30 Q20,80 50,80 Q80,80 80,30 L80,20 L20,20 Z" />
                </clipPath>
            </defs>
            <path d="M80,35 Q95,35 95,50 Q95,65 80,65" stroke="#5C2828" stroke-width="6" fill="none"
                stroke-linecap="round" />
            <g clip-path="url(#cup-mask)">
                <rect x="0" y="0" width="100" height="100" fill="#E6D9B8" opacity="0.2" />
                <rect id="coffee-fill" x="0" y="0" width="100" height="100" fill="#5C2828"
                    class="translate-y-full transition-transform duration-[2000ms] ease-out" />
            </g>
            <path d="M20,30 Q20,80 50,80 Q80,80 80,30 L80,20 L20,20 Z" stroke="#5C2828" stroke-width="4" fill="none" />
            <path d="M40,10 Q40,0 30,5" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.2s" />
            <path d="M50,8 Q50,-2 40,3" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.5s" />
            <path d="M60,10 Q60,0 50,5" stroke="#5C2828" stroke-width="2" stroke-linecap="round" class="animate-pulse"
                style="animation-delay: 0.8s" />
        </svg>
    </div>

    <div class="h-24 flex flex-col items-center justify-center gap-2">
        <div id="loading-info" class="text-center">
            <p class="text-[#5C2828] font-serif tracking-widest text-sm animate-pulse">
                {{ $event['title'] ?? 'Wedding Invitation' }}
            </p>
            <p class="text-[#5C2828] font-title text-2xl leading-tight">
                {{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }}
            </p>
        </div>
        <button id="open-invitation-btn"
            class="hidden transform scale-90 opacity-0 transition-all duration-500 bg-[#5C2828] text-[#FFFBF2] px-8 py-2 rounded-full font-sans font-bold shadow-lg hover:bg-[#7C3838] hover:scale-100 hover:shadow-xl uppercase tracking-wider items-center gap-2">
            <i class="fa-solid fa-envelope-open-text"></i> Buka Undangan
        </button>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div
    class="text-[#5C2828] bg-white min-h-screen overflow-hidden selection:bg-[#c51e1e] selection:text-white font-sans relative max-w-sm mx-auto shadow-2xl">

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[990] w-full max-w-sm px-6 pointer-events-none print:hidden">

            <div class="pointer-events-auto inline-block">
                <!-- Toggle Button -->
                <button x-show="!isOpen" @click="isOpen = true" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
                    class="w-12 h-12 bg-[#FDFBF7] text-[#AA8C49] rounded-full shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-[#AA8C49]/20 flex items-center justify-center hover:scale-110 transition-transform animate-[spin_10s_linear_infinite]">
                    <i class="fa-solid fa-compact-disc text-2xl"></i>
                </button>

                <!-- Player Widget -->
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-10 scale-90"
                    class="relative w-[280px] bg-[#FDFBF7] rounded-3xl shadow-[0_20px_40px_-10px_rgba(0,0,0,0.2)] border border-white/50 overflow-hidden backdrop-blur-md">

                    <button @click="isOpen = false"
                        class="absolute top-4 right-4 text-gray-400 hover:text-[#AA8C49] z-20 transition">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div
                        class="absolute inset-0 bg-gradient-to-b from-white via-[#FDFBF7] to-[#F3E5AB]/20 pointer-events-none">
                    </div>

                    <div class="relative z-10 p-6 flex flex-col items-center">
                        <div class="relative w-[200px] h-[200px] mb-4 flex items-center justify-center">
                            <div class="absolute top-0 -left-2 w-16 h-24 z-20 origin-top-left transition-transform duration-700 ease-in-out"
                                :class="isPlaying ? 'rotate-[-10deg]' : 'rotate-[23deg]'">
                                <svg viewBox="0 0 50 100" class="w-full h-full drop-shadow-md">
                                    <path d="M5,5 C5,5 15,40 25,80 L35,85" stroke="#999" stroke-width="4" fill="none"
                                        stroke-linecap="round" />
                                    <circle cx="5" cy="5" r="5" fill="#CCC" />
                                    <rect x="20" y="75" width="20" height="15" fill="#333" rx="2" />
                                </svg>
                            </div>
                            <div class="relative w-full h-full rounded-full shadow-xl bg-[#1a1a1a] flex items-center justify-center border-4 border-white/80"
                                :class="isPlaying ? 'animate-[spin_6s_linear_infinite]' : ''"
                                style="background: repeating-radial-gradient(#111 0, #111 2px, #2a2a2a 3px, #2a2a2a 4px);">
                                <div
                                    class="w-[55%] h-[55%] rounded-full overflow-hidden border-[3px] border-[#111] relative">
                                    <img src="{{ isset($galleryData['cover']) ? asset($galleryData['cover']) : $defaultCover }}"
                                        class="w-full h-full object-cover grayscale-100">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-tr from-white/20 to-transparent pointer-events-none rounded-full">
                                    </div>
                                </div>
                            </div>
                            <div class="absolute -bottom-4 w-[80%] h-4 bg-black/20 blur-xl rounded-full"></div>
                        </div>

                        <div class="text-center mb-6 w-full">
                            <div class="overflow-hidden w-full whitespace-nowrap">
                                <h3 class="font-serif text-xl font-bold text-[#2C2C2C] truncate">The Wedding</h3>
                            </div>
                            <p class="font-sans text-xs text-[#AA8C49] tracking-widest uppercase mt-1">
                                {{ $groom['nickname'] }} & {{ $bride['nickname'] }}
                            </p>
                        </div>

                        <div class="w-full h-1 bg-gray-200 rounded-full mb-6 relative overflow-hidden">
                            <div class="h-full bg-[#AA8C49]"
                                :class="isPlaying ? 'w-full transition-all duration-[200s] ease-linear' : 'w-0'"></div>
                        </div>

                        <div class="flex items-center justify-between w-full px-4 text-[#AA8C49]">
                            <button @click="seek(-10)" class="hover:text-[#8C6E33] transition hover:scale-110"><i
                                    class="fa-solid fa-backward-step text-xl"></i></button>
                            <button @click="togglePlay"
                                class="w-16 h-16 rounded-full flex items-center justify-center shadow-[0_8px_20px_rgba(170,140,73,0.3)] hover:scale-105 transition-all duration-300"
                                :class="isPlaying ? 'bg-[#AA8C49] text-white' : 'bg-[#AA8C49] text-white pl-1'">
                                <i class="fa-solid text-2xl" :class="isPlaying ? 'fa-pause' : 'fa-play'"></i>
                            </button>
                            <button @click="seek(10)" class="hover:text-[#8C6E33] transition hover:scale-110"><i
                                    class="fa-solid fa-forward-step text-xl"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute opacity-0 pointer-events-none w-0 h-0 overflow-hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>
    @endif

    {{-- 1. HERO / COVER SECTION --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper.png')]">
        <div class="h-full flex flex-col md:items-center">
            <div data-anim="fade-up" class="pt-2 w-full text-xl">
                <div class="tracking-tighter font-semibold flex justify-between border-b border-black/50">
                    <span class="inline-block">Your</span>
                    <span class="inline-block">Presence is Requested</span>
                </div>
                <div class="tracking-tighter font-semibold flex border-b border-black/50">
                    <span class="inline-block w-1/3">TO</span>
                    <span class="inline-block">Celebrate</span>
                </div>
                <div class="tracking-tighter font-semibold flex justify-between border-b border-black/50">
                    <span class="inline-block pl-5">THE</span>
                    <span class="inline-block">wedding of</span>
                </div>
                <div class="tracking-tighter py-3 text-center border-b border-black/50">
                    <h1 class="text-4xl theme-text font-title">{{ $groom['nickname'] ?? 'Groom' }} &
                        {{ $bride['nickname'] ?? 'Bride' }}
                    </h1>
                </div>
                @if($eventDate)
                    <div class="tracking-tighter text-center font-semibold border-b border-black/50">
                        <span class="inline-block pl-5">
                            <span>{{ $eventDate->translatedFormat('d') }}</span>
                            <span class="w-1.5 h-1.5 bg-white rounded-full inline-block align-middle mx-1"></span>
                            <span>{{ $eventDate->translatedFormat('F') }}</span>
                            <span class="w-1.5 h-1.5 bg-white rounded-full inline-block align-middle mx-1"></span>
                            <span>{{ $eventDate->translatedFormat('Y') }}</span>
                        </span>
                    </div>
                @endif
            </div>
            <div data-anim="zoom-in" class="flex justify-end py-10 w-full">
                <img class="grayscale-100 object-cover max-h-[330px] w-full aspect-[3/4] bg-white/90 px-3 pt-3 pb-10 shadow-xl rounded"
                    src="{{ asset($coverImage) }}" alt="Cover">
            </div>
            @if ($guest)
                <div data-anim="fade-up" class="origin-top w-full">
                    <p class="text-[10px] uppercase tracking-wider mb-2">Kepada Yth. Bapak/Ibu/Saudara/i:</p>
                    <h3 class="font-serif font-bold text-2xl md:text-3xl">{{ $guest->name ?? 'Tamu Undangan' }}</h3>
                </div>
            @endif
        </div>
    </section>

    {{-- 2. QUOTE SECTION --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div class="text-center" data-anim="fade-up" data-duration="1.5s">
            @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
            <i class="fa-solid fa-quote-left text-4xl theme-text opacity-30 mb-4 block"></i>
            @if ($qs && ($qs['type'] ?? '') === 'quran')
                <p class="font-serif text-2xl text-[#7C6339] mb-4 leading-relaxed">{{ $qs['arabic'] ?? '' }}</p>
                <p class="font-serif text-lg text-[#7C6339] mb-4 leading-relaxed">{{ $qs['translation'] ?? '' }}</p>
                <p class="font-serif text-sm text-[#7C6339] mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                <p class="font-serif text-lg text-[#7C6339] mb-4 leading-relaxed">{{ $qs['verse_text'] ?? '' }}</p>
                @if (!empty($qs['translation']))
                    <p class="font-serif text-lg text-[#7C6339] mb-4 leading-relaxed">{{ $qs['translation'] }}</p>
                @endif
                <p class="font-serif text-sm text-[#7C6339] mb-8 leading-relaxed">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                <p class="font-serif text-xl text-[#7C6339] mb-4 leading-relaxed">“{{ $qs['quote_text'] ?? '' }}”</p>
                <p class="font-serif text-sm text-[#7C6339] mb-8 leading-relaxed">{{ $qs['source'] ?? 'Unknown' }}</p>
            @else
                <p class="font-serif text-xl text-[#7C6339] mb-8 leading-relaxed">
                    "{{ $invitation->couple_data['quote'] ?? 'The Wedding' }}"</p>
            @endif
            <div class="w-24 h-1 theme-bg mx-auto rounded-full mb-10"></div>
        </div>

        <div data-anim="fade-up">
            <img class="grayscale-100 mx-auto object-cover max-h-[450px] w-full aspect-[3/4] bg-white/90 px-3 pt-3 pb-10 shadow-xl rounded"
                src="{{ isset($moments[1]) ? asset($moments[1]) : asset($coverImage) }}" alt="Quote Photo">
        </div>
    </section>

    {{-- 3. COUPLE SECTION --}}
    <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div>
            <div data-anim="fade-up"
                class="py-4 mx-auto w-fit px-6 flex justify-center items-center text-center bg-contain p-2 bg-no-repeat bg-[url('/public/img/assets/masking-tape-red.png')]">
                <h1 class="font-serif font-semibold mt-3 text-white/80 mb-8 text-2xl">The Groom and Bride</h1>
            </div>

            {{-- Groom --}}
            <div class="flex flex-col gap-4">
                <div data-anim="fade-right" class="w-full flex justify-center">
                    <img src="{{ asset($groomImage) }}"
                        class="-rotate-2 grayscale-100 object-cover w-3/4 aspect-[3/4] bg-white/90 p-2 shadow-xl rounded">
                </div>
                <div data-anim="fade-left" class="w-full text-center p-3 font-semibold">
                    <h2 class="text-2xl mb-2 underline">{{ $groom['fullname'] }}</h2>
                    <p class="text-sm">Putra dari:</p>
                    <p class="text-lg leading-relaxed mb-2">Bpk. {{ $groom['father'] }} & Ibu {{ $groom['mother'] }}</p>
                </div>
            </div>

            {{-- Ampersand --}}
            <div data-anim="zoom-in" class="py-8">
                <h1 class="text-center text-6xl font-bold">&</h1>
            </div>

            {{-- Bride --}}
            <div class="flex flex-col-reverse gap-4">
                <div data-anim="fade-right" class="w-full text-center p-3 font-semibold">
                    <h2 class="text-2xl mb-2 underline">{{ $bride['fullname'] }}</h2>
                    <p class="text-sm">Putri dari:</p>
                    <p class="text-lg leading-relaxed mb-2">Bpk. {{ $bride['father'] }} & Ibu {{ $bride['mother'] }}</p>
                </div>
                <div data-anim="fade-left" class="w-full flex justify-center">
                    <img src="{{ asset($brideImage) }}"
                        class="rotate-2 grayscale-100 object-cover w-3/4 aspect-[3/4] bg-white/90 p-2 shadow-xl rounded">
                </div>
            </div>
        </div>
    </section>

    {{-- 4. EVENT DETAILS --}}
    @if($invitation->events_enabled ?? true)
    <section class="bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
        <div data-anim="fade-up" class="text-center p-8 text-2xl font-semibold mb-6">
            <h1 class="uppercase underline">We Invite You to Join Our Wedding</h1>
        </div>
        <div class="mb-4 px-4">
            <div class="relative">
                <img class="mx-auto" src="{{ asset('img/assets/white-notebook.png') }}" alt="Notebook">
                <div class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-full px-12">
                    <div class="mb-4 font-bold text-center">
                        <p data-anim="fade-up">{{ $event['title'] ?? 'The Wedding' }}</p>
                    </div>
                    <div data-anim="fade-up"
                        class="text-center text-3xl opacity-75 theme-text font-title font-semibold mb-4 flex flex-col items-center">
                        <h1>{{ $groom['nickname'] }}</h1>
                        <span class="my-1">&</span>
                        <h1>{{ $bride['nickname'] }}</h1>
                    </div>
                    @if($eventDate)
                        <div class="flex font-semibold justify-center gap-4 text-[#5E4926] mb-4">
                            <p data-anim="fade-up" class="font-serif text-lg">{{ $eventDate->translatedFormat('F') }}</p>
                            <p data-anim="fade-up" class="font-serif text-lg">{{ $eventDate->translatedFormat('d') }}</p>
                            <p data-anim="fade-up" class="font-serif text-lg">{{ $eventDate->translatedFormat('Y') }}</p>
                        </div>
                        <div data-anim="fade-up" class="text-center text-[#5E4926]">
                            <p class="text-xs uppercase">Pukul</p>
                            <p class="font-serif text-lg font-semibold">{{ $eventDate->format('H:i') }} {{ $event['timezone'] ?? 'WIB' }} - Selesai</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($eventDate)
            <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()"
                class="flex gap-3 font-semibold justify-center text-center items-center text-sm mb-6 px-4">
                <div data-anim="fade-up" data-delay="0.3s" class="p-2 bg-white/60 rounded w-16">
                    <p class="text-xs">Hari</p>
                    <span class="text-xl" x-text="days">0</span>
                </div>
                <div data-anim="fade-up" data-delay="0.5s" class="p-2 bg-white/60 rounded w-16">
                    <p class="text-xs">Jam</p>
                    <span class="text-xl" x-text="hours">0</span>
                </div>
                <div data-anim="fade-up" data-delay="0.7s" class="p-2 bg-white/60 rounded w-16">
                    <p class="text-xs">Menit</p>
                    <span class="text-xl" x-text="minutes">0</span>
                </div>
                <div data-anim="fade-up" data-delay="0.9s" class="p-2 bg-white/60 rounded w-16">
                    <p class="text-xs">Detik</p>
                    <span class="text-xl text-red-700" x-text="seconds">0</span>
                </div>
            </div>
        @endif

        <div class="px-8 text-center bg-white/70 py-8" data-anim="fade-up">
            <p class="text-xl font-semibold mb-4">Lokasi Acara:</p>
            <div class="mb-5">
                <p class="font-bold text-[#5E4926] mb-1 text-lg">{{ $event['location'] ?? 'Lokasi Belum Ditentukan' }}
                </p>
                <p class="text-sm font-medium leading-relaxed text-gray-700">{{ $event['address'] ?? '' }}</p>
            </div>
            @if (!empty($event['map_link']))
                <a href="{{ $event['map_link'] }}" target="_blank"
                    class="inline-block px-8 py-3 bg-[#5E4926] text-white rounded-full text-xs font-bold uppercase tracking-wider hover:bg-[#403013] transition shadow-lg theme-btn">
                    <i class="fa-solid fa-location-arrow mr-2"></i> Google Maps
                </a>
            @endif
        </div>
    </section>
    @endif

    {{-- 5. GALLERY SECTION --}}
    @if (!empty($moments))
        <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]"
            x-data="{ photoOpen: false, photoSrc: '' }" @keydown.escape.window="photoOpen = false">
            <div data-anim="fade-up" class="mb-6 flex justify-center">
                <img src="{{ asset('img/assets/quote-note.png') }}" alt="Gallery Note" class="w-48">
            </div>
            <div class="grid grid-cols-2 gap-3 auto-rows-[150px]" data-anim-stagger="0.1">
                @foreach ($moments as $index => $photo)
                    <div data-anim="zoom-in"
                        class="relative group overflow-hidden rounded shadow-md cursor-pointer {{ $index % 3 == 0 ? 'col-span-2 row-span-2 h-full' : '' }}"
                        @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                        <img src="{{ asset($photo) }}" alt="Moment {{ $index }}"
                            class="w-full grayscale-100 h-full p-2 bg-white/70 object-cover transition duration-700 group-hover:scale-110">
                    </div>
                @endforeach
            </div>

            <!-- Fullscreen Photo Modal -->
            <div x-show="photoOpen" x-transition.opacity
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="photoOpen = false"></div>
                <div class="relative w-full max-w-sm">
                    <button @click="photoOpen = false"
                        class="absolute -top-10 right-0 text-white hover:text-red-500 transition text-2xl">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <img :src="photoSrc" alt="Preview"
                        class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl border border-white/20">
                </div>
            </div>
        </section>
    @endif

    {{-- 6. GIFT SECTION --}}
    @if (!empty($gifts) && ($invitation->theme_config['gifts_enabled'] ?? true))
        <section class="p-8">
            <div data-anim-stagger="0.3">
                <h1 data-anim="fade-up" class="text-3xl font-title text-center py-3">Wedding Gift</h1>
                <p data-anim="fade-up" class="font-semibold text-center py-5 border-y border-yellow-900/60 text-sm italic">
                    “Your presence means the world to us. But if you wish to share a gift, we receive it with gratitude and
                    love.”
                </p>
            </div>
            @foreach ($gifts as $gift)
                <div class="relative w-full max-w-[320px] mx-auto my-6 group" data-anim="flip-up" data-duration="0.8s">
                    <div
                        class="relative h-[200px] w-full rounded-2xl bg-gradient-to-br from-[#005c97] to-[#062c4c] shadow-xl overflow-hidden text-white transition-transform duration-500 hover:-translate-y-2 border border-[#3e7aa8]/30">
                        <div
                            class="absolute top-[-50%] left-[-20%] w-[300px] h-[300px] rounded-full border-[2px] border-white/5">
                        </div>
                        <div
                            class="absolute bottom-[-50%] right-[-20%] w-[200px] h-[200px] rounded-full bg-blue-500/10 blur-3xl">
                        </div>

                        <div class="relative h-full p-5 flex flex-col justify-between z-10">
                            <div class="flex justify-between items-start">
                                <div class="italic font-bold text-xl tracking-tighter font-serif">{{ $gift['bank_name'] }}</div>
                                <div
                                    class="text-[10px] font-light tracking-widest opacity-80 border border-white/30 px-1.5 py-0.5 rounded">
                                    DEBIT</div>
                            </div>

                            <div class="flex items-center gap-3 mt-1">
                                <div
                                    class="w-10 h-7 rounded bg-gradient-to-br from-[#eebf74] via-[#f8eebb] to-[#bfa05f] relative overflow-hidden shadow-sm border border-[#a68644]">
                                    <div class="absolute top-1/2 left-0 w-full h-[1px] bg-[#8c6e33]/50"></div>
                                    <div class="absolute top-0 left-1/2 h-full w-[1px] bg-[#8c6e33]/50"></div>
                                </div>
                                <i class="fa-solid fa-wifi rotate-90 text-white/70 text-sm"></i>
                            </div>

                            <div class="mt-2 flex items-center justify-between cursor-pointer"
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('No Rekening Disalin!');">
                                <div class="font-mono text-xl tracking-[0.1em] drop-shadow-md text-gray-100">
                                    {{ chunk_split($gift['account_number'], 4, ' ') }}
                                </div>
                                <div class="text-[10px] bg-white/20 px-2 py-1 rounded"><i class="fa-regular fa-copy"></i></div>
                            </div>

                            <div class="flex justify-between items-end mt-auto">
                                <div>
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <span
                                            class="text-[0.4rem] leading-tight uppercase text-gray-300 w-6">Valid<br>Thru</span>
                                        <span class="font-mono text-xs">Forever</span>
                                    </div>
                                    <div class="font-bold tracking-widest uppercase text-xs truncate max-w-[150px]">
                                        {{ $gift['account_name'] }}
                                    </div>
                                </div>
                                <div class="flex -space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-red-600/90 mix-blend-hard-light"></div>
                                    <div class="w-6 h-6 rounded-full bg-blue-600/90 mix-blend-hard-light"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            @if (!empty($theme['gift_address']))
                <div class="mt-8 bg-white/80 border border-yellow-900/20 rounded-2xl p-6 shadow-sm" data-anim="fade-up">
                    <div class="flex items-center gap-2 mb-2 text-[#5E4926]">
                        <i class="fa-solid fa-gift"></i>
                        <span class="font-serif font-bold">Alamat Pengiriman Kado</span>
                    </div>
                    <p class="text-sm text-[#7C6339] leading-relaxed">{{ $theme['gift_address'] }}</p>
                </div>
            @endif
        </section>
    @endif

    {{-- DRESS CODE --}}
    @php
        $dressCode = $invitation->dress_code_data ?? [];
        $isDressCodeEnabled = $invitation->hasFeature('dress_code') && ($dressCode['enabled'] ?? false);
    @endphp
    @if($isDressCodeEnabled)
        <section class="p-8 bg-cover bg-no-repeat bg-[url('/public/img/bg/paper2.png')]">
            <div data-anim="fade-up" class="text-center mb-8">
                 <div class="py-4 mx-auto w-fit px-6 flex justify-center items-center text-center bg-contain p-2 bg-no-repeat bg-[url('/public/img/assets/masking-tape-red.png')]">
                    <h1 class="font-serif font-semibold mt-3 text-white/80 text-xl uppercase">{{ $dressCode['title'] ?? 'Dress Code' }}</h1>
                </div>
            </div>

            <div class="max-w-lg mx-auto text-center" data-anim="fade-up">
                <p class="font-serif text-lg text-[#7C6339] mb-8 leading-relaxed">{{ $dressCode['description'] ?? '' }}</p>

                @if(!empty($dressCode['colors']))
                    <div class="flex flex-wrap justify-center gap-6 mb-10">
                        @foreach($dressCode['colors'] as $color)
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-10 h-10 rounded-full shadow-md border-2 border-white" style="background-color: {{ $color }}"></div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($dressCode['image']))
                    <div class="mb-10 p-3 bg-white shadow-lg rotate-1 transform hover:rotate-0 transition duration-500 rounded-sm">
                        <img src="{{ asset($dressCode['image']) }}" class="w-full object-cover">
                    </div>
                @endif

                 @if(!empty($dressCode['notes']))
                    <div class="border-t border-b border-[#7C6339]/30 py-4 my-4">
                        <p class="font-serif italic text-[#7C6339] text-sm">
                            <span class="font-bold not-italic block mb-1">Note:</span>
                            {{ $dressCode['notes'] }}
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- 7. RSVP & GUEST BOOK --}}
    @php
        $hasRsvp = $invitation->hasFeature('rsvp');
        $hasGuestbook = $invitation->hasFeature('guestbook');
    @endphp
    @if($hasRsvp || $hasGuestbook)
    <div class="shadow-2xl shadow-black/50 bg-[url('/public/img/bg/paper2.png')] pb-12">
        @if($hasRsvp)
            <div class="p-4 theme-scope" data-anim="fade-up">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        @endif

        @if($hasRsvp && $hasGuestbook)
            <div class="flex items-center gap-4 my-8 justify-center opacity-50">
                <div class="h-px theme-bg w-16"></div>
                <i class="fa-solid fa-heart theme-text"></i>
                <div class="h-px theme-bg w-16"></div>
            </div>
        @endif

        @if($hasGuestbook)
            <div class="p-4 bg-white/80 mx-4 rounded-xl"
                data-anim="fade-up">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        @endif
    </div>
    @endif

    {{-- 8. CLOSING / THANK YOU --}}
    <div class="bg-[#FDFBF7] py-16 px-6 font-sans text-[#333]">
        <div class="space-y-8" data-anim="fade-up" data-duration="1s">
            <div class="text-center px-2">
                <div class="font-['Courier_Prime'] text-base text-gray-700 leading-relaxed">
                    <div class="flex items-end gap-2 mb-1">
                        <span class="font-bold">Dear</span>
                        <div class="flex-1 border-b border-gray-400"></div>
                    </div>
                    <div class="flex items-end gap-2 mb-1">
                        <div class="w-1/4 border-b border-gray-400"></div>
                        <span>our beloved</span>
                        <div class="w-full border-b border-gray-400"></div>
                    </div>
                    <div class="text-right mt-2 text-sm tracking-wider text-gray-800">Family & Friends</div>
                </div>
            </div>

            <div class="relative py-4 flex justify-center">
                <h1 class="font-['Kalam'] text-4xl text-[#C04A3A] rotate-[-3deg] relative z-10 font-bold tracking-wide"
                    style="text-shadow: 1px 1px 0px rgba(0,0,0,0.1);">
                    Thank You
                </h1>
            </div>

            <div
                class="relative bg-[#fcf6ef] shadow-md p-6 pt-10 pb-8 rotate-[1deg] transform transition hover:rotate-0 duration-500">
                <div class="absolute inset-0 w-full h-full pointer-events-none"
                    style="background-image: repeating-linear-gradient(transparent, transparent 31px, #9ca3af 32px); background-position: 0 24px;">
                </div>
                <div class="absolute top-0 bottom-0 left-8 w-[1px] bg-red-300/60 h-full z-0"></div>
                <div class="relative z-10 font-['Nanum_Pen_Script'] text-2xl text-[#b04030] leading-[32px] pl-6">
                    <p class="mb-6">for being part of our lives and supporting us through our journey.</p>
                    <p class="mb-6">We were so blessed to have you celebrate and be a part of our wedding day.</p>
                    <div class="text-right">See you!</div>
                    <div class="mt-4 flex justify-end">
                        <div class="w-24 h-1 bg-gray-600/20 rounded-full skew-x-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="w-full py-12 relative bg-[#FDFBF7]" data-anim="fade-up">
        <div
            class="absolute top-0 left-1/2 transform -translate-x-1/2 w-24 h-[1px] bg-gradient-to-r from-transparent via-[#D4C5A5] to-transparent">
        </div>
        <a href="https://arvayadeaure.com" target="_blank"
            class="group flex flex-col items-center justify-center gap-3 no-underline cursor-pointer">
            <div class="relative">
                <div
                    class="absolute inset-0 rounded-full border border-dashed border-[#D4C5A5] opacity-50 group-hover:rotate-180 transition-transform duration-700 ease-in-out">
                </div>
                <img src="{{ asset('img/favicon/1.png') }}" alt="Logo"
                    class="w-12 h-12 rounded-full object-cover p-1 bg-white shadow-sm relative z-10 group-hover:scale-105 transition-transform duration-300">
            </div>
            <div class="text-center">
                <h3
                    class="font-serif text-[#5E4926] text-sm tracking-[0.2em] uppercase group-hover:text-[#8C6E33] transition-colors duration-300 mb-1">
                    Arvaya De Aure</h3>
                <p class="font-sans text-[10px] text-[#9A7D4C] tracking-wide opacity-70">Official Website &bull; 2025
                </p>
            </div>
        </a>
    </footer>

</div>

<script>
    function countdown(eventDate) {
        return {
            eventTime: new Date(eventDate).getTime(),
            now: Date.now(),
            timer: null,
            start() {
                this.timer = setInterval(() => { this.now = Date.now() }, 1000)
            },
            get diff() { return Math.max(this.eventTime - this.now, 0) },
            get days() { return Math.floor(this.diff / (1000 * 60 * 60 * 24)) },
            get hours() { return Math.floor((this.diff / (1000 * 60 * 60)) % 24) },
            get minutes() { return Math.floor((this.diff / (1000 * 60)) % 60) },
            get seconds() { return Math.floor((this.diff / 1000) % 60) }
        }
    }

    // Loading Logic
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function () {
        const fill = document.getElementById('coffee-fill');
        const info = document.getElementById('loading-info');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');

        if (fill) {
            fill.classList.remove('translate-y-full');
            fill.classList.add('translate-y-[15%]');
        }

        setTimeout(() => {
            if (info) info.style.display = 'none';
            if (btn) {
                btn.classList.remove('hidden');
                setTimeout(() => {
                    btn.classList.remove('opacity-0', 'scale-90');
                    btn.classList.add('opacity-100', 'scale-100');
                }, 50);
            }
        }, 1200);

        if (btn) {
            btn.addEventListener('click', function () {
                if (overlay) overlay.style.opacity = '0';
                document.body.style.overflow = 'auto';
                setTimeout(() => {
                    if (overlay) overlay.remove();
                    window.dispatchEvent(new CustomEvent('play-music'));
                }, 700);
            });
        }
    });
</script>