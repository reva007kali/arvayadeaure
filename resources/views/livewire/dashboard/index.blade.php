<div class="py-2 animate-fade-in-up dashboard-ui">

    {{-- PROMOTIONAL BANNER (SWIPER) --}}
    <div class="mb-10 overflow-hidden relative group">
        <!-- Swiper -->
        <div class="swiper promoSwiper w-full h-full"
            style="--swiper-pagination-color: #403013; --swiper-pagination-bullet-inactive-color: #ffffff; --swiper-pagination-bullet-inactive-opacity: 0.6;">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img class="rounded-xl border border-arvaya-500" src="{{ asset('img/banner/banner-1.png') }}"
                        alt="">
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img class="rounded-xl border border-arvaya-500" src="{{ asset('img/banner/banner-2.png') }}"
                        alt="">
                </div>

            </div>
            <!-- Pagination -->
            <div class="swiper-pagination !bottom-2"></div>
        </div>
    </div>


    {{-- ALERT MESSAGE --}}
    @if (session('status'))
        <div
            class="mb-6 bg-[#252525] border border-[#D4AF37] text-[#E0E0E0] px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm relative overflow-hidden">
            <div class="w-1 absolute left-0 top-0 bottom-0 bg-[#D4AF37]"></div>
            <i class="fa-solid fa-circle-check text-xl text-[#D4AF37]"></i>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif

    {{-- STATS SECTION --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div
            class="bg-[#1a1a1a] p-5 rounded-3xl border border-[#333333] flex items-center gap-4 shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fa-solid fa-envelope-open-text text-6xl text-arvaya-500"></i>
            </div>
            <div
                class="w-12 h-12 rounded-full bg-arvaya-500/10 text-arvaya-500 flex items-center justify-center text-xl shrink-0 border border-arvaya-500/20">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] uppercase font-bold tracking-wider mb-1">Total Undangan</p>
                <p class="text-2xl font-serif font-bold text-[#E0E0E0]">{{ $invitations->count() }}</p>
            </div>
        </div>
        <div
            class="bg-[#1a1a1a] p-5 rounded-3xl border border-[#333333] flex items-center gap-4 shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fa-solid fa-users text-6xl text-arvaya-500"></i>
            </div>
            <div
                class="w-12 h-12 rounded-full bg-arvaya-500/10 text-arvaya-500 flex items-center justify-center text-xl shrink-0 border border-arvaya-500/20">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] uppercase font-bold tracking-wider mb-1">Total Tamu</p>
                <p class="text-2xl font-serif font-bold text-[#E0E0E0]">
                    {{ $invitations->sum(fn($i) => $i->guests_count ?? $i->guests->count()) }}
                </p>
            </div>
        </div>
    </div>

    {{-- HEADER SECTION --}}
    <div class="flex  justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-2xl text-[#E0E0E0]">Koleksi Undangan</h2>
            <p class="text-[#A0A0A0] text-sm mt-1 font-medium">Kelola momen bahagiamu di sini.</p>
        </div>
        {{-- TOMBOL CREATE (Benar: Tidak butuh ID) --}}
        <a href="{{ route('dashboard.create') }}"
            class="group bg-[#D4AF37] hover:bg-[#B4912F] text-[#121212] px-4 py-3 rounded-full text-sm font-bold shadow-lg shadow-[#D4AF37]/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
            <div
                class="bg-black/10 rounded-full w-5 h-5 flex items-center justify-center group-hover:rotate-90 transition duration-300">
                <i class="fa-solid fa-plus text-xs"></i>
            </div>
            Undangan
        </a>
    </div>
    {{-- HEADER SECTION --}}


    {{-- SEARCH BAR --}}
    <div class="mb-6">
        <div class="relative w-full md:w-80">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full pl-10 pr-4 py-2 rounded-full border border-[#333333] bg-[#1a1a1a] text-sm text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37] placeholder-[#666]"
                placeholder="Cari undangan...">
            <div class="absolute left-3 top-2.5 text-[#D4AF37]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>
    {{-- SEARCH BAR --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($invitations as $invitation)
            @php
                $event = $invitation->event_data[0] ?? [];
                $eventDate = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
                $coverImage = 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600&auto=format&fit=crop';
                if (!empty($invitation->gallery_data['cover'])) {
                    $coverImage = asset($invitation->gallery_data['cover']);
                }
            @endphp
            <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                class="block rounded-2xl border-2 border-[#333333] bg-[#1a1a1a] overflow-hidden shadow-xl hover:shadow-2xl transition">
                <div class="h-40 relative bg-cover bg-center" style="background-image: url('{{ $coverImage }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
                    <div class="flex justify-between items-end gap-1 shrink-0">
                        <div
                            class="px-2 py-1 bg-arvaya-500 rounded-br-2xl text-[10px] text-white uppercase tracking-wider">
                            {{ $invitation->template->name ?? $invitation->theme_template }}
                        </div>
                        <div
                            class="px-2 py-1 rounded-full text-[10px] font-bold
                                    {{ $invitation->payment_status === 'paid' ? 'bg-green-90text-green-500 border border-green-900/30' : ($invitation->payment_st === 'pending' ? 'bg-yellow-900/20 text-yellow-500 border border-yellow30' : ($invitation->payment_status === 'rejected' ? 'bg-red-90text-red-500 border border-red-900/30' : 'bg-[#252525] text-[#E0Eborder border-[#333333]')) }}">
                            {{ ucfirst($invitation->payment_status) }}
                        </div>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="font-serif font-bold text-lg text-[#E0E0E0] truncate">{{ $invitation->title }}</p>
                        <p class="text-[#D4AF37] text-xs font-bold mt-1 flex items-center gap-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ $eventDate ? $eventDate->translatedFormat('l, d F Y') : 'Tanggal belum ditentukan' }}</span>
                        </p>
                    </div>
                </div>
            </a>


        @empty
            {{-- EMPTY STATE (Arvaya Style) --}}
            <div class="col-span-full py-16 text-center bg-[#1a1a1a] rounded-2xl border-2 border-dashed border-[#333333]">
                <div
                    class="w-20 h-20 bg-[#252525] rounded-full flex items-center justify-center mx-auto mb-4 text-[#D4AF37]">
                    <i class="fa-regular fa-heart text-4xl animate-pulse"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-[#E0E0E0] mb-2">Belum ada undangan</h3>
                <p class="text-[#A0A0A0] mb-6 max-w-sm mx-auto text-sm">
                    Kisah bahagiamu dimulai dari sini. Buat undangan pertamamu dengan desain eksklusif kami.
                </p>
                <a href="{{ route('dashboard.create') }}"
                    class="inline-block px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-full font-bold hover:bg-[#B4912F] transition shadow-lg">
                    Mulai Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <script>
        document.addEventListener('livewire:navigated', () => {
            initSwiper();
        });

        document.addEventListener('DOMContentLoaded', () => {
            initSwiper();
        });

        function initSwiper() {
            if (document.querySelector('.promoSwiper')) {
                new Swiper(".promoSwiper", {
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                    },
                    effect: "fade",
                    fadeEffect: {
                        crossFade: true
                    },
                });
            }
        }
    </script>
</div>