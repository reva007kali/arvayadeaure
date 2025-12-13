@props(['invitation', 'guest'])

@php
    // Data setup
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    
    // Konfigurasi Warna & Aset
    // Menggunakan palet Golden White
    $primaryColor = '#AA8C49'; // Gold Champagne
    $secondaryColor = '#FDFBF7'; // Off-White / Cream
    $textColor = '#333333'; // Dark Grey for readability
    
    $galleryData = $invitation->gallery_data ?? [];
    $defaultCover = 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80';
    $defaultProfile = 'https://ui-avatars.com/api/?background=FDFBF7&color=AA8C49&size=200&name=';
    
    $coverImage = $galleryData['cover'] ?? ($galleryData[0] ?? $defaultCover);
    $groomImage = $galleryData['groom'] ?? $defaultProfile . urlencode($groom['nickname'] ?? 'Groom');
    $brideImage = $galleryData['bride'] ?? $defaultProfile . urlencode($bride['nickname'] ?? 'Bride');
    $moments = $galleryData['moments'] ?? [];
    if (isset($galleryData[0])) {
        $moments = $galleryData;
    }
@endphp

@slot('head')
    <title>{{ $groom['nickname'] ?? 'Groom' }} & {{ $bride['nickname'] ?? 'Bride' }} - The Wedding</title>
    
    <!-- Fonts: Cinzel (Judul Formal), Cormorant Garamond (Body Elegant), Great Vibes (Script Mewah) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Great+Vibes&display=swap" rel="stylesheet">
@endslot

<style>
    :root {
        --color-gold: #AA8C49;
        --color-gold-light: #D4C5A5;
        --color-bg: #FDFBF7;
        --color-text: #2C2C2C;
        --font-main: 'Cinzel', serif;
        --font-body: 'Cormorant Garamond', serif;
        --font-script: 'Great Vibes', cursive;
    }

    body {
        font-family: var(--font-body);
        background-color: var(--color-bg);
        color: var(--color-text);
    }

    .font-main { font-family: var(--font-main); }
    .font-body { font-family: var(--font-body); }
    .font-script { font-family: var(--font-script); }
    
    .text-gold { color: var(--color-gold); }
    .bg-gold { background-color: var(--color-gold); }
    .border-gold { border-color: var(--color-gold); }
    .theme-bg { background-color: var(--color-gold); }
    
    /* Utility Elegant Borders */
    .frame-border {
        border: 1px solid var(--color-gold-light);
        padding: 8px;
        position: relative;
    }
    .frame-inner {
        border: 1px solid var(--color-gold);
        height: 100%;
        width: 100%;
    }

    /* Arched Image Utility */
    .img-arch {
        border-radius: 200px 200px 0 0;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: var(--color-gold); border-radius: 3px; }

    /* Loading Animation Ring */
    @keyframes spin-slow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>

{{-- ======================================================================= --}}
{{-- LOADING SCREEN (ELEGANT MONOGRAM) --}}
{{-- ======================================================================= --}}
<div id="loading-overlay" class="fixed inset-0 z-[9999] bg-[#FDFBF7] flex flex-col items-center justify-center transition-opacity duration-1000">
    <div class="relative w-40 h-40 flex items-center justify-center">
        <!-- Outer Ring -->
        <div class="absolute inset-0 border-[1px] border-[#D4C5A5] rounded-full opacity-50"></div>
        <!-- Spinning Ring -->
        <div class="absolute inset-2 border-t-[1px] border-b-[1px] border-[#AA8C49] rounded-full animate-spin-slow"></div>
        
        <!-- Initials -->
        <div class="text-3xl font-main text-[#AA8C49] tracking-widest animate-pulse">
            {{ substr($groom['nickname'] ?? 'G', 0, 1) }} & {{ substr($bride['nickname'] ?? 'B', 0, 1) }}
        </div>
    </div>
    
    <div class="mt-8 text-center h-16">
        <p id="loading-text" class="font-main text-xs tracking-[0.3em] uppercase text-[#AA8C49]">Loading Invitation</p>
        
        <button id="open-invitation-btn" class="hidden opacity-0 transform translate-y-4 transition-all duration-700 group relative px-8 py-3 bg-transparent overflow-hidden">
            <span class="relative z-10 font-main text-sm tracking-[0.2em] text-[#2C2C2C] group-hover:text-white transition-colors duration-500">OPEN INVITATION</span>
            <div class="absolute inset-0 h-full w-full scale-0 rounded-sm transition-all duration-300 group-hover:scale-100 group-hover:bg-[#AA8C49]/90"></div>
            <div class="absolute inset-0 border border-[#AA8C49]"></div>
        </button>
    </div>
