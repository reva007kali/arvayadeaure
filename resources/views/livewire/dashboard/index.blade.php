<div class="py-2 animate-fade-in-up dashboard-ui">

    {{-- PROMOTIONAL BANNER (SWIPER) --}}
    <div
        class="mb-10 overflow-hidden relative group">
        <!-- Swiper -->
        <div class="swiper promoSwiper w-full h-full"
            style="--swiper-pagination-color: #403013; --swiper-pagination-bullet-inactive-color: #ffffff; --swiper-pagination-bullet-inactive-opacity: 0.6;">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img class="rounded-xl border border-arvaya-500" src="{{ asset('img/banner/banner-1.png') }}" alt="">
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img class="rounded-xl border border-arvaya-500" src="{{ asset('img/banner/banner-2.png') }}" alt="">
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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($invitations as $invitation)
            <div x-data="{ expanded: false }"
                class="group bg-[#1a1a1a] rounded-[2rem] border-2 border-[#333333] shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden relative">

                {{-- LOGIC BADGE STATUS & LINK --}}
                @php
                    $badgeColor = 'bg-gray-100 text-gray-600';
                    $badgeIcon = 'fa-wallet';
                    $badgeText = 'Pay Now';
                    $linkUrl = route('dashboard.invitation.checkout', $invitation->id);
                    $isClickable = true;

                    if ($invitation->payment_status == 'paid') {
                        $badgeColor = 'bg-green-900/30 text-green-500 border-green-900/50';
                        $badgeIcon = 'fa-check-circle';
                        $badgeText = 'Active';
                        $linkUrl = '#';
                        $isClickable = false;
                    } elseif ($invitation->payment_status == 'pending') {
                        $badgeColor = 'bg-yellow-900/30 text-yellow-500 border-yellow-900/50 cursor-wait';
                        $badgeIcon = 'fa-hourglass-half';
                        $badgeText = 'Verifikasi';
                        $linkUrl = '#'; // Tidak bisa klik saat pending
                        $isClickable = false;
                    } elseif ($invitation->payment_status == 'rejected') {
                        $badgeColor = 'bg-red-900/30 text-red-500 border-red-900/50 animate-pulse';
                        $badgeIcon = 'fa-triangle-exclamation';
                        $badgeText = 'Ditolak (Cek)';
                        // Tetap ke checkout untuk upload ulang
                    } else {
                        // Unpaid
                        $badgeColor = 'bg-white text-[#121212] shadow-md hover:bg-[#B4912F]';
                    }
                @endphp

                {{-- TAMPILKAN ALASAN REJECT DI BAWAH CARD (OPSIONAL) --}}
                @if ($invitation->payment_status == 'rejected')
                    <div class="absolute inset-x-0 bottom-0 bg-red-900/20 p-2 text-center border-t border-red-900/30">
                        <p class="text-[10px] text-red-500">
                            <span class="font-bold">Info:</span> {{ $invitation->rejection_reason }}
                        </p>
                    </div>
                @endif

                {{-- CARD HEADER (Visual) --}}
                @php
                    $coverImage = 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600&auto=format&fit=crop';
                    if (!empty($invitation->gallery_data['cover'])) {
                        $coverImage = asset($invitation->gallery_data['cover']);
                    }
                @endphp

                <div @click="if(window.innerWidth < 768) expanded = !expanded"
                    class="relative h-64 overflow-hidden p-6 cursor-pointer md:cursor-default transition-all bg-cover bg-center group/card"
                    style="background-image: url('{{ $coverImage }}');">

                    {{-- Dark Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/30 z-0"></div>

                    {{-- Gold Glow Effect --}}
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-[#D4AF37]/20 rounded-full blur-3xl transform translate-x-10 -translate-y-10 z-0">
                    </div>

                    <div class="relative z-10 flex flex-col justify-between h-full">
                        {{-- Top Section: Icon & Chevron --}}
                        <div class="flex justify-between items-start">
                            {{-- Icon Box --}}
                            <div
                                class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-[#D4AF37] shadow-lg border border-white/10 shrink-0">
                                <i class="fa-solid fa-envelope-open-text text-lg"></i>
                            </div>

                            {{-- Arrow Icon for Mobile --}}
                            <div
                                class="md:hidden text-white/80 bg-black/20 p-2 rounded-full backdrop-blur-sm border border-white/5">
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-sm"
                                    :class="expanded ? 'rotate-180' : ''"></i>
                            </div>
                        </div>

                        {{-- Bottom Section: Title & Date --}}
                        <div>
                            <h3
                                class="font-serif font-bold text-2xl text-white drop-shadow-md leading-tight mb-2 break-words">
                                {{ $invitation->title }}
                            </h3>
                            <p
                                class="text-[#D4AF37] text-xs font-sans flex items-center gap-2 font-bold bg-black/40 backdrop-blur-sm w-fit px-3 py-1.5 rounded-full border border-[#D4AF37]/30">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $invitation->created_at->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="p-6 flex-1 flex flex-col transition-all duration-300 ease-in-out"
                    x-show="expanded || window.innerWidth >= 768" x-collapse>

                    {{-- STATISTIK GRID (Total Tamu & Views) --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Tamu Count -->
                        <div
                            class="bg-[#252525] p-4 rounded-xl border border-[#333333] flex items-center gap-3 shadow-sm hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-full bg-[#333] flex items-center justify-center text-[#D4AF37]">
                                <i class="fa-solid fa-users text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wide">Tamu</p>
                                <p class="text-base font-bold text-[#E0E0E0]">
                                    {{ $invitation->guests_count ?? $invitation->guests->count() }}
                                </p>
                            </div>
                        </div>

                        <!-- View Count -->
                        <div
                            class="bg-[#252525] p-4 rounded-xl border border-[#333333] flex items-center gap-3 shadow-sm hover:shadow-md transition">
                            <div class="w-9 h-9 rounded-full bg-[#333] flex items-center justify-center text-[#D4AF37]">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wide">Dilihat</p>
                                <p class="text-base font-bold text-[#E0E0E0]">{{ $invitation->visit_count }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- LINK PREVIEW --}}
                    <div class="mb-6">
                        <label class="text-[10px] uppercase font-bold text-[#A0A0A0] tracking-wider mb-1 block">Tautan
                            Undangan</label>
                        <div
                            class="bg-[#252525] border border-[#333333] p-2 rounded-xl flex justify-between items-center group/link hover:shadow-md transition">
                            <span class="text-xs text-[#E0E0E0] truncate w-2/3 pl-1 font-mono">
                                {{ request()->getHost() }}/{{ $invitation->slug }}
                            </span>
                            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                class="text-[10px] bg-[#333] hover:bg-[#D4AF37] text-[#D4AF37] hover:text-[#121212] px-3 py-1.5 rounded-xl transition-colors font-bold flex items-center gap-1">
                                Preview <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="mt-auto grid grid-cols-2 gap-5 pt-4 border-t border-[#333333]">
                        <!-- Payment / Status Button (Moved Here) -->
                        <a href="{{ $linkUrl }}" @if (!$isClickable) onclick="return false;" @endif
                            class="col-span-2 text-center py-3 rounded-xl font-bold uppercase tracking-wider shadow-md transition-all flex items-center justify-center gap-2 text-xs
                                    {{ $badgeColor === 'bg-white text-[#121212] shadow-md hover:bg-[#B4912F]' ? 'bg-[#252525] border border-[#D4AF37] text-[#D4AF37] hover:bg-[#D4AF37] hover:text-[#121212]' : $badgeColor }}">
                            <i class="fa-solid {{ $badgeIcon }}"></i> {{ $badgeText }}
                        </a>

                        <!-- Edit (Primary) -->
                        <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                            class="col-span-2 text-center py-3 bg-[#D4AF37] hover:bg-[#B4912F] text-[#121212] text-xs font-bold rounded-xl transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <i class="fa-solid fa-pen-nib"></i> Manage Undangan
                        </a>

                        <!-- Guest Manager -->
                        <a href="{{ route('dashboard.guests.index', $invitation->id) }}"
                            class="col-span-1 text-center py-2.5 bg-[#252525] border border-[#333333] text-[#E0E0E0] hover:bg-[#2d2d2d] text-xs font-bold rounded-xl transition flex items-center justify-center shadow-sm hover:shadow-md"
                            title="Kelola Tamu">
                            <i class="fa-solid fa-user-group text-sm mr-2"></i>
                            Kelola Tamu
                        </a>

                        <!-- Delete -->
                        <button wire:click="delete({{ $invitation->id }})"
                            wire:confirm="Yakin ingin menghapus undangan ini? Data tamu juga akan terhapus."
                            class="col-span-1 text-center py-2.5 bg-red-900/20 hover:bg-red-900/30 text-red-500 border border-red-900/30 hover:border-red-900/50 rounded-xl transition flex items-center justify-center shadow-sm hover:shadow-md"
                            title="Hapus">
                            <i class="fa-regular fa-trash-can text-sm"></i>
                        </button>
                    </div>

                </div>
            </div>
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