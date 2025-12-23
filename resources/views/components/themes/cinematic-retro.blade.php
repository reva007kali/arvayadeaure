@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    // Fallback Images
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
<title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Cinematic Wedding</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- Fonts: 'Sacramento' for the retro script, 'Montserrat' for the cinematic clean text --}}
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Sacramento&display=swap" rel="stylesheet">
@endslot

<style>
    :root {
        --font-script: 'Sacramento', cursive;
        --font-body: 'Montserrat', sans-serif;
        --c-accent: #FFD700; /* Retro Yellow/Gold */
        --c-dark: #0f0f0f;
        --c-light: #f5f5f5;
    }

    body {
        font-family: var(--font-body);
        background-color: var(--c-dark);
        color: var(--c-light);
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }

    /* Film Grain Overlay */
    .film-grain {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 50;
        opacity: 0.05;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='1'/%3E%3C/svg%3E");
    }

    /* Cinematic Typography */
    .retro-script {
        font-family: var(--font-script);
        color: var(--c-accent);
        text-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
    }


    .theme-bg {
background-color: #e4ca37;
    }

    .cine-title {
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-weight: 600;
    }

    /* Form Styling */
    input, textarea, select {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 4px !important;
        padding: 12px !important;
        color: white !important;
        font-family: var(--font-body);
        backdrop-filter: blur(5px);
    }
    
    input:focus, textarea:focus {
        border-color: var(--c-accent) !important;
        outline: none !important;
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.1) !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #0f0f0f; }
    ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }

    /* Utilities */
    .text-shadow-sm { text-shadow: 0 2px 4px rgba(0,0,0,0.8); }
    .glass-panel {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

{{-- Film Grain Texture --}}
<div class="film-grain"></div>

{{-- LOADING SCREEN --}}
<div id="loading-overlay" class="fixed inset-0 z-[9999] bg-[#0a0a0a] flex flex-col justify-center items-center transition-all duration-1000" style="background-image: url('{{ $coverImage }}'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black/80"></div>
    <div class="relative text-center">
        <h1 class="retro-script text-6xl md:text-7xl mb-4 animate-pulse">Our Wedding Day</h1>
        <div class="w-32 h-0.5 bg-yellow-500/50 mx-auto rounded-full mb-4"></div>
        <p class="cine-title text-xs text-gray-400">Loading Scene...</p>
        <div class="mt-8 text-yellow-500 font-mono text-xl" id="loading-percentage">0%</div>
        
        <button id="open-invitation-btn" class="hidden mt-8 px-8 py-3 rounded-full border border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-500 uppercase tracking-widest text-xs font-bold">
            Play Movie
        </button>
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function () {
        const percent = document.getElementById('loading-percentage');
        const btn = document.getElementById('open-invitation-btn');
        const overlay = document.getElementById('loading-overlay');
        
        let count = 0;
        const interval = setInterval(() => {
            count += 2;
            if(count > 100) count = 100;
            percent.innerText = count + '%';
            
            if(count === 100) {
                clearInterval(interval);
                percent.style.display = 'none';
                btn.classList.remove('hidden');
            }
        }, 30);

        btn.addEventListener('click', function () {
            overlay.style.opacity = '0';
            document.body.style.overflow = 'auto';
            window.dispatchEvent(new CustomEvent('play-music'));
            setTimeout(() => { overlay.remove(); }, 1000);
        });
    });
</script>


