@props(['invitation', 'guest'])

@php
    $groom = $invitation->couple_data['groom'] ?? [];
    $bride = $invitation->couple_data['bride'] ?? [];
    $gifts = $invitation->gifts_data ?? [];
    $theme = $invitation->theme_config ?? [];
    
    // Palette Retro: Rust, Old Paper, Ink Black
    $accentColor = data_get($theme, 'primary_color', '#c8553d'); // Merah Bata / Rust
    $paperColor = '#F0E6D2'; // Warna Kertas Lama
    $inkColor = '#2c241b'; // Hitam Tinta Tua
    
    $coverImage = $invitation->gallery_data[0] ?? 'https://images.unsplash.com/photo-1511285560982-1927bb5a6271?q=80&w=1920&auto=format&fit=crop';
@endphp

<div 
 class="font-typewriter text-[#2c241b] bg-[#F0E6D2] min-h-svh pb-20 overflow-x-hidden selection:bg-[#c8553d] selection:text-[#F0E6D2] relative">

    {{-- TEXTURE OVERLAY (Efek Kertas Noise) --}}
    <div class="fixed inset-0 z-0 opacity-[0.4] pointer-events-none" 
         style="background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');"></div>
    <div class="fixed inset-0 z-0 opacity-[0.08] pointer-events-none mix-blend-multiply" 
         style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

    {{-- CSS & FONTS --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Courier+Prime:ital,wght@0,400;0,700;1,400&display=swap');

        .font-display { font-family: 'Abril Fatface', cursive; }
        .font-typewriter { font-family: 'Courier Prime', monospace; }
        
        .retro-accent { color: {{ $accentColor }}; }
        .retro-bg { background-color: {{ $accentColor }}; }
        .retro-border { border-color: {{ $accentColor }}; }

        /* Custom Scrollbar Retro */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #e3d5b8; border-left: 1px solid #d1c2a3; }
        ::-webkit-scrollbar-thumb { background: #2c241b; border: 2px solid #e3d5b8; }

        /* Vinyl Animation */
        .spin-slow { animation: spin 8s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>

    {{-- VINYL MUSIC PLAYER --}}
    @if (!empty($theme['music_url']))
        <div x-data="youtubePlayer('{{ $theme['music_url'] }}')" 
             x-init="initPlayer()" 
             @play-music.window="playMusic()" 
             class="fixed bottom-6 left-4 z-50 group">
            
            {{-- Popup Controls (Retro Style) --}}
            <div x-show="isOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mb-4 bg-[#2c241b] p-3 border-2 border-[#c8553d] w-64 shadow-[4px_4px_0px_rgba(0,0,0,0.2)] relative">
                 
                 {{-- Screws Decoration --}}
                 <div class="absolute top-1 left-1 w-2 h-2 rounded-full bg-[#555] shadow-inner"></div>
                 <div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#555] shadow-inner"></div>
                 <div class="absolute bottom-1 left-1 w-2 h-2 rounded-full bg-[#555] shadow-inner"></div>
                 <div class="absolute bottom-1 right-1 w-2 h-2 rounded-full bg-[#555] shadow-inner"></div>

                <div class="flex items-center justify-between mb-3 text-[#F0E6D2]">
                    <button @click="seek(-10)" class="hover:text-[#c8553d] transition"><i class="fa-solid fa-backward-step"></i></button>
                    <button @click="togglePlay" class="text-xs uppercase tracking-widest border border-[#F0E6D2] px-2 py-1 hover:bg-[#F0E6D2] hover:text-[#2c241b] transition">
                        <span x-text="isPlaying ? 'PAUSE' : 'PLAY'"></span>
                    </button>
                    <button @click="seek(10)" class="hover:text-[#c8553d] transition"><i class="fa-solid fa-forward-step"></i></button>
                </div>
                
                <div class="h-24 w-full bg-black relative overflow-hidden border border-[#555]">
                     <div id="yt-player-container" class="opacity-50 grayscale"></div>
                     <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <p class="text-[10px] text-[#c8553d] font-typewriter animate-pulse">NOW PLAYING...</p>
                     </div>
                </div>
            </div>

            {{-- VINYL TRIGGER --}}
            <div class="relative w-16 h-16 cursor-pointer" @click="isOpen = !isOpen">
                {{-- Piringan Hitam (The Disc) --}}
                <div class="absolute top-1 left-1 w-14 h-14 rounded-full bg-black border-4 border-[#111] flex items-center justify-center transition-transform duration-700 ease-in-out z-0"
                     :class="isPlaying ? 'translate-x-8 rotate-12' : 'translate-x-0'">
                    {{-- Groove lines --}}
                    <div class="w-12 h-12 rounded-full border border-[#333]"></div>
                    <div class="absolute w-10 h-10 rounded-full border border-[#333]"></div>
                    {{-- Sticker Tengah --}}
                    <div class="absolute w-6 h-6 rounded-full bg-[#c8553d] border-2 border-white flex items-center justify-center" :class="isPlaying ? 'spin-slow' : ''">
                        <div class="w-1 h-1 bg-black rounded-full"></div>
                    </div>
                </div>

                {{-- Cover Album (Sleeve) --}}
                <div class="absolute top-0 left-0 w-16 h-16 bg-[#e3d5b8] border-2 border-[#2c241b] shadow-[4px_4px_0px_#2c241b] z-10 flex items-center justify-center overflow-hidden">
                    <img src="{{ $coverImage }}" class="w-full h-full object-cover grayscale opacity-80 mix-blend-multiply">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fa-solid fa-music text-[#F0E6D2] drop-shadow-md text-xl" x-show="!isPlaying"></i>
                        <i class="fa-solid fa-compact-disc text-[#c8553d] drop-shadow-md text-xl animate-spin" x-show="isPlaying" style="animation-duration: 3s;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- SCRIPT PLAYER --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('youtubePlayer', (url) => ({
                    player: null, isPlaying: false, isOpen: false, videoId: '',
                    initPlayer() {
                        const match = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/);
                        this.videoId = (match && match[2].length === 11) ? match[2] : null;
                        if (!this.videoId) return;
                        if (!window.YT) {
                            const tag = document.createElement('script'); tag.src = "https://www.youtube.com/iframe_api";
                            document.body.appendChild(tag);
                            window.onYouTubeIframeAPIReady = () => this.createPlayer();
                        } else { this.createPlayer(); }
                    },
                    createPlayer() {
                        this.player = new YT.Player('yt-player-container', {
                            height: '100%', width: '100%', videoId: this.videoId,
                            playerVars: { 'autoplay': 1, 'controls': 0, 'loop': 1, 'playlist': this.videoId },
                            events: { 'onStateChange': (e) => this.isPlaying = (e.data === YT.PlayerState.PLAYING) }
                        });
                    },
                    playMusic() { if(this.player?.playVideo) { this.player.playVideo(); this.isPlaying = true; } },
                    togglePlay() { if(!this.player) return; this.isPlaying ? this.player.pauseVideo() : this.player.playVideo(); },
                    seek(s) { if(this.player) this.player.seekTo(this.player.getCurrentTime() + s, true); }
                }));
            });
        </script>
    @endif

    {{-- HERO SECTION (Kertas Lecek Vibes) --}}
    <section class="relative min-h-svh flex flex-col justify-center items-center text-center p-6 border-b-2 border-[#2c241b] border-dashed">
        
        <div class="relative z-10 max-w-2xl w-full" data-aos="fade-up" data-aos-duration="1500">
            <div class="border-2 border-[#2c241b] p-2 inline-block mb-8 rotate-2 bg-[#F0E6D2]">
                <p class="text-xs font-bold tracking-[0.3em] uppercase px-4 py-1 border border-[#2c241b]">
                    The Wedding Of
                </p>
            </div>

            <h1 class="font-display text-6xl md:text-8xl leading-none mb-6 text-[#2c241b] mix-blend-multiply drop-shadow-[2px_2px_0px_rgba(200,85,61,0.5)]">
                {{ $groom['nickname'] ?? 'Groom' }}
                <span class="block text-4xl my-2 font-typewriter italic text-[#c8553d]">- dan -</span>
                {{ $bride['nickname'] ?? 'Bride' }}
            </h1>

            <div class="flex items-center justify-center gap-4 text-sm font-bold tracking-widest my-10">
                <span class="border-b border-[#2c241b] pb-1">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('d') }}</span>
                <span class="italic text-[#c8553d]">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->translatedFormat('F') }}</span>
                <span class="border-b border-[#2c241b] pb-1">{{ \Carbon\Carbon::parse($invitation->event_data[0]['date'])->format('Y') }}</span>
            </div>

            @if ($guest)
                <div class="mt-8 relative inline-block transform -rotate-1 hover:rotate-0 transition duration-300 cursor-default">
                    {{-- Efek Selotip --}}
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-16 h-6 bg-[#e3d5b8]/80 rotate-2 shadow-sm z-20"></div>
                    
                    <div class="bg-white p-4 pb-8 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1),0_2px_4px_-1px_rgba(0,0,0,0.06)] border border-gray-200">
                        <p class="font-typewriter text-[10px] text-gray-500 mb-2">Untuk Tuan/Nyonya:</p>
                        <h3 class="font-display text-2xl text-[#2c241b]">{{ $guest->name }}</h3>
                    </div>
                </div>
            @endif

            <div class="mt-16" x-data>
                <a href="#prologue" @click="$dispatch('play-music')"
                   class="inline-block px-8 py-3 bg-[#2c241b] text-[#F0E6D2] text-sm font-bold hover:bg-[#c8553d] transition-colors duration-300 shadow-[4px_4px_0px_#c8553d] hover:shadow-[2px_2px_0px_#2c241b] hover:translate-x-[2px] hover:translate-y-[2px]">
                    BUKA LEMBARAN
                </a>
            </div>
        </div>
    </section>

    {{-- PROLOGUE (Kalcer Copywriting) --}}
    <section id="prologue" class="py-24 container mx-auto px-6 text-center">
        <div data-aos="fade-up">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Vintage_Camera_Icon.svg/1200px-Vintage_Camera_Icon.svg.png" 
                 class="w-12 mx-auto mb-6 opacity-60 filter sepia">
            
            <h2 class="font-display text-3xl mb-6 retro-accent">Sebuah Pengantar</h2>
            <p class="max-w-2xl mx-auto text-lg leading-relaxed opacity-80 italic">
                "{{ $invitation->couple_data['quote'] ?? 'Bukan tentang seberapa mewah perayaannya, tapi tentang siapa yang menemani duduk di pelaminan, lalu menua bersama sambil menyeruput kopi di beranda.' }}"
            </p>
        </div>
    </section>

    {{-- COUPLE PROFILE (Polaroid Style) --}}
    <section class="py-20 overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16 md:gap-8 items-center max-w-4xl mx-auto">
                
                {{-- GROOM --}}
                <div class="relative group" data-aos="fade-right">
                    {{-- Polaroid Frame --}}
                    <div class="bg-white p-3 pb-12 shadow-lg transform -rotate-2 transition duration-700 group-hover:rotate-0 group-hover:scale-105 border border-gray-200">
                        <div class="aspect-[3/4] w-full overflow-hidden bg-gray-200 relative">
                            {{-- Image with Grayscale Effect --}}
                            <img src="https://ui-avatars.com/api/?name={{ $groom['nickname'] }}&background=2c241b&color=F0E6D2&size=400" 
                                 class="w-full h-full object-cover grayscale contrast-125 transition-all duration-1000 ease-out group-hover:grayscale-0 group-hover:contrast-100">
                            {{-- Grain Overlay on Image --}}
                            <div class="absolute inset-0 opacity-20 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] pointer-events-none"></div>
                        </div>
                        <div class="absolute bottom-4 left-0 w-full text-center">
                            <p class="font-display text-2xl text-[#2c241b]">{{ $groom['nickname'] }}</p>
                            <p class="font-typewriter text-[10px] text-gray-500">Sang Tuan</p>
                        </div>
                    </div>
                    {{-- Pin --}}
                    <div class="absolute -top-3 left-1/2 w-4 h-4 rounded-full bg-red-800 shadow-md z-10 border border-white opacity-90"></div>
                </div>

                {{-- BRIDE --}}
                <div class="relative group md:mt-24" data-aos="fade-left">
                    <div class="bg-white p-3 pb-12 shadow-lg transform rotate-3 transition duration-700 group-hover:rotate-0 group-hover:scale-105 border border-gray-200">
                        <div class="aspect-[3/4] w-full overflow-hidden bg-gray-200 relative">
                            <img src="https://ui-avatars.com/api/?name={{ $bride['nickname'] }}&background=2c241b&color=F0E6D2&size=400" 
                                 class="w-full h-full object-cover grayscale contrast-125 transition-all duration-1000 ease-out group-hover:grayscale-0 group-hover:contrast-100">
                            <div class="absolute inset-0 opacity-20 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] pointer-events-none"></div>
                        </div>
                        <div class="absolute bottom-4 left-0 w-full text-center">
                            <p class="font-display text-2xl text-[#2c241b]">{{ $bride['nickname'] }}</p>
                            <p class="font-typewriter text-[10px] text-gray-500">Sang Puan</p>
                        </div>
                    </div>
                    <div class="absolute -top-3 left-1/2 w-4 h-4 rounded-full bg-red-800 shadow-md z-10 border border-white opacity-90"></div>
                </div>

            </div>
        </div>
    </section>

    {{-- EVENTS (Timeline Retro) --}}
    <section class="py-24 relative border-t-2 border-b-2 border-[#2c241b] border-dashed bg-[#e8dbc3]">
        <div class="container mx-auto px-6 max-w-3xl">
            <div class="text-center mb-12" data-aos="zoom-in">
                <span class="inline-block border border-[#2c241b] px-3 py-1 text-xs font-bold uppercase tracking-widest bg-[#2c241b] text-[#F0E6D2] mb-4">
                    Mencatat Waktu
                </span>
                <h2 class="font-display text-4xl">Titik Temu</h2>
            </div>

            <div class="space-y-12">
                @foreach ($invitation->event_data as $index => $event)
                    <div class="flex flex-col md:flex-row gap-6 items-start group" data-aos="fade-up" data-aos-delay="{{ $index * 150 }}">
                        {{-- Date Badge --}}
                        <div class="w-full md:w-32 shrink-0 border-2 border-[#2c241b] p-2 text-center bg-[#F0E6D2] shadow-[4px_4px_0px_#2c241b] group-hover:translate-x-1 group-hover:translate-y-1 group-hover:shadow-none transition-all">
                            <span class="block text-2xl font-display">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                            <span class="block text-xs font-bold uppercase border-t border-[#2c241b] pt-1 mt-1">
                                {{ \Carbon\Carbon::parse($event['date'])->format('M') }}
                            </span>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 border-l-2 border-[#2c241b] pl-6 md:pl-8 border-dashed">
                            <h3 class="font-display text-2xl mb-2">{{ $event['title'] }}</h3>
                            <div class="font-typewriter text-sm space-y-2 opacity-80">
                                <p class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock"></i> 
                                    {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB - Selesai
                                </p>
                                <p class="flex items-center gap-2">
                                    <i class="fa-solid fa-map-pin"></i>
                                    {{ $event['location'] }}
                                </p>
                                <p class="text-xs italic mt-2">"{{ $event['address'] }}"</p>
                            </div>
                            
                            @if (!empty($event['map_link']))
                                <a href="{{ $event['map_link'] }}" target="_blank" class="inline-block mt-4 text-xs font-bold underline hover:text-[#c8553d] transition">
                                    LIHAT PETA LOKASI ->
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- GALLERY (Staggered Grid) --}}
    @if (!empty($invitation->gallery_data))
        <section class="py-24 container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-display text-4xl mb-2">Rekam Jejak</h2>
                <p class="font-typewriter text-xs">Kepingan memori dalam hitam putih & warna.</p>
            </div>

            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @foreach ($invitation->gallery_data as $index => $photo)
                    <div class="break-inside-avoid relative group overflow-hidden border-4 border-white shadow-md bg-white p-1"
                         data-aos="fade-up" 
                         data-aos-delay="{{ ($index % 4) * 150 }}"> {{-- Staggered Effect Logic --}}
                        
                        <img src="{{ asset($photo) }}" 
                             class="w-full h-auto object-cover grayscale contrast-125 transition-all duration-1000 ease-in-out group-hover:grayscale-0 group-hover:scale-105">
                        
                        {{-- Overlay Date Stamp --}}
                        <div class="absolute bottom-4 right-4 text-[#c8553d] font-typewriter text-[10px] font-bold opacity-0 group-hover:opacity-80 transition duration-500 transform translate-y-2 group-hover:translate-y-0">
                            {{ date('d / m / y') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- RSVP (Postcard Style) --}}
    <section class="py-20 container mx-auto px-6 max-w-4xl">
        <div class="bg-[#F0E6D2] p-8 md:p-12 border border-[#2c241b] shadow-[8px_8px_0px_#2c241b] relative overflow-hidden" data-aos="flip-up">
            {{-- Stamp Decoration --}}
            <div class="absolute top-4 right-4 w-20 h-24 border-2 border-dashed border-[#2c241b] flex items-center justify-center opacity-30 rotate-6">
                <span class="text-[10px] font-bold uppercase text-center">Postage<br>Paid</span>
            </div>

            <div class="relative z-10 grid md:grid-cols-2 gap-12">
                <div class="text-left">
                    <h3 class="font-display text-3xl mb-4">Kartu Pos <br>Balasan</h3>
                    <p class="text-sm font-typewriter leading-relaxed opacity-80 mb-6">
                        Kabar kehadiranmu adalah tinta emas di lembaran hari bahagia kami. Mohon kirimkan kabar sebelum hari H.
                    </p>
                    <div class="hidden md:block">
                        <i class="fa-solid fa-feather text-4xl text-[#c8553d] opacity-50"></i>
                    </div>
                </div>

                {{-- Livewire RSVP --}}
                <div class="font-typewriter">
                    @livewire('frontend.rsvp-form', ['invitation' => $invitation, 'guest' => $guest])
                </div>
            </div>
        </div>
    </section>

    {{-- GUESTBOOK --}}
    <section class="py-20 container mx-auto px-6 max-w-2xl">
        <div class="text-center mb-10">
            <h2 class="font-display text-3xl">Pesan & Kesan</h2>
            <div class="w-full h-px bg-[#2c241b] mt-4 opacity-20"></div>
        </div>
        
        <div class="retro-guestbook">
            @livewire('frontend.guest-book', ['invitation' => $invitation, 'guest' => $guest])
        </div>
    </section>

    {{-- GIFT (Amplop Coklat) --}}
    @if (!empty($invitation->gifts_data))
        <section class="py-20 bg-[#2c241b] text-[#F0E6D2] relative">
            <div class="container mx-auto px-6 text-center max-w-4xl">
                <h2 class="font-display text-3xl mb-8">Tanda Kasih</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($invitation->gifts_data as $gift)
                        <div class="bg-[#e3d5b8] text-[#2c241b] p-6 rounded-sm shadow-inner border-t-4 border-[#c8553d] relative group" data-aos="fade-up">
                            {{-- Paper Texture --}}
                            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cardboard.png')] pointer-events-none"></div>
                            
                            <div class="relative z-10">
                                <p class="font-bold text-lg mb-1">{{ $gift['bank_name'] }}</p>
                                <p class="font-typewriter font-bold text-xl tracking-widest my-3 border-b border-[#2c241b] border-dashed pb-2 inline-block">
                                    {{ $gift['account_number'] }}
                                </p>
                                <p class="text-xs uppercase tracking-wider">A.N {{ $gift['account_name'] }}</p>
                                
                                <button onclick="navigator.clipboard.writeText('{{ $gift['account_number'] }}'); alert('Disalin!');" 
                                    class="mt-4 text-xs font-bold underline hover:text-[#c8553d] transition">
                                    SALIN NOMOR
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <footer class="py-12 text-center border-t border-[#2c241b] bg-[#e3d5b8]">
        <p class="font-display text-2xl text-[#2c241b] mb-2">{{ $groom['nickname'] ?? 'G' }} & {{ $bride['nickname'] ?? 'B' }}</p>
        <p class="font-typewriter text-[10px] tracking-widest uppercase opacity-60">Arvaya De Aure - Vintage Collection</p>
    </footer>

</div>

@section('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: false, // Animasi ulang kalau discroll balik biar seru
            mirror: true,
            offset: 50,
        });
    </script>
@endsection