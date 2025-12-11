<div class="py-2 animate-fade-in-up">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Koleksi Undangan</h2>
            <p class="text-[#9A7D4C] text-sm mt-1 font-medium">Kelola momen bahagiamu di sini.</p>
        </div>
        {{-- TOMBOL CREATE (Benar: Tidak butuh ID) --}}
        <a href="{{ route('dashboard.create') }}"
            class="group bg-[#B89760] hover:bg-[#9A7D4C] text-white px-6 py-3 rounded-full text-sm font-bold shadow-lg shadow-[#B89760]/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
            <div
                class="bg-white/20 rounded-full w-5 h-5 flex items-center justify-center group-hover:rotate-90 transition duration-300">
                <i class="fa-solid fa-plus text-xs"></i>
            </div>
            Buat Undangan Baru
        </a>
    </div>

    {{-- ALERT MESSAGE --}}
    @if (session('status'))
        <div
            class="mb-6 bg-[#F2ECDC] border border-[#B89760] text-[#7C6339] px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm relative overflow-hidden">
            <div class="w-1 absolute left-0 top-0 bottom-0 bg-[#B89760]"></div>
            <i class="fa-solid fa-circle-check text-xl text-[#B89760]"></i>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif

    {{-- GRID CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($invitations as $invitation)
            <div
                class="group bg-white rounded-2xl border border-[#E6D9B8]/60 shadow-[0_4px_20px_rgb(230,217,184,0.3)] hover:shadow-[0_8px_30px_rgb(184,151,96,0.2)] transition-all duration-300 flex flex-col overflow-hidden relative">

                {{-- LOGIC BADGE STATUS & LINK --}}
                @php
                    $badgeColor = 'bg-gray-100 text-gray-600';
                    $badgeIcon = 'fa-wallet';
                    $badgeText = 'Pay Now';
                    $linkUrl = route('dashboard.invitation.checkout', $invitation->id);
                    $isClickable = true;

                    if ($invitation->payment_status == 'paid') {
                        $badgeColor = 'bg-green-100/90 text-green-700 border-green-200';
                        $badgeIcon = 'fa-check-circle';
                        $badgeText = 'Active';
                        $linkUrl = '#';
                        $isClickable = false;
                    } elseif ($invitation->payment_status == 'pending') {
                        $badgeColor = 'bg-yellow-100/90 text-yellow-700 border-yellow-200 cursor-wait';
                        $badgeIcon = 'fa-hourglass-half';
                        $badgeText = 'Verifikasi';
                        $linkUrl = '#'; // Tidak bisa klik saat pending
                        $isClickable = false;
                    } elseif ($invitation->payment_status == 'rejected') {
                        $badgeColor = 'bg-red-100/90 text-red-700 border-red-200 animate-pulse';
                        $badgeIcon = 'fa-triangle-exclamation';
                        $badgeText = 'Ditolak (Cek)';
                        // Tetap ke checkout untuk upload ulang
                    } else {
                        // Unpaid
                        $badgeColor = 'bg-[#B89760] text-white shadow-md hover:bg-[#9A7D4C]';
                    }
                @endphp

                <a href="{{ $linkUrl }}" @if (!$isClickable) onclick="return false;" @endif
                    class="absolute top-4 right-4 z-10 px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm backdrop-blur-md border border-white/20 transition-all flex items-center gap-1.5 {{ $badgeColor }}">
                    <i class="fa-solid {{ $badgeIcon }}"></i> {{ $badgeText }}
                </a>

                {{-- TAMPILKAN ALASAN REJECT DI BAWAH CARD (OPSIONAL) --}}
                @if ($invitation->payment_status == 'rejected')
                    <div class="absolute inset-x-0 bottom-0 bg-red-50 p-2 text-center border-t border-red-100">
                        <p class="text-[10px] text-red-600">
                            <span class="font-bold">Info:</span> {{ $invitation->rejection_reason }}
                        </p>
                    </div>
                @endif

                {{-- CARD HEADER (Visual) --}}
                <div
                    class="h-32 bg-gradient-to-br from-[#D4C1A0] to-[#B89760] relative overflow-hidden p-6 flex flex-col justify-end">
                    <!-- Abstract Pattern -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl transform translate-x-10 -translate-y-10">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 bg-[#5E4926]/10 rounded-full blur-xl transform -translate-x-5 translate-y-5">
                    </div>

                    <h3 class="font-serif font-bold text-xl text-white truncate drop-shadow-sm relative z-10">
                        {{ $invitation->title }}
                    </h3>
                    <p class="text-white/80 text-xs font-sans relative z-10 flex items-center gap-1 mt-1">
                        <i class="fa-regular fa-calendar"></i>
                        {{ $invitation->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>

                {{-- CARD BODY --}}
                <div class="p-6 flex-1 flex flex-col">

                    {{-- STATISTIK GRID (Total Tamu & Views) --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Tamu Count -->
                        <div class="bg-[#F9F7F2] p-3 rounded-xl border border-[#E6D9B8]/50 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-[#E6D9B8] flex items-center justify-center text-[#5E4926]">
                                <i class="fa-solid fa-users text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#9A7D4C] font-bold uppercase tracking-wide">Tamu</p>
                                <p class="text-sm font-bold text-[#5E4926]">
                                    {{ $invitation->guests_count ?? $invitation->guests->count() }}
                                </p>
                            </div>
                        </div>

                        <!-- View Count -->
                        <div class="bg-[#F9F7F2] p-3 rounded-xl border border-[#E6D9B8]/50 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-[#E6D9B8] flex items-center justify-center text-[#5E4926]">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-[#9A7D4C] font-bold uppercase tracking-wide">Dilihat</p>
                                <p class="text-sm font-bold text-[#5E4926]">{{ $invitation->visit_count }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- LINK PREVIEW --}}
                    <div class="mb-6">
                        <label class="text-[10px] uppercase font-bold text-[#9A7D4C] tracking-wider mb-1 block">Tautan
                            Undangan</label>
                        <div
                            class="bg-white border border-dashed border-[#C6AC80] p-2 rounded-lg flex justify-between items-center group/link hover:border-solid hover:border-[#B89760] transition-all">
                            <span class="text-xs text-[#7C6339] truncate w-2/3 pl-1 font-mono">
                                {{ request()->getHost() }}/{{ $invitation->slug }}
                            </span>
                            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                class="text-[10px] bg-[#F2ECDC] hover:bg-[#B89760] text-[#7C6339] hover:text-white px-3 py-1.5 rounded transition-colors font-bold flex items-center gap-1">
                                Preview <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="mt-auto grid grid-cols-4 gap-2 pt-4 border-t border-[#F2ECDC]">
                        <!-- Edit (Primary) -->
                        <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                            class="col-span-2 text-center py-2.5 bg-[#5E4926] hover:bg-[#403013] text-white text-xs font-bold rounded-lg transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-pen-nib"></i> Edit Undangan
                        </a>

                        <!-- Guest Manager -->
                        <a href="{{ route('dashboard.guests.index', $invitation->id) }}"
                            class="col-span-1 text-center py-2.5 bg-white border border-[#C6AC80] text-[#7C6339] hover:bg-[#F2ECDC] text-xs font-bold rounded-lg transition flex items-center justify-center"
                            title="Kelola Tamu">
                            <i class="fa-solid fa-user-group text-sm"></i>
                        </a>

                        <!-- Delete -->
                        <button wire:click="delete({{ $invitation->id }})"
                            wire:confirm="Yakin ingin menghapus undangan ini? Data tamu juga akan terhapus."
                            class="col-span-1 text-center py-2.5 bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 hover:border-red-200 rounded-lg transition flex items-center justify-center"
                            title="Hapus">
                            <i class="fa-regular fa-trash-can text-sm"></i>
                        </button>
                    </div>

                </div>
            </div>
        @empty
            {{-- EMPTY STATE (Arvaya Style) --}}
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border-2 border-dashed border-[#E6D9B8]">
                <div
                    class="w-20 h-20 bg-[#F9F7F2] rounded-full flex items-center justify-center mx-auto mb-4 text-[#B89760]">
                    <i class="fa-regular fa-heart text-4xl animate-pulse"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-[#5E4926] mb-2">Belum ada undangan</h3>
                <p class="text-[#9A7D4C] mb-6 max-w-sm mx-auto text-sm">
                    Kisah bahagiamu dimulai dari sini. Buat undangan pertamamu dengan desain eksklusif kami.
                </p>
                <a href="{{ route('dashboard.create') }}"
                    class="inline-block px-8 py-3 bg-[#B89760] text-white rounded-full font-bold hover:bg-[#9A7D4C] transition shadow-lg">
                    Mulai Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>