<div class="relative min-h-screen max-w-md mx-auto bg-[#0a0a0a] shadow-2xl overflow-hidden">

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed top-6 right-6 z-[900] print:hidden">
            <button @click="togglePlay"
                class="w-10 h-10 rounded-full border border-white/20 bg-black/50 backdrop-blur-md flex items-center justify-center text-yellow-500 hover:scale-110 transition">
                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-music'"></i>
            </button>
            <div class="hidden"><div id="yt-player-container"></div></div>
        </div>
    @endif

    {{-- 1. CINEMATIC HERO POSTER --}}
    <section class="relative h-screen w-full flex flex-col justify-between overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $coverImage }}" class="w-full h-full object-cover opacity-80" alt="Cover">
            {{-- Vignette Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/90"></div>
        </div>

        {{-- Top Content --}}
        <div class="relative z-10 pt-16 px-6 text-center" data-anim="fade-down">
            <h1 class="retro-script text-6xl md:text-7xl transform -rotate-6 text-[#FFD700] drop-shadow-lg">
                Our Wedding<br><span class="ml-12">Day</span>
            </h1>
        </div>

        {{-- Center Play Button Visual --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10" data-anim="zoom-in">
            <div class="w-16 h-16 rounded-full bg-white/10 backdrop-blur-sm border border-white/30 flex items-center justify-center animate-pulse">
                <i class="fa-solid fa-play text-2xl text-white/80 ml-1"></i>
            </div>
        </div>

        {{-- Bottom Content --}}
        <div class="relative z-10 pb-12 px-6 w-full" data-anim="fade-up">
            <div class="flex justify-between items-end text-white border-b border-white/20 pb-4 mb-4">
                <div class="text-left">
                    <h2 class="cine-title text-xl text-[#FFD700] mb-1">{{ $groom['nickname'] ?? 'Groom' }}</h2>
                    <p class="text-xs uppercase tracking-widest opacity-70">Irama</p>
                </div>
                <div class="text-right">
                    <h2 class="cine-title text-xl text-[#FFD700] mb-1">{{ $bride['nickname'] ?? 'Bride' }}</h2>
                    <p class="text-xs uppercase tracking-widest opacity-70">Melodi</p>
                </div>
            </div>

            <div class="text-center">
                @if($eventDate)
                    <p class="text-2xl font-light tracking-[0.2em] mb-2">{{ $eventDate->format('d . m . Y') }}</p>
                @endif
                <p class="text-[10px] uppercase tracking-widest italic text-gray-400">Please save the date for our special day.</p>
                
                <div class="mt-6 animate-bounce text-white/50">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. QUOTE (Subtitle Style) --}}
    <section class="py-20 px-8 bg-[#0a0a0a] text-center relative" data-anim="fade-up">
        @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
        
        <i class="fa-solid fa-quote-left text-yellow-600/30 text-4xl mb-6"></i>
        
        <div class="font-body font-light text-lg md:text-xl leading-relaxed text-gray-300 italic mb-6">
            @if ($qs && ($qs['type'] ?? '') === 'quran')
                "{{ $qs['translation'] ?? '' }}"
            @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                "{{ $qs['verse_text'] ?? '' }}"
            @else
                "{{ $invitation->couple_data['quote'] ?? 'Love is composed of a single soul inhabiting two bodies.' }}"
            @endif
        </div>
        
        <p class="cine-title text-xs text-[#FFD700] opacity-80">— {{ $qs['source'] ?? 'The Wedding' }} —</p>
    </section>

    {{-- 3. THE COUPLE (Starring Roles) --}}
    <section class="bg-[#0f0f0f] py-10" data-anim="fade-up">
        <div class="text-center mb-10">
            <span class="text-[10px] uppercase tracking-[0.3em] text-gray-500">Starring</span>
        </div>

        {{-- Groom --}}
        <div class="relative mb-1">
            <div class="h-80 w-full overflow-hidden relative group">
                <img src="{{ asset($groomImage) }}" class="w-full h-full object-cover object-center filter contrast-125 group-hover:grayscale-0 transition duration-1000">
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-6 pt-20">
                    <h3 class="retro-script text-4xl text-[#FFD700] mb-1">{{ $groom['fullname'] }}</h3>
                    <p class="text-xs text-gray-300 uppercase tracking-widest">The Groom</p>
                    <p class="text-[10px] text-gray-500 mt-2">Son of Mr. {{ $groom['father'] }} & Mrs. {{ $groom['mother'] }}</p>
                </div>
            </div>
        </div>

        {{-- Bride --}}
        <div class="relative">
            <div class="h-80 w-full overflow-hidden relative group">
                <img src="{{ asset($brideImage) }}" class="w-full h-full object-cover object-center filter contrast-125 group-hover:grayscale-0 transition duration-1000">
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-6 pt-20 text-right">
                    <h3 class="retro-script text-4xl text-[#FFD700] mb-1">{{ $bride['fullname'] }}</h3>
                    <p class="text-xs text-gray-300 uppercase tracking-widest">The Bride</p>
                    <p class="text-[10px] text-gray-500 mt-2">Daughter of Mr. {{ $bride['father'] }} & Mrs. {{ $bride['mother'] }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. PREMIERE (Event Details) --}}
    @if($invitation->theme_config['events_enabled'] ?? true)
    <section class="py-20 px-6 bg-[#0a0a0a] relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(#FFD700 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative z-10 text-center mb-12" data-anim="fade-up">
            <h2 class="retro-script text-5xl text-white mb-2">The Premiere</h2>
            <p class="text-[10px] uppercase tracking-[0.3em] text-[#FFD700]">Event Schedule</p>
        </div>

        @foreach($invitation->event_data as $index => $event)
            @php $eDate = \Carbon\Carbon::parse($event['date']); @endphp
            <div class="mb-10 glass-panel p-8 rounded-lg relative" data-anim="fade-up">
                {{-- Decorative Tape --}}
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-24 h-6 bg-yellow-500/20 rotate-1 backdrop-blur-sm"></div>

                <h3 class="cine-title text-xl text-white mb-6 border-b border-white/10 pb-4">{{ $event['title'] }}</h3>
                
                <div class="space-y-4 text-sm text-gray-300">
                    <div class="flex items-center gap-4">
                        <i class="fa-regular fa-calendar text-[#FFD700] w-6"></i>
                        <span class="uppercase tracking-wide">{{ $eDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <i class="fa-regular fa-clock text-[#FFD700] w-6"></i>
                        <span class="uppercase tracking-wide">{{ $eDate->format('H:i') }} WIB - Finish</span>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-location-dot text-[#FFD700] w-6 mt-1"></i>
                        <div>
                            <span class="font-bold text-white block">{{ $event['location'] }}</span>
                            <span class="text-xs opacity-70">{{ $event['address'] }}</span>
                        </div>
                    </div>
                </div>

                @if(!empty($event['map_link']))
                    <div class="mt-8 text-center">
                        <a href="{{ $event['map_link'] }}" target="_blank" class="inline-block px-6 py-2 border border-[#FFD700] text-[#FFD700] text-xs uppercase tracking-widest hover:bg-[#FFD700] hover:text-black transition duration-300 rounded-sm">
                            Show Map Location
                        </a>
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Countdown --}}
        @if(isset($eventDate))
            <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()" class="mt-16 text-center" data-anim="fade-up">
                <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-6">Countdown to Live</p>
                <div class="flex justify-center gap-4 md:gap-8 font-mono text-[#FFD700]">
                    <div><span class="text-3xl md:text-4xl block" x-text="days">00</span><span class="text-[9px] uppercase text-gray-400">Days</span></div>
                    <div class="text-2xl mt-1">:</div>
                    <div><span class="text-3xl md:text-4xl block" x-text="hours">00</span><span class="text-[9px] uppercase text-gray-400">Hrs</span></div>
                    <div class="text-2xl mt-1">:</div>
                    <div><span class="text-3xl md:text-4xl block" x-text="minutes">00</span><span class="text-[9px] uppercase text-gray-400">Min</span></div>
                    <div class="text-2xl mt-1">:</div>
                    <div><span class="text-3xl md:text-4xl block" x-text="seconds">00</span><span class="text-[9px] uppercase text-gray-400">Sec</span></div>
                </div>
            </div>
        @endif
    </section>
    @endif

    {{-- DRESS CODE --}}
    @php $dressCode = $invitation->dress_code_data ?? []; @endphp
    @if($invitation->hasFeature('dress_code') && ($dressCode['enabled'] ?? false))
    <section class="py-16 px-6 bg-[#0f0f0f] text-center border-t border-white/5" data-anim="fade-up">
        <h2 class="retro-script text-4xl text-[#FFD700] mb-2">Costume Design</h2>
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-8">Dress Code</p>
        
        <div class="glass-panel p-6 rounded-lg inline-block w-full">
            <p class="font-body text-lg text-white mb-6 italic">"{{ $dressCode['description'] ?? 'Formal Attire' }}"</p>
            
            @if(!empty($dressCode['colors']))
                <div class="flex justify-center gap-4 mb-6">
                    @foreach($dressCode['colors'] as $color)
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full shadow-lg border border-white/20" style="background-color: {{ $color }}"></div>
                            <span class="text-[8px] uppercase text-gray-500">{{ $color }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- VIDEO TEASER --}}
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
        <section class="bg-black py-10" data-anim="fade-up">
            <div class="text-center mb-6">
                <span class="retro-script text-3xl text-white">Official Teaser</span>
            </div>
            <div class="w-full aspect-video border-y border-yellow-900/50">
                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full opacity-90" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        </section>
        @endif
    @endif

    {{-- GALLERY (Film Strip) --}}
    @if (!empty($moments) && ($invitation->gallery_data['enabled'] ?? true))
    <section class="py-20 bg-[#0a0a0a]" x-data="{ photoOpen: false, photoSrc: '' }">
        <div class="text-center mb-10" data-anim="fade-up">
            <h2 class="retro-script text-5xl text-[#FFD700]">Captured Moments</h2>
        </div>

        <div class="grid grid-cols-2 gap-2 px-2" data-anim="fade-up">
            @foreach ($moments as $photo)
                <div class="aspect-[4/5] relative group overflow-hidden rounded-sm cursor-pointer"
                     @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                    <img src="{{ asset($photo) }}" class="w-full h-full object-cover opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition duration-700 transform group-hover:scale-110">
                    <div class="absolute inset-0 border border-white/10 pointer-events-none"></div>
                </div>
            @endforeach
        </div>

        <!-- Lightbox -->
        <div x-show="photoOpen" class="fixed inset-0 z-[9999] bg-black/95 flex items-center justify-center p-4 backdrop-blur-md" x-transition.opacity>
            <button @click="photoOpen = false" class="absolute top-4 right-4 text-white hover:text-[#FFD700] text-2xl transition">&times;</button>
            <img :src="photoSrc" class="max-w-full max-h-[85vh] rounded border border-[#FFD700]/30 shadow-2xl">
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
    <section class="py-20 px-6 bg-gradient-to-b from-[#0a0a0a] to-[#151515]" data-anim="fade-up">
        
        {{-- GIFTS --}}
        @if($hasGifts && !empty($gifts))
            <div class="mb-16 text-center">
                <h2 class="retro-script text-4xl text-white mb-8">Wedding Gift</h2>
                
                <div class="space-y-6">
@foreach ($gifts as $gift)
<div class="relative max-w-xs mx-auto bg-[#0a0a0a] border-2 border-dashed border-[#FFD700]/50 rounded-lg p-6 shadow-2xl transform hover:-translate-y-1 transition duration-300"
     style="background: radial-gradient(circle at top left, rgba(255,215,0,0.05) 0%, transparent 40%);">
    {{-- Ticket Perforation --}}
    <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#0a0a0a] rounded-r-full border-r-2 border-dashed border-[#FFD700]/50"></div>
    <div class="absolute -right-2 top-1/2 -translate-y-1/2 w-4 h-8 bg-[#0a0a0a] rounded-l-full border-l-2 border-dashed border-[#FFD700]/50"></div>

    {{-- Header --}}
    <div class="text-center border-b border-dashed border-[#FFD700]/30 pb-4 mb-4">
        <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500">Wedding Gift</p>
        <p class="font-bold text-[#FFD700] uppercase tracking-widest text-lg">{{ $gift['bank_name'] }}</p>
    </div>

    {{-- Body --}}
    <div class="text-center space-y-3">
        <p class="font-mono text-xl text-white tracking-widest">{{ $gift['account_number'] }}</p>
        <p class="text-xs text-gray-400 uppercase">a.n {{ $gift['account_name'] }}</p>
    </div>

    {{-- Footer --}}
    <div class="mt-6 text-center">
        <button onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied')" 
                class="w-full py-2 bg-[#FFD700]/10 hover:bg-[#FFD700] border border-[#FFD700]/50 text-[#FFD700] hover:text-black text-xs uppercase tracking-widest transition rounded">
            Copy Number
        </button>
        <p class="text-[8px] text-gray-600 mt-3 uppercase tracking-widest">Admit One Gift</p>
    </div>
</div>
@endforeach
                </div>
            </div>
        @endif

        {{-- RSVP --}}
        @if($hasRsvp)
            <div class="glass-panel p-6 rounded-lg border-t-4 border-[#FFD700]">
                <h2 class="cine-title text-xl text-center text-white mb-8">RSVP Confirmation</h2>
                
                <div class="space-y-6">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        @endif
    </section>
    @endif

    {{-- GUESTBOOK --}}
    @if($invitation->hasFeature('guestbook') && ($invitation->theme_config['guest_book_enabled'] ?? true))
    <section class="py-16 px-6 bg-[#0a0a0a]" data-anim="fade-up">
        <h2 class="retro-script text-4xl text-center text-[#FFD700] mb-8">Wishes & Prayers</h2>
        <div class="glass-panel p-4 rounded-lg h-96 overflow-y-auto">
            @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </section>
    @endif

    {{-- FOOTER --}}
    <footer class="py-12 px-6 bg-[#050505] text-center border-t border-white/10">
        <h1 class="retro-script text-3xl text-gray-500 mb-6">The End</h1>
        <p class="font-body text-xs text-gray-600 mb-6 max-w-xs mx-auto leading-relaxed">
            "{{ $invitation->theme_config['thank_you_message'] ?? 'Thank you for being part of our story.' }}"
        </p>
        
        <div class="flex justify-center items-center gap-2 opacity-30">
            <span class="h-px w-8 bg-white"></span>
            <img src="img/assets/golden-mocking-bird.png" class="w-6 h-6 grayscale">
            <span class="h-px w-8 bg-white"></span>
        </div>
        <p class="text-[10px] uppercase tracking-widest text-gray-700 mt-4">Powered by Arvaya</p>
    </footer>

</div>

<script>
    function countdown(date) {
        return {
            target: new Date(date).getTime(),
            now: new Date().getTime(),
            days: '00', hours: '00', minutes: '00', seconds: '00',
            start() {
                setInterval(() => {
                    this.now = new Date().getTime();
                    const d = this.target - this.now;
                    if (d > 0) {
                        this.days = String(Math.floor(d / (1000 * 60 * 60 * 24))).padStart(2, '0');
                        this.hours = String(Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                        this.minutes = String(Math.floor((d % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                        this.seconds = String(Math.floor((d % (1000 * 60)) / 1000)).padStart(2, '0');
                    }
                }, 1000);
            }
        }
    }
</script>