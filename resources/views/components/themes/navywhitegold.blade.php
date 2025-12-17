@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    $galleryData = $invitation->gallery_data ?? [];

    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=0e1b3a&color=D4AF37&size=200&name=';

    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }

    $eventDate = \Carbon\Carbon::parse($invitation->event_data[0]['date']);
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - Navy Gold Wedding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Playfair+Display:wght@400;600;800&family=Raleway:wght@300;400;600&display=swap"
        rel="stylesheet">
@endslot

<style>
    :root {
        --c-navy: #0e1b3a;
        --c-navy-dark: #09122a;
        --c-white: #ffffff;
        --c-ivory: #f9fafb;
        --c-text: #1f2a44;
        --c-gold: #D4AF37;
        --c-gold-2: #b9932f;

        --font-main: 'Cinzel', serif;
        --font-script: 'Playfair Display', serif;
        --font-body: 'Raleway', sans-serif;
    }

    body {
        background-color: var(--c-white);
        color: var(--c-text);
        font-family: var(--font-body);
        overflow-x: hidden;
    }

    .text-gold {
        background: linear-gradient(to right, var(--c-gold), #f4e2ab, var(--c-gold-2));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .bg-noise {
        background-color: var(--c-white);
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.45' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
    }

    .font-main {
        font-family: var(--font-main);
    }

    .font-script {
        font-family: var(--font-script);
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #eef2f7;
    }

    ::-webkit-scrollbar-thumb {
        background: #c9c9c9;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--c-gold);
    }
</style>

<div class="relative bg-noise selection:bg-[#D4AF37] selection:text-black">
    <div id="loading-overlay"
        class="fixed inset-0 z-[9999] bg-[radial-gradient(circle_at_center,white,rgba(14,27,58,0.08))] flex flex-col items-center justify-center transition-opacity duration-700">
        <div class="relative w-32 h-32 mb-8">
            <div class="absolute inset-0 border border-[#D4AF37] rounded-full opacity-30 animate-ping"></div>
            <div class="absolute inset-2 border border-[#b9932f] rounded-full flex items-center justify-center">
                <span class="font-main text-3xl text-gold font-bold">
                    {{ substr($groom['nickname'] ?? 'G', 0, 1) }}&{{ substr($bride['nickname'] ?? 'B', 0, 1) }}
                </span>
            </div>
        </div>
        <div class="w-48 h-[1px] bg-[#e5e7eb] relative overflow-hidden">
            <div id="gold-line"
                class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#D4AF37] to-[#f4e2ab] w-0 transition-all duration-[2000ms] ease-out">
            </div>
        </div>
        <p id="loading-text" class="mt-4 text-[#b9932f] font-main text-xs tracking-[0.3em] uppercase">Loading
            Elegance...</p>
        <button id="open-invitation-btn" aria-label="Open invitation"
            class="hidden mt-8 px-10 py-3 border border-[#D4AF37] text-[#0e1b3a] bg-white font-main tracking-widest text-sm hover:bg-[#D4AF37]/10 transition-all duration-500 uppercase">
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
            }, 1200);
            btn.addEventListener('click', function() {
                overlay.style.opacity = '0';
                document.body.style.overflow = 'auto';
                setTimeout(() => {
                    overlay.remove();
                }, 700);
                window.dispatchEvent(new CustomEvent('play-music'));
            });
        });
    </script>

    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()"
            class="fixed bottom-8 left-8 z-[900] print:hidden">
            <button @click="togglePlay" aria-label="Toggle music playback"
                class="group relative w-12 h-12 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#D4AF37] focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                <div class="absolute inset-0 rounded-full border border-[#D4AF37]/50 group-hover:border-[#f4e2ab] transition-colors duration-500"
                    :class="isPlaying ? 'animate-[spin_4s_linear_infinite]' : ''"></div>
                <div class="w-3 h-3 bg-[#D4AF37] rounded-full"></div>
            </button>
            <div class="hidden">
                <div id="yt-player-container"></div>
            </div>
        </div>
    @endif

    <section
        class="relative min-h-screen w-full overflow-hidden flex flex-col justify-center items-center text-center px-6">
        <div class="absolute inset-0 z-0">
            <img src="{{ $coverImage }}" class="w-full h-full object-cover opacity-70 scale-105" alt="Cover image"
                decoding="async">
            <div class="absolute inset-0 bg-gradient-to-b from-white via-white/70 to-white"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_0%,white_100%)]"></div>
        </div>
        <div class="relative z-10 space-y-6">
            <p class="font-body text-[#D4AF37] uppercase tracking-[0.4em] text-xs md:text-sm">The Wedding Of</p>
            <div class="py-4">
                <h1 class="font-main text-5xl md:text-7xl lg:text-8xl text-gold leading-tight">
                    {{ $groom['nickname'] }} <br>
                    <span class="font-script text-4xl md:text-6xl text-[#0e1b3a]/70 block my-2">&</span>
                    {{ $bride['nickname'] }}
                </h1>
            </div>
            <div
                class="flex items-center justify-center gap-4 text-[#0e1b3a] font-main text-sm md:text-base tracking-widest">
                <span>{{ $eventDate->format('d') }}</span>
                <span class="w-1 h-1 bg-[#D4AF37] rounded-full"></span>
                <span>{{ strtoupper($eventDate->translatedFormat('F')) }}</span>
                <span class="w-1 h-1 bg-[#D4AF37] rounded-full"></span>
                <span>{{ $eventDate->format('Y') }}</span>
            </div>
            @if ($guest)
                <div class="mt-12 pt-8 border-t border-[#D4AF37]/30 w-full max-w-md mx-auto">
                    <p class="font-body text-xs text-[#0e1b3a]/70 mb-2 italic">Dear Honored Guest,</p>
                    <h3 class="font-main text-2xl text-[#0e1b3a]">{{ $guest->name }}</h3>
                </div>
            @endif
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce text-[#D4AF37]">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </section>

    <section class="py-20 px-6 bg-white">
        <div class="max-w-3xl mx-auto text-center">
            @php $qs = $invitation->couple_data['quote_structured'] ?? null; @endphp
            <i class="fa-solid fa-quote-left text-4xl text-[#D4AF37]/60 mb-6 block"></i>
            @if ($qs && ($qs['type'] ?? '') === 'quran')
                <p class="font-main text-2xl leading-relaxed text-[#D4AF37]">{{ $qs['arabic'] ?? '' }}</p>
                <p class="font-body text-lg leading-relaxed text-[#1f2a44] mt-3">{{ $qs['translation'] ?? '' }}</p>
                <p class="font-body text-xs tracking-widest text-[#b9932f] mt-4">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'bible')
                <p class="font-body text-lg leading-relaxed text-[#1f2a44]">{{ $qs['verse_text'] ?? '' }}</p>
                @if (!empty($qs['translation']))
                    <p class="font-body text-base leading-relaxed text-[#4b5570] mt-3">{{ $qs['translation'] }}</p>
                @endif
                <p class="font-body text-xs tracking-widest text-[#b9932f] mt-4">{{ $qs['source'] ?? '' }}</p>
            @elseif ($qs && ($qs['type'] ?? '') === 'quote')
                <p class="font-main text-xl md:text-2xl leading-relaxed text-[#1f2a44] italic">
                    “{{ $qs['quote_text'] ?? '' }}”</p>
                <p class="font-body text-xs tracking-widest text-[#b9932f] mt-4">{{ $qs['source'] ?? 'Unknown' }}</p>
            @else
                <p class="font-main text-lg md:text-2xl leading-relaxed text-[#1f2a44] italic">
                    "{{ $invitation->couple_data['quote'] ?? '' }}"
                </p>
            @endif
            <div class="mt-8 flex items-center justify-center gap-4">
                <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
                <div class="h-[1px] w-12 bg-[#D4AF37]"></div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-[#0e1b3a]/5">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="text-center md:text-right">
                    <h2 class="font-main text-4xl text-gold mb-2">{{ $groom['fullname'] }}</h2>
                    <p class="font-body text-xs text-[#b9932f] uppercase tracking-widest mb-4">The Groom</p>
                    <p class="font-body text-[#4b5570] text-sm leading-6">Son of Mr. {{ $groom['father'] }} <br> & Mrs.
                        {{ $groom['mother'] }}</p>
                </div>
                <div class="relative mx-auto md:mx-0 w-64 h-80 md:w-80 md:h-[450px]">
                    <div
                        class="absolute -inset-2 border border-[#D4AF37]/40 rounded-t-[100px] transition-transform duration-700">
                    </div>
                    <div class="w-full h-full overflow-hidden rounded-t-[100px] relative">
                        <img src="{{ $groomImage }}" class="w-full h-full object-cover transition-all duration-700"
                            alt="Photo of {{ $groom['nickname'] ?? 'Groom' }}" loading="lazy" decoding="async">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                </div>
                <div class="relative mx-auto md:mx-0 w-64 h-80 md:w-80 md:h-[450px]">
                    <div
                        class="absolute -inset-2 border border-[#D4AF37]/40 rounded-t-[100px] transition-transform duration-700">
                    </div>
                    <div class="w-full h-full overflow-hidden rounded-t-[100px] relative">
                        <img src="{{ $brideImage }}" class="w-full h-full object-cover transition-all duration-700"
                            alt="Photo of {{ $bride['nickname'] ?? 'Bride' }}" loading="lazy" decoding="async">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent opacity-80">
                        </div>
                    </div>
                </div>
                <div class="text-center md:text-left">
                    <h2 class="font-main text-4xl text-gold mb-2">{{ $bride['fullname'] }}</h2>
                    <p class="font-body text-xs text-[#b9932f] uppercase tracking-widest mb-4">The Bride</p>
                    <p class="font-body text-[#4b5570] text-sm leading-6">Daughter of Mr. {{ $bride['father'] }} <br>
                        & Mrs. {{ $bride['mother'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ $coverImage }}" class="w-full h-full object-cover opacity-30" alt="Background image"
                decoding="async" style="transform: translateZ(0); will-change: transform;">
            <div class="absolute inset-0 bg-white/90"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center text-[#0e1b3a]">
            <h2 class="font-script text-5xl md:text-6xl text-gold mb-10">Save The Date</h2>
            <div class="border border-[#D4AF37]/40 bg-white p-8 md:p-12 relative shadow-sm">
                <div class="absolute top-2 left-2 w-4 h-4 border-t border-l border-[#D4AF37]"></div>
                <div class="absolute top-2 right-2 w-4 h-4 border-t border-r border-[#D4AF37]"></div>
                <div class="absolute bottom-2 left-2 w-4 h-4 border-b border-l border-[#D4AF37]"></div>
                <div class="absolute bottom-2 right-2 w-4 h-4 border-b border-r border-[#D4AF37]"></div>
                <h3 class="font-main text-3xl md:text-4xl uppercase tracking-widest mb-4">
                    {{ $invitation->event_data[0]['title'] }}</h3>
                <div class="flex flex-col md:flex-row justify-center items-center gap-8 my-8 font-main">
                    <div class="text-center">
                        <span class="block text-sm text-[#b9932f] uppercase tracking-widest">Date</span>
                        <span class="text-2xl">{{ $eventDate->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="w-[1px] h-10 bg-[#D4AF37] hidden md:block"></div>
                    <div class="text-center">
                        <span class="block text-sm text-[#b9932f] uppercase tracking-widest">Time</span>
                        <span class="text-2xl">{{ $eventDate->format('H:i') }} WIB</span>
                    </div>
                </div>
                <div class="mb-8">
                    <span class="block text-sm text-[#b9932f] uppercase tracking-widest mb-2">Venue</span>
                    <p class="font-body text-lg font-bold">{{ $invitation->event_data[0]['location'] }}</p>
                    <p class="font-body text-sm text-[#4b5570] mt-1">{{ $invitation->event_data[0]['address'] }}</p>
                </div>
                @if (!empty($invitation->event_data[0]['map_link']))
                    <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                        class="inline-block px-8 py-3 bg-gradient-to-r from-[#D4AF37] to-[#b9932f] text-black font-main font-bold uppercase tracking-wider hover:opacity-90 transition shadow-[0_0_15px_rgba(212,175,55,0.4)]">
                        View Map
                    </a>
                @endif
            </div>
            <div x-data="countdown('{{ $eventDate->toIso8601String() }}')" x-init="start()"
                class="flex justify-center gap-8 md:gap-16 mt-16 font-main text-[#D4AF37]">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="days"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#b9932f]">Days</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="hours"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#b9932f]">Hours</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl mb-1" x-text="minutes"></div>
                    <div class="text-[10px] uppercase tracking-widest text-[#b9932f]">Mins</div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($moments))
        <section class="py-24 px-4 bg-[#f7f9fc]" x-data="{ photoOpen: false, photoSrc: '' }" @keydown.escape.window="photoOpen = false">
            <div class="text-center mb-16">
                <h2 class="font-main text-4xl text-gold uppercase tracking-widest">Our Moments</h2>
                <div class="w-24 h-[1px] bg-[#D4AF37] mx-auto mt-4"></div>
            </div>
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4 max-w-7xl mx-auto">
                @foreach ($moments as $index => $photo)
                    <div class="break-inside-avoid relative group overflow-hidden cursor-pointer"
                        @click="photoOpen = true; photoSrc = '{{ asset($photo) }}'">
                        <div
                            class="absolute inset-0 border-[1px] border-[#D4AF37] opacity-0 scale-95 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500 z-10">
                        </div>
                        <img src="{{ asset($photo) }}"
                            class="w-full brightness-95 group-hover:brightness-100 transition-all duration-700"
                            alt="Wedding moment {{ $index + 1 }}" loading="lazy" decoding="async">
                    </div>
                @endforeach
            </div>
            <div x-show="photoOpen" x-transition.opacity class="fixed inset-0 z-[9999]">
                <div class="absolute inset-0 bg-black/70" @click="photoOpen = false"></div>
                <div class="absolute inset-0 flex items-center justify-center p-4">
                    <div class="relative w-full max-w-6xl">
                        <button @click="photoOpen = false"
                            class="absolute -top-6 right-0 bg-white text-[#0e1b3a] hover:bg-[#f0f0f0] w-10 h-10 rounded-full shadow-md flex items-center justify-center border border-white/70">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <img :src="photoSrc" alt="Preview"
                            class="w-full max-h-[85vh] object-contain rounded-xl shadow-2xl border border-white/40 bg-white/5">
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($gifts))
        <section class="py-24 px-6 bg-white">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-script text-5xl text-gold mb-4">Wedding Gift</h2>
                <p class="font-body text-[#4b5570] mb-12 max-w-lg mx-auto">Your presence is the greatest gift. However,
                    if you wish to honor us with a gift, a digital envelope is available.</p>
                <div class="flex flex-wrap justify-center gap-8">
                    @foreach ($gifts as $gift)
                        <div
                            class="group relative w-full max-w-[360px] h-[220px] rounded-xl bg-gradient-to-br from-white to-[#f3f3f3] border border-[#e5e5e5] shadow p-6 flex flex-col justify-between text-left hover:-translate-y-2 transition-transform duration-500">
                            <div
                                class="absolute inset-0 rounded-xl border border-[#D4AF37] opacity-0 group-hover:opacity-30 transition duration-500">
                            </div>
                            <div class="flex justify-between items-start">
                                <div
                                    class="w-10 h-8 bg-gradient-to-br from-[#f4e2ab] to-[#D4AF37] rounded-md relative overflow-hidden">
                                    <div class="absolute top-1/2 w-full h-[1px] bg-black/20"></div>
                                    <div class="absolute left-1/2 h-full w-[1px] bg-black/20"></div>
                                </div>
                                <span
                                    class="font-main font-bold text-[#4b5570] tracking-wider text-sm">{{ strtoupper($gift['bank_name']) }}</span>
                            </div>
                            <div class="font-main text-2xl text-gold tracking-[0.15em] drop-shadow-md cursor-pointer transition-colors"
                                title="Click to copy"
                                onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); const el=this; el.classList.add('gold-shimmer'); setTimeout(()=>el.classList.remove('gold-shimmer'),1200);">
                                {{ chunk_split($gift['account_number'], 4, ' ') }}
                            </div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[0.6rem] text-[#b9932f] uppercase tracking-widest mb-1">Card Holder
                                    </p>
                                    <p class="font-body text-sm text-[#0e1b3a] uppercase tracking-wider">
                                        {{ $gift['account_name'] }}</p>
                                </div>
                                <i class="fa-regular fa-clone text-[#D4AF37] cursor-pointer hover:text-black transition"
                                    aria-label="Copy account number" role="button" tabindex="0"
                                    onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}')"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (!empty($theme['gift_address']))
                    <div class="mt-8 bg-white border border-[#e5e5e5] rounded-2xl p-6 shadow-sm max-w-xl mx-auto">
                        <div class="flex items-center gap-2 mb-2 text-[#D4AF37]">
                            <i class="fa-solid fa-gift"></i>
                            <span class="font-main font-bold">Gift Shipping Address</span>
                        </div>
                        <p class="font-body text-sm text-[#4b5570] leading-relaxed">{{ $theme['gift_address'] }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <section class="py-24 px-6 bg-[#f7f9fc]">
        <div class="max-w-2xl mx-auto border border-[#e5e5e5] p-8 md:p-12 bg-white">
            <h2 class="font-main text-3xl text-center text-gold mb-10 uppercase tracking-widest">RSVP</h2>
            <div
                class="font-body text-[#1f2a44]
                [&_input]:bg-transparent [&_input]:border-b [&_input]:border-[#e5e5e5] [&_input]:text-[#1f2a44] [&_input]:w-full [&_input]:py-3 [&_input]:focus:border-[#D4AF37] [&_input]:outline-none
                [&_select]:bg-white [&_select]:border-b [&_select]:border-[#e5e5e5] [&_select]:text-[#1f2a44] [&_select]:w-full [&_select]:py-3 [&_select]:focus:border-[#D4AF37] [&_select]:outline-none
                [&_textarea]:bg-transparent [&_textarea]:border-b [&_textarea]:border-[#e5e5e5] [&_textarea]:text-[#1f2a44] [&_textarea]:w-full [&_textarea]:py-3 [&_textarea]:focus:border-[#D4AF37] [&_textarea]:outline-none
                [&_label]:text-[#D4AF37] [&_label]:text-xs [&_label]:uppercase [&_label]:tracking-widest
                [&_button]:w-full [&_button]:mt-6 [&_button]:py-4 [&_button]:bg-[#D4AF37] [&_button]:text-black [&_button]:font-main [&_button]:font-bold [&_button]:uppercase [&_button]:tracking-widest [&_button]:hover:bg-[#b9932f] [&_button]:transition">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
            <div class="my-16 flex items-center gap-4">
                <div class="h-[1px] flex-1 bg-[#e5e5e5]"></div>
                <div class="font-script text-2xl text-[#D4AF37]">Wishes</div>
                <div class="h-[1px] flex-1 bg-[#e5e5e5]"></div>
            </div>
            <div
                class="font-body [&_.card]:bg-[#f1f5f9] [&_.card]:border-l-2 [&_.card]:border-[#D4AF37] [&_.card]:p-4 [&_.card]:mb-4 [&_.card]:rounded-r-md">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-xl mx-auto px-6">
            <div class="text-center mb-8">
                <h2 class="font-script text-5xl text-gold">Thank You</h2>
            </div>
            <div class="relative bg-white shadow-[0_8px_30px_rgba(0,0,0,0.06)] p-8 rounded-xl">
                <div
                    class="absolute top-0 left-0 right-0 h-4 bg-gradient-to-r from-[#f3f3f3] via-white to-[#f3f3f3] rounded-t-xl">
                </div>
                <p class="font-body text-[#1f2a44] leading-relaxed">for being part of our lives and supporting us
                    through our journey.</p>
                <p class="font-body text-[#1f2a44] leading-relaxed mt-4">We were so blessed to have you celebrate and
                    be a part of our wedding day.</p>
                <div class="text-right mt-6"><span class="font-script text-3xl text-gold">See you!</span></div>
            </div>
        </div>
    </section>

    <footer class="py-12 bg-white text-center border-t border-[#e5e5e5]">
        <h3 class="font-main text-xl text-[#D4AF37] mb-2 tracking-[0.2em] uppercase">Arvaya De Aure</h3>
        <p class="font-body text-[10px] text-[#4b5570] tracking-widest">Exclusive Wedding Invitation &copy; 2025</p>
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
