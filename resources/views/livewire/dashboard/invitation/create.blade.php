<div class="max-w-3xl mx-auto py-6 animate-fade-in-up dashboard-ui">

    {{-- HEADER & BREADCRUMB --}}
    <div class="mb-8 text-center">
        <div
            class="inline-flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-3 bg-white px-4 py-1.5 rounded-full border border-[#E6D9B8] shadow-sm">
            <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition">Dashboard</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span>New Project</span>
        </div>
        <h2 class="font-serif font-bold text-4xl text-[#5E4926] mb-2">Mulai Kisah Baru</h2>
        <p class="text-[#7C6339] text-sm max-w-lg mx-auto">
            Isi detail dasar acara bahagiamu. Jangan khawatir, kamu bisa mengubah dan melengkapinya nanti dengan lebih
            detail.
        </p>
    </div>

    {{-- CARD FORM --}}
    <div
        class="bg-white p-8 md:p-10 rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border border-[#E6D9B8] relative overflow-hidden">

        <!-- Hiasan Background -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-[#F9F7F2] rounded-bl-full -mr-10 -mt-10 z-0 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-32 h-32 bg-[#F9F7F2] rounded-tr-full -ml-10 -mb-10 z-0 pointer-events-none">
        </div>

        <form wire:submit="save" class="space-y-8 relative z-10">

            {{-- SECTION 1: IDENTITAS UNDANGAN --}}
            <div class="space-y-6">
                {{-- Judul --}}
                <div class="group">
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Judul
                        Undangan</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.500ms="title"
                            class="w-full pl-4 pr-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-2 focus:ring-[#B89760]/20 focus:bg-white transition-all text-sm font-medium"
                            placeholder="Contoh: The Wedding of Reza & Adinda">
                        <div class="absolute right-3 top-3 text-[#C6AC80]">
                            <i class="fa-solid fa-pen-nib"></i>
                        </div>
                    </div>
                    @error('title')
                        <span class="text-red-500 text-xs mt-1 block flex items-center gap-1"><i
                                class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug (Link URL) --}}
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Tautan Unik
                        (URL)</label>
                    <div
                        class="flex rounded-xl shadow-sm bg-[#F9F7F2] border border-[#E6D9B8] overflow-hidden focus-within:ring-2 focus-within:ring-[#B89760]/20 focus-within:border-[#B89760] transition-all">
                        <span
                            class="inline-flex items-center px-4 bg-[#F2ECDC] text-[#7C6339] text-xs font-bold border-r border-[#E6D9B8]">
                            {{ request()->getHost() }}/
                        </span>
                        <input type="text" wire:model.blur="slug"
                            class="flex-1 block w-full border-none bg-transparent py-3 px-4 text-[#5E4926] placeholder-[#C6AC80] focus:ring-0 sm:text-sm font-mono"
                            placeholder="reza-adinda">
                    </div>
                    <p class="text-[10px] text-[#9A7D4C] mt-1.5 ml-1">
                        *Gunakan huruf kecil dan tanda strip (-). Link ini akan dibagikan ke tamu.
                    </p>
                    @error('slug')
                        <span class="text-red-500 text-xs mt-1 block flex items-center gap-1"><i
                                class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="border-[#F2ECDC] border-dashed">

            {{-- SECTION 2: DATA MEMPELAI --}}
            <div>
                <h3 class="font-serif font-bold text-lg text-[#5E4926] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-group text-[#B89760]"></i> Pasangan Berbahagia
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Pria --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Mempelai
                            Pria (Panggilan)</label>
                        <input type="text" wire:model="groom_name" placeholder="Nama Pria"
                            class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-2 focus:ring-[#B89760]/20 transition-all text-sm">
                        @error('groom_name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Wanita --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Mempelai
                            Wanita (Panggilan)</label>
                        <input type="text" wire:model="bride_name" placeholder="Nama Wanita"
                            class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-2 focus:ring-[#B89760]/20 transition-all text-sm">
                        @error('bride_name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SECTION 3: TANGGAL --}}
            <div>
                <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Rencana Tanggal
                    Acara</label>
                <div class="relative">
                    <input type="date" wire:model="event_date"
                        class="w-full pl-10 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-2 focus:ring-[#B89760]/20 transition-all text-sm">
                    <div class="absolute left-3 top-2.5 text-[#C6AC80] pointer-events-none">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
                @error('event_date')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- ACTIONS --}}
            <div class="pt-6 flex items-center justify-between border-t border-[#F2ECDC]">
                <a href="{{ route('dashboard.index') }}"
                    class="text-[#7C6339] hover:text-[#5E4926] text-sm font-bold transition flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-[#F9F7F2]">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>

                <button type="submit"
                    class="px-8 py-3 bg-[#B89760] text-white rounded-full font-bold shadow-lg shadow-[#B89760]/30 hover:bg-[#9A7D4C] hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                    <span wire:loading.remove>Simpan & Lanjut</span>
                    <span wire:loading class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...
                    </span>
                    <i wire:loading.remove class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>
