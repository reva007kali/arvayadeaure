@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    // Fallback Images - Ensure high contrast or BW in CSS
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=000000&color=ffffff&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];

    if (isset($galleryData[0]) && empty($moments)) {
        $moments = $galleryData;
    }

    $event = $invitation->event_data[0] ?? [];
    $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
@endphp

@slot('head')
<title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Swiss Style</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- Inter Font for that Neo-Grotesque Swiss Look --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;900&display=swap" rel="stylesheet">
@endslot

<style>
    :root {
        --font-main: 'Inter', sans-serif;
        --c-black: #000000;
        --c-white: #FFFFFF;
        --c-gray: #F4F4F4;
    }

    body {
        font-family: var(--font-main);
        background-color: var(--c-white);
        color: var(--c-black);
        -webkit-font-smoothing: antialiased;
    }

    .theme-bg {
        background-color: var(--c-black);
    }

    /* Swiss Typography Utilities */
    .swiss-title {
        font-weight: 900;
        letter-spacing: -0.04em;
        line-height: 0.85;
        text-transform: uppercase;
    }

    .swiss-subtitle {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
    }

    .swiss-body {
        font-weight: 300;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Brutalist / Minimal Inputs */
    input, textarea, select {
        background: transparent !important;
        border: none !important;
        border-bottom: 2px solid black !important;
        border-radius: 0 !important;
        padding: 10px 0 !important;
        color: black !important;
        font-weight: 600;
        font-family: var(--font-main);
        outline: none !important;
        box-shadow: none !important;
    }
    
    input::placeholder, textarea::placeholder {
        color: #999;
        font-weight: 300;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    input:focus, textarea:focus {
        border-bottom: 4px solid black !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: #fff; }
    ::-webkit-scrollbar-thumb { background: #000; }

    /* Loading Screen Animation */
    @keyframes slideUp {
        0% { transform: translateY(0); }
        100% { transform: translateY(-100%); }
    }
</style>

{{-- ======================================================================= --}}
{{-- SWISS LOADING SCREEN --}}
{{-- ======================================================================= --}}
<div id="loading-overlay" class="fixed inset-0 z-[9999] bg-black text-white flex flex-col justify-between p-8 transition-all duration-1000 ease-[cubic-bezier(0.76,0,0.24,1)]">
    <!-- Top Left Date -->
    <div class="flex justify-between items-start border-b border-white/20 pb-4">
        <span class="text-xs font-bold uppercase tracking-widest">Wedding<br>Invitation</span>
        <span class="text-xs font-mono">{{ date('Y') }}</span>
    </div>

    <!-- Center Counter -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full text-center">
        <div class="text-[12rem] md:text-[18rem] font-black leading-none tracking-tighter" id="loading-counter">
            00
        </div>
        <div class="mt-4 text-sm uppercase tracking-[0.5em] animate-pulse">Loading Invitation</div>
    </div>

    <!-- Bottom Action -->
    <div class="flex justify-between items-end border-t border-white/20 pt-4">
        <div class="text-xs max-w-[150px]">
            To: {{ $guest->name ?? 'Guest' }}
        </div>
        
        <button id="open-invitation-btn" class="hidden group relative px-8 py-3 bg-white text-black text-xs font-black uppercase tracking-widest hover:bg-gray-200 transition-colors">
            <span class="relative z-10">Open Invitation</span>
        </button>
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function () {
        const counter = document.getElementById('loading-counter');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');
        
        let count = 0;
        const interval = setInterval(() => {
            count += Math.floor(Math.random() * 5) + 1;
            if(count > 100) count = 100;
            counter.innerText = count < 10 ? `0${count}` : count;
            
            if(count === 100) {
                clearInterval(interval);
                setTimeout(() => {
                    btn.classList.remove('hidden');
                }, 200);
            }
        }, 30);

        btn.addEventListener('click', function () {
            // Curtain effect
            overlay.style.transform = 'translateY(-100%)';
            document.body.style.overflow = 'auto';
            window.dispatchEvent(new CustomEvent('play-music'));
            
            setTimeout(() => {
                overlay.remove();
            }, 1000);
        });
    });
</script>


<div class="relative bg-white min-h-screen max-w-md mx-auto border-x border-gray-200 shadow-2xl" data-anim-stagger="0.1s">

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed top-6 right-6 z-[900] mix-blend-difference print:hidden">
            <button @click="togglePlay"
                class="flex items-center gap-2 text-white font-bold uppercase text-[10px] tracking-widest hover:opacity-70 transition">
                <span x-text="isPlaying ? 'PAUSE' : 'PLAY'"></span>
                <div class="w-2 h-2 bg-white" :class="isPlaying ? 'animate-pulse' : ''"></div>
            </button>
            <div class="hidden"><div id="yt-player-container"></div></div>
        </div>
    @endif

    {{-- 1. HERO SECTION --}}
    <section class="min-h-screen flex flex-col pt-12 border-b-4 border-black relative" data-anim-stagger="0.1s">
        <!-- Header -->
        <div class="px-6 mb-8 flex justify-between items-end" data-anim="fade-up">
            <p class="swiss-subtitle">The<br>Wedding<br>Celebration</p>
            <p class="swiss-subtitle text-right">No. 01<br>{{ date('Y') }}</p>
        </div>

        <!-- Big Type -->
        <div class="px-6 mb-8" data-anim="fade-up">
            <h1 class="swiss-title text-5xl md:text-6xl break-words" data-anim="fade-up">
                {{ strtoupper($groom['nickname'] ?? 'G') }}<br>
                <span class="text-transparent text-stroke-2" style="-webkit-text-stroke: 2px black;">&</span><br>
                {{ strtoupper($bride['nickname'] ?? 'B') }}
            </h1>
        </div>

        <!-- Image Block -->
        <div class="flex-1 w-full bg-gray-100 relative mt-auto border-t-2 border-black">
            <img src="{{ $coverImage }}" class="absolute inset-0 w-full h-full object-cover object-top grayscale contrast-125" alt="Cover">
            
            <!-- Sticky Note Style Date -->
            <div class="absolute top-0 right-0 bg-black text-white p-4 min-w-[120px]">
                @if($eventDate)
                    <div class="text-center">
                        <span class="block text-4xl font-black leading-none">{{ $eventDate->format('d') }}</span>
                        <span class="block text-xs uppercase tracking-widest border-t border-white/30 pt-1 mt-1">{{ $eventDate->format('M') }}</span>
                    </div>
                @endif
            </div>

            <!-- Guest Name Badge -->
            <div class="absolute bottom-0 left-0 bg-white border-t-2 border-r-2 border-black p-4">
                <p class="text-[10px] uppercase tracking-widest text-gray-500 mb-1">Invited Guest</p>
                <p class="font-bold text-lg leading-none">{{ $guest->name ?? 'Tamu Undangan' }}</p>
            </div>
        </div>
    </section>

    {{-- 2. QUOTE SECTION (Typographic) --}}
    <section class="py-20 px-6 border-b border-black" data-anim-stagger="0.1s">
        <div class="max-w-xs mx-auto text-center">
            <div data-anim="fade-up" class="w-1 h-12 bg-black mx-auto mb-8"></div>
            @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
            
            <div data-anim="fade-up" class="text-2xl font-light italic leading-tight mb-6">
                @if ($qs && ($qs['type'] ?? '') === 'quran')
                    "{{ $qs['translation'] ?? '' }}"
                @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                    "{{ $qs['verse_text'] ?? '' }}"
                @else
                    "{{ $invitation->couple_data['quote'] ?? 'Two souls, one heart.' }}"
                @endif
            </div>
            
            <p data-anim="fade-up" class="swiss-subtitle text-gray-500">{{ $qs['source'] ?? 'Ref.' }}</p>
        </div>
    </section>

    {{-- 3. COUPLE PROFILE --}}
    <section class="bg-black text-white" data-anim-stagger="0.1s">
        <!-- Groom -->
        <div class="grid grid-cols-2 border-b border-white/20">
            <div data-anim="fade-up" class="aspect-[4/5] relative border-r border-white/20">
                <img src="{{ asset($groomImage) }}" class="absolute inset-0 w-full h-full object-cover grayscale hover:grayscale-0 transition duration-700">
            </div>
            <div data-anim="fade-up" class="p-6 flex flex-col justify-center">
                <span class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">01 / The Groom</span>
                <h2 class="text-3xl font-black uppercase leading-none mb-4 break-words">{{ $groom['fullname'] }}</h2>
                <div class="mt-auto text-sm font-light text-gray-400">
                    <p>Son of:</p>
                    <p class="text-white">{{ $groom['father'] }}</p>
                    <p class="text-white">& {{ $groom['mother'] }}</p>
                </div>
            </div>
        </div>

        <!-- Bride -->
        <div class="grid grid-cols-2">
            <div data-anim="fade-up" class="p-6 flex flex-col justify-center text-right border-r border-white/20">
                <span class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">02 / The Bride</span>
                <h2 class="text-3xl font-black uppercase leading-none mb-4 break-words">{{ $bride['fullname'] }}</h2>
                <div class="mt-auto text-sm font-light text-gray-400">
                    <p>Daughter of:</p>
                    <p class="text-white">{{ $bride['father'] }}</p>
                    <p class="text-white">& {{ $bride['mother'] }}</p>
                </div>
            </div>
            <div data-anim="fade-up" class="aspect-[4/5] relative">
                <img src="{{ asset($brideImage) }}" class="absolute inset-0 w-full h-full object-cover grayscale hover:grayscale-0 transition duration-700">
            </div>
        </div>
    </section>

    {{-- 4. EVENT DETAILS --}}
    @if($invitation->theme_config['events_enabled'] ?? true)
    <section class="py-24 px-6 relative bg-gray-50" data-anim-stagger="0.1s">
        <!-- Vertical Line -->
        <div data-anim="fade-up" class="absolute left-6 top-0 bottom-0 w-px bg-black hidden md:block"></div>

        <div class="md:pl-12">
            <h2 class="swiss-title text-5xl mb-12">Schedule<br>of Events</h2>

            @foreach($invitation->event_data as $index => $event)
                @php $eDate = \Carbon\Carbon::parse($event['date']); @endphp
                <div class="mb-12 last:mb-0 border-l-4 border-black pl-6 ml-1 md:ml-0" data-anim="fade-up">
                    <span class="swiss-subtitle bg-black text-white px-2 py-1 inline-block mb-4">Event 0{{ $index + 1 }}</span>
                    
                    <h3 class="text-3xl font-bold uppercase mb-2">{{ $event['title'] }}</h3>
                    
                    <!-- Grid Info -->
                    <div class="grid grid-cols-2 gap-y-4 gap-x-8 border-t border-b border-black py-4 mb-4">
                        <div>
                            <span class="text-[10px] uppercase text-gray-500 block">Date</span>
                            <span class="font-bold">{{ $eDate->translatedFormat('l, d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase text-gray-500 block">Time</span>
                            <span class="font-bold">{{ $eDate->format('H:i') }} WIB</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[10px] uppercase text-gray-500 block">Location</span>
                            <span class="font-bold">{{ $event['location'] }}</span>
                            <p class="text-sm font-normal text-gray-600 mt-1">{{ $event['address'] }}</p>
                        </div>
                    </div>

                    @if(!empty($event['map_link']))
                        <a href="{{ $event['map_link'] }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-black uppercase border-b-2 border-black pb-1 hover:text-gray-600 transition">
                            View On Google Maps <i class="fa-solid fa-arrow-right -rotate-45"></i>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Simple Countdown --}}
        @if(isset($eventDate))
            <div data-anim-stagger="0.2s" x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()" class="mt-20 border-2 border-black p-6 bg-white">
                <p class="swiss-subtitle text-center mb-6">Countdown to Ceremony</p>
                <div class="flex justify-between items-center text-center">
                    <div data-anim="fade-up" class="flex-1"><span class="text-3xl font-black block" x-text="days">00</span><span class="text-[9px] uppercase">Days</span></div>
                    <div class="w-px h-8 bg-black"></div>
                    <div data-anim="fade-up" class="flex-1"><span class="text-3xl font-black block" x-text="hours">00</span><span class="text-[9px] uppercase">Hrs</span></div>
                    <div data-anim="fade-up" class="w-px h-8 bg-black"></div>
                    <div data-anim="fade-up" class="flex-1"><span class="text-3xl font-black block" x-text="minutes">00</span><span class="text-[9px] uppercase">Min</span></div>
                </div>
            </div>
        @endif
    </section>
    @endif

    {{-- DRESS CODE --}}
    @php $dressCode = $invitation->dress_code_data ?? []; @endphp
    @if($invitation->hasFeature('dress_code') && ($dressCode['enabled'] ?? false))
    <section class="border-t-4 border-black py-16 px-6 bg-white text-center" data-anim-stagger="0.1s">
        <h2 data-anim="fade-up" class="swiss-subtitle mb-8 decoration-wavy underline decoration-2">Dress Code</h2>
        <p data-anim="fade-up" class="text-xl font-bold mb-6 max-w-xs mx-auto leading-tight">{{ $dressCode['description'] ?? 'Formal Attire' }}</p>
        
        @if(!empty($dressCode['colors']))
            <div data-anim="fade-up" class="flex justify-center gap-4 mb-6">
                @foreach($dressCode['colors'] as $color)
                    <div class="group relative">
                        <div class="w-12 h-12 border-2 border-black rounded-none shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-transform group-hover:-translate-y-1" style="background-color: {{ $color }}"></div>
                    </div>
                @endforeach
            </div>
        @endif
        
        @if(!empty($dressCode['notes']))
            <p data-anim="fade-up" class="text-xs font-mono bg-gray-100 inline-block px-3 py-1">NOTE: {{ $dressCode['notes'] }}</p>
        @endif
    </section>
    @endif

    {{-- VIDEO --}}
    @if($invitation->theme_config['video_enabled'] ?? true)
        @php 
            $videoUrl = trim($invitation->theme_config['video_url'] ?? '');
            $videoId = '';
            if ($videoUrl) {
                if (preg_match('/[?&]v=([^&]+)/', $videoUrl, $m)) {
                    $videoId = $m[1];
                } elseif (preg_match('#youtu\.be/([^?&/]+)#', $videoUrl, $m)) {
                    $videoId = $m[1];
                } elseif (preg_match('#youtube\.com/embed/([^?&/]+)#', $videoUrl, $m)) {
                    $videoId = $m[1];
                }
            }
        @endphp
        @if(!empty($videoId))
        <section class="bg-black p-6" data-anim-stagger="0.1s">
            <div data-anim="zoom-in" class="border border-white/30 p-1">
                <div class="aspect-video w-full bg-gray-900">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
        </section>
        @endif
    @endif

    {{-- GALLERY (Grid) --}}
    @if (!empty($moments) && ($invitation->gallery_data['enabled'] ?? true))
    <section class="border-t border-black">
        <div data-anim="fade-up" class="py-4 px-6 border-b border-black flex justify-between items-center bg-gray-50">
            <h2 class="swiss-subtitle">Visual Records</h2>
            <span class="text-xs font-mono">({{ count($moments) }})</span>
        </div>
        
        <div data-anim-stagger="0.1s" class="grid grid-cols-2 md:grid-cols-3" x-data="{ photoOpen: false, photoSrc: '' }">
            @foreach ($moments as $photo)
                <div data-anim="zoom-in" class="aspect-square relative group bdataanir-r border-b border-black cursor-zoom-in overflow-hidden"
                     @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                    <img src="{{ asset($photo) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <span class="text-white font-mono text-xs">[VIEW]</span>
                    </div>
                </div>
            @endforeach

            <!-- Modal -->
            <div x-show="photoOpen" class="fixed inset-0 z-[9999] bg-white flex flex-col" x-transition.opacity>
                <div class="flex justify-between items-center p-4 border-b-2 border-black">
                    <span class="swiss-subtitle">Image Viewer</span>
                    <button @click="photoOpen = false" class="text-2xl hover:rotate-90 transition">&times;</button>
                </div>
                <div class="flex-1 flex items-center justify-center p-4 bg-gray-100">
                    <img :src="photoSrc" class="max-w-full max-h-full border-2 border-black shadow-[10px_10px_0px_0px_rgba(0,0,0,1)]">
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- GIFTS & RSVP --}}
    @php
        $hasRsvp = $invitation->hasFeature('rsvp');
        $hasGifts = $invitation->theme_config['gifts_enabled'] ?? true;
        $gifts = $invitation->gifts_data ?? [];
    @endphp

    @if($hasRsvp || $hasGifts)
    <section class="py-24 px-6 bg-white relative" data-anim-stagger="0.1s">
        
        {{-- GIFTS --}}
        @if($hasGifts && !empty($gifts))
            <div class="mb-20">
                <h2 data-anim="zoom-in" class="swiss-title text-4xl mb-8">Gift<br>Registry</h2>
                
                <div class="space-y-6">
                    @foreach ($gifts as $gift)
                    <div data-anim="zoom-in" class="border-2 border-black p-6 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all duration-200">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-black text-xl uppercase">{{ $gift['bank_name'] }}</h3>
                            <i class="fa-solid fa-credit-card text-xl"></i>
                        </div>
                        <div class="font-mono text-lg tracking-wider mb-2 border-b border-dashed border-black pb-2">
                            {{ $gift['account_number'] }}
                        </div>
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-[10px] uppercase text-gray-500">Beneficiary</span>
                                <p class="font-bold uppercase text-sm">{{ $gift['account_name'] }}</p>
                            </div>
                            <button onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied')" 
                                    class="bg-black text-white px-4 py-2 text-xs font-bold uppercase hover:bg-gray-800">
                                Copy
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- RSVP --}}
        @if($hasRsvp)
            <div class="border-t-4 border-black pt-12">
                <h2 class="swiss-title text-4xl mb-8">RSVP<br>Form</h2>
                
                <form class="space-y-8">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </form>
            </div>
        @endif
    </section>
    @endif

    {{-- GUESTBOOK --}}
    @if($invitation->hasFeature('guestbook') && ($invitation->theme_config['guest_book_enabled'] ?? true))
    <section class="py-16 px-2 bg-zinc-200 border-t border-white/20" data-anim-stagger="0.1s">
        <h2 class="text-xl font-bold uppercase mb-8 text-center">Digital Guestbook</h2>
        <div class="border-2 p-4 border-blackk bg-white">
             {{-- Styling for livewire component children via CSS --}}
            @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </section>
    @endif

    {{-- FOOTER --}}
    <footer class="py-12 px-6 border-t border-black text-center bg-gray-50">
        <h1 class="swiss-title text-3xl mb-4">THANK YOU</h1>
        <p class="swiss-body text-sm text-gray-600 mb-8 max-w-xs mx-auto">
            "{{ $invitation->theme_config['thank_you_message'] ?? 'We look forward to celebrating with you.' }}"
        </p>
        
        <div class="inline-block border border-black px-4 py-2">
            <p class="text-[10px] font-mono uppercase tracking-widest">
                Created by Arvaya &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

</div>

<script>
    function countdown(date) {
        return {
            target: new Date(date).getTime(),
            now: new Date().getTime(),
            days: '00', hours: '00', minutes: '00',
            start() {
                setInterval(() => {
                    this.now = new Date().getTime();
                    const d = this.target - this.now;
                    if (d > 0) {
                        this.days = String(Math.floor(d / (1000 * 60 * 60 * 24))).padStart(2, '0');
                        this.hours = String(Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((d % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    }
                }, 1000);
            }
        }
    }
</script>