</div>

<script>
    document.body.style.overflow = 'hidden';
    window.addEventListener('load', function() {
        setTimeout(() => {
            document.getElementById('loading-text').style.display = 'none';
            const btn = document.getElementById('open-invitation-btn');
            btn.classList.remove('hidden', 'opacity-0', 'translate-y-4');
        }, 1500);

        document.getElementById('open-invitation-btn').addEventListener('click', function() {
            const overlay = document.getElementById('loading-overlay');
            overlay.style.opacity = '0';
            document.body.style.overflow = 'auto';
            setTimeout(() => { overlay.remove(); }, 1000);
            window.dispatchEvent(new CustomEvent('play-music'));
        });
    });
</script>


<div class="relative bg-[#FDFBF7] overflow-x-hidden selection:bg-[#AA8C49] selection:text-white">

    {{-- MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" x-init="initPlayer()" @play-music.window="playMusic()" class="fixed bottom-8 left-8 z-50">
            <button @click="togglePlay" class="w-10 h-10 bg-white/80 backdrop-blur border border-[#AA8C49]/30 rounded-full flex items-center justify-center shadow-lg text-[#AA8C49] hover:bg-[#AA8C49] hover:text-white transition-all duration-300">
                <i class="fa-solid" :class="isPlaying ? 'fa-pause' : 'fa-play pl-0.5'"></i>
            </button>
            <div class="hidden">
                 <div id="yt-player-container"></div>
            </div>
        </div>
        <script>
            // Simple YouTube Player Logic Placeholder
            function youtubePlayer(url) {
                return {
                    isPlaying: false,
                    player: null,
                    initPlayer() { /* implementation handled by external script usually */ },
                    togglePlay() { this.isPlaying = !this.isPlaying; /* toggle logic */ },
                    playMusic() { this.isPlaying = true; /* play logic */ }
                }
            }
        </script>
    @endif

    {{-- 1. HERO SECTION --}}
    <section class="min-h-screen relative flex flex-col justify-center items-center py-10 px-6">
        <!-- Background Pattern (Subtle Grain/Noise) -->
        <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/cream-paper.png')] pointer-events-none"></div>
        
        <div class="relative z-10 w-full max-w-lg mx-auto text-center border-y border-[#AA8C49]/20 py-12" data-anim="fade-up" data-duration="1.5s">
            <p class="font-main text-xs tracking-[0.3em] text-[#666] mb-6 uppercase">The Wedding Of</p>
            
            <div class="space-y-2 mb-8">
                <h1 class="font-main text-4xl md:text-6xl text-[#2C2C2C]">{{ $groom['nickname'] }}</h1>
                <div class="font-script text-3xl text-[#AA8C49]">&</div>
                <h1 class="font-main text-4xl md:text-6xl text-[#2C2C2C]">{{ $bride['nickname'] }}</h1>
            </div>

            <div class="flex items-center justify-center gap-4 text-[#AA8C49]">
                <div class="h-[1px] w-12 bg-[#AA8C49]"></div>
                <p class="font-body italic text-xl">
                    {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('l, d F Y') }}
                </p>
                <div class="h-[1px] w-12 bg-[#AA8C49]"></div>
            </div>
        </div>

        @if ($guest)
            <div class="mt-12 text-center" data-anim="fade-up" data-delay="0.5s">
                <p class="font-body italic text-sm text-[#888] mb-2">Dear Mr/Mrs/Ms,</p>
                <div class="border border-[#AA8C49]/40 px-8 py-3 bg-white shadow-[0_4px_20px_rgba(0,0,0,0.03)] inline-block min-w-[200px]">
                    <h3 class="font-main text-lg text-[#2C2C2C]">{{ $guest->name ?? 'Special Guest' }}</h3>
                </div>
            </div>
        @endif

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex flex-col items-center opacity-60 animate-bounce">
            <span class="text-[10px] tracking-widest uppercase mb-2">Scroll</span>
            <i class="fa-solid fa-chevron-down text-[#AA8C49]"></i>
        </div>
    </section>

    {{-- 2. QUOTE SECTION --}}
    <section class="py-20 px-6 bg-[#F8F5F0]">
        <div class="max-w-3xl mx-auto text-center" data-anim="fade-up">
            <div class="w-16 h-16 mx-auto mb-6 opacity-80">
                 <!-- Floral/Leaf Icon SVG -->
                 <svg viewBox="0 0 24 24" fill="none" stroke="#AA8C49" stroke-width="1"><path d="M12 2L9 9H2L7 14L5 21L12 17L19 21L17 14L22 9H15L12 2Z" /></svg>
            </div>
            
            <p class="font-body text-xl md:text-2xl leading-relaxed text-[#555] italic mb-6">
                "{{ $invitation->couple_data['quote'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...' }}"
            </p>
            <p class="font-main text-sm tracking-widest text-[#AA8C49]">QS AR-RUM : 21</p>
        </div>
    </section>

    {{-- 3. THE COUPLE --}}
    <section class="py-24 px-4 overflow-hidden">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16" data-anim="fade-up">
                <h2 class="font-main text-3xl tracking-[0.2em] text-[#2C2C2C]">THE GROOM & BRIDE</h2>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center gap-12 md:gap-20">
                
                {{-- Groom --}}
                <div class="flex-1 text-center group" data-anim="fade-right">
                    <div class="relative w-64 h-80 mx-auto mb-8">
                        <!-- Frame Border -->
                        <div class="absolute inset-0 border border-[#AA8C49] rounded-t-full translate-x-3 translate-y-3 transition-transform duration-500 group-hover:translate-x-2 group-hover:translate-y-2"></div>
                        <!-- Image -->
                        <div class="relative w-full h-full rounded-t-full overflow-hidden bg-gray-200 shadow-lg">
                            <img src="{{ asset($groomImage) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Groom">
                        </div>
                    </div>
                    
                    <h3 class="font-main text-2xl font-semibold mb-2">{{ $groom['fullname'] }}</h3>
                    <p class="font-body text-lg italic text-[#AA8C49] mb-4">Putra Pertama</p>
                    <div class="font-body text-sm text-[#666]">
                        <p>Bpk. {{ $groom['father'] }}</p>
                        <p>& Ibu {{ $groom['mother'] }}</p>
                    </div>
                    <div class="mt-4">
                         <a href="https://instagram.com/{{ $groom['instagram'] }}" class="flex w-fit mx-auto gap-x-2 items-center text-[#AA8C49] hover:text-[#2C2C2C] transition"><i class="fa-brands fa-instagram text-xl"></i>{{ $groom['instagram'] ?? 'username' }}</a>
                    </div>
                </div>

                {{-- Ampersand --}}
                <div class="font-script text-6xl text-[#D4C5A5]" data-anim="zoom-in">&</div>

                {{-- Bride --}}
                <div class="flex-1 text-center group" data-anim="fade-left">
                    <div class="relative w-64 h-80 mx-auto mb-8">
                        <!-- Frame Border -->
                        <div class="absolute inset-0 border border-[#AA8C49] rounded-t-full -translate-x-3 translate-y-3 transition-transform duration-500 group-hover:-translate-x-2 group-hover:translate-y-2"></div>
                        <!-- Image -->
                        <div class="relative w-full h-full rounded-t-full overflow-hidden bg-gray-200 shadow-lg">
                            <img src="{{ asset($brideImage) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Bride">
                        </div>
                    </div>
                    
                    <h3 class="font-main text-2xl font-semibold mb-2">{{ $bride['fullname'] }}</h3>
                    <p class="font-body text-lg italic text-[#AA8C49] mb-4">Putri Kedua</p>
                    <div class="font-body text-sm text-[#666]">
                        <p>Bpk. {{ $bride['father'] }}</p>
                        <p>& Ibu {{ $bride['mother'] }}</p>
                    </div>
                    <div class="mt-4">
                          <a href="https://instagram.com/{{ $bride['instagram'] }}" class="flex w-fit mx-auto gap-x-2 items-center
                          text-[#AA8C49] hover:text-[#2C2C2C] transition"><i class="fa-brands fa-instagram text-xl"></i>{{ $bride['instagram'] ?? 'username' }}</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 4. EVENT DETAILS --}}
    <section class="py-20 px-6 bg-[#2C2C2C] text-[#FDFBF7] relative">
        <!-- Abstract Decoration Lines -->
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-[#AA8C49] to-transparent opacity-50"></div>
        
        <div class="max-w-4xl mx-auto text-center">
            <div data-anim="fade-up">
                <h2 class="font-main text-3xl tracking-[0.2em] mb-12 text-[#AA8C49]">SAVE THE DATE</h2>
            </div>

            <!-- Event Box -->
            <div class="border border-[#AA8C49]/30 p-8 md:p-12 relative bg-[#333]/50 backdrop-blur-sm" data-anim="fade-up">
                <!-- Corner Decorations -->
                <div class="absolute top-0 left-0 w-8 h-8 border-t border-l border-[#AA8C49]"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t border-r border-[#AA8C49]"></div>
                <div class="absolute bottom-0 left-0 w-8 h-8 border-b border-l border-[#AA8C49]"></div>
                <div class="absolute bottom-0 right-0 w-8 h-8 border-b border-r border-[#AA8C49]"></div>

                <h3 class="font-main text-2xl mb-2">{{ $invitation->event_data[0]['title'] }}</h3>
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 my-8 font-body text-xl">
                    <span>{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('l') }}</span>
                    <span class="text-4xl font-main text-[#AA8C49] px-4 border-x border-[#AA8C49]/30">
                        {{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('d') }}
                    </span>
                    <span>{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('F Y') }}</span>
                </div>
                
                <p class="font-body text-lg text-gray-300 mb-6">
                    Pukul <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('H:i') }} WIB</span> - Selesai
                </p>

                <div class="h-px w-20 bg-[#AA8C49]/50 mx-auto mb-6"></div>

                <p class="font-main font-semibold tracking-wide mb-2">{{ $invitation->event_data[0]['location'] }}</p>
                <p class="font-body text-gray-400 text-sm max-w-md mx-auto mb-8">{{ $invitation->event_data[0]['address'] }}</p>

                @if (!empty($invitation->event_data[0]['map_link']))
                    <a href="{{ $invitation->event_data[0]['map_link'] }}" target="_blank"
                       class="inline-block px-8 py-3 border border-[#AA8C49] text-[#AA8C49] hover:bg-[#AA8C49] hover:text-white transition-all duration-300 text-xs font-main tracking-[0.2em] uppercase">
                        View Location
                    </a>
                @endif
            </div>

            <!-- Countdown (Minimalist) -->
            <div x-data="countdown('{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->toIso8601String() }}')" x-init="start()" 
                 class="grid grid-cols-4 gap-4 max-w-lg mx-auto mt-12 text-[#AA8C49]">
                <div class="text-center">
                    <span class="block text-2xl font-main" x-text="days">0</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Days</span>
                </div>
                <div class="text-center border-l border-white/10">
                    <span class="block text-2xl font-main" x-text="hours">0</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Hours</span>
                </div>
                <div class="text-center border-l border-white/10">
                    <span class="block text-2xl font-main" x-text="minutes">0</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Mins</span>
                </div>
                <div class="text-center border-l border-white/10">
                    <span class="block text-2xl font-main" x-text="seconds">0</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Secs</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. GALLERY (MASONRY/GRID) --}}
    @if (!empty($moments))
        <section class="py-24 px-4 bg-[#FDFBF7]">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-anim="fade-up">
                    <h2 class="font-main text-3xl tracking-[0.2em] text-[#2C2C2C]">OUR MOMENTS</h2>
                    <div class="w-12 h-px bg-[#AA8C49] mx-auto mt-4"></div>
                </div>
                
                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                    @foreach ($moments as $index => $photo)
                        <div class="break-inside-avoid relative group overflow-hidden" data-anim="fade-up" data-delay="{{ $index * 0.1 }}s">
                            <img src="{{ asset($photo) }}" class="w-full h-auto object-cover grayscale hover:grayscale-0 transition-all duration-1000 ease-in-out hover:scale-105">
                            <div class="absolute inset-0 border-[4px] border-white/0 group-hover:border-white/20 transition-all duration-500 pointer-events-none"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 6. WEDDING GIFT --}}
    @if (!empty($gifts))
        <section class="py-20 px-6 bg-gradient-to-b from-[#F8F5F0] to-[#FDFBF7]">
            <div class="max-w-3xl mx-auto text-center" data-anim="fade-up">
                <h2 class="font-main text-3xl tracking-[0.2em] mb-6">WEDDING GIFT</h2>
                <p class="font-body text-gray-600 mb-12 italic">
                    "Your presence is the greatest gift of all. However, if you wish to honor us with a token of love, it will be highly appreciated."
                </p>

                <div class="flex flex-col items-center gap-8">
                    @foreach ($gifts as $gift)
                        <!-- Card Design: Minimalist Gold/Black -->
                        <div class="relative w-full max-w-[380px] aspect-[1.586/1] rounded-xl overflow-hidden shadow-2xl group transition-transform hover:-translate-y-2 duration-500 text-left" data-anim="flip-up">
                            
                            <!-- Background -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#2c2c2c] to-[#000000]"></div>
                            <!-- Gold Noise/Texture -->
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
                            
                            <!-- Content -->
                            <div class="relative z-10 p-6 h-full flex flex-col justify-between text-[#FDFBF7]">
                                <div class="flex justify-between items-start">
                                    <span class="font-main tracking-widest text-sm text-[#AA8C49]">{{ $gift['bank_name'] }}</span>
                                    <i class="fa-solid fa-wifi rotate-90 text-[#AA8C49]/50"></i>
                                </div>

                                <div class="space-y-1 mt-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Chip -->
                                        <div class="w-10 h-8 rounded bg-gradient-to-tr from-[#AA8C49] to-[#F3E5AB] border border-[#AA8C49] shadow-inner"></div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between cursor-pointer pt-4 group-copy" 
                                         onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Copied!');">
                                        <span class="font-mono text-xl md:text-2xl tracking-widest text-shadow">{{ chunk_split($gift['account_number'], 4, ' ') }}</span>
                                        <i class="fa-regular fa-copy text-[#AA8C49] opacity-0 group-copy-hover:opacity-100 transition-opacity"></i>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end">
                                    <div class="uppercase tracking-wider text-xs opacity-80">
                                        <span class="block text-[8px] text-[#AA8C49]">Card Holder</span>
                                        {{ $gift['account_name'] }}
                                    </div>
                                    <div class="font-main font-bold text-lg text-[#AA8C49] italic">Platinum</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 7. RSVP & GUEST BOOK --}}
    <section class="py-20 px-6 bg-[#FDFBF7]">
        <div class="max-w-2xl mx-auto border border-[#AA8C49]/20 p-8 md:p-12 bg-white shadow-sm" data-anim="fade-up">
            <h2 class="font-main text-2xl tracking-[0.2em] text-center mb-10 text-[#2C2C2C]">RSVP</h2>
            
            <!-- Menggunakan style minimalis untuk form Livewire -->
            <div class="[&_input]:border-b [&_input]:border-gray-300 [&_input]:border-t-0 [&_input]:border-x-0 [&_input]:rounded-none [&_input]:bg-transparent [&_input]:px-0 [&_input]:py-3 focus:[&_input]:border-[#AA8C49] focus:[&_input]:ring-0 [&_textarea]:border-b [&_textarea]:border-gray-300 [&_textarea]:border-t-0 [&_textarea]:border-x-0 [&_textarea]:rounded-none [&_textarea]:bg-transparent [&_textarea]:px-0 focus:[&_textarea]:border-[#AA8C49] focus:[&_textarea]:ring-0">
                @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>

        <div class="max-w-3xl mx-auto mt-16" data-anim="fade-up">
            <h2 class="font-main text-xl tracking-[0.2em] text-center mb-8 text-[#AA8C49]">WISHES</h2>
            <div class="bg-[#F8F5F0] p-6 rounded-sm border-l-2 border-[#AA8C49]">
                @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
            </div>
        </div>
    </section>

    {{-- 8. FOOTER / CLOSING --}}
    <section class="py-24 px-6 text-center bg-[#2C2C2C] text-[#FDFBF7]">
        <div data-anim="fade-up">
            <h2 class="font-script text-5xl md:text-7xl mb-8 text-[#AA8C49]">Thank You</h2>
            <p class="font-body text-lg text-gray-400 max-w-xl mx-auto mb-12">
                It is an honor and happiness for us if you are willing to attend and give your blessing to us.
            </p>
            
            <div class="font-main text-2xl tracking-widest text-white mb-20">
                {{ $groom['nickname'] }} <span class="text-[#AA8C49]">&</span> {{ $bride['nickname'] }}
            </div>
        </div>

        <!-- Footer Credit -->
        <div class="border-t border-white/10 pt-8 flex flex-col items-center">
            <a href="https://arvayadeaure.com" target="_blank" class="group opacity-70 hover:opacity-100 transition-opacity">
                <div class="flex items-center gap-3">
                    <img src="img/favicon/1.png" alt="Logo" class="w-8 h-8 rounded-full border border-[#AA8C49]">
                    <div class="text-left">
                        <p class="font-main text-[10px] tracking-[0.2em] uppercase text-[#AA8C49]">Arvaya De Aure</p>
                        <p class="font-sans text-[8px] text-gray-500">Premium Wedding Invitation</p>
                    </div>
                </div>
            </a>
        </div>
    </section>

</div>

{{-- Logic Script for Countdown --}}
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
</script>