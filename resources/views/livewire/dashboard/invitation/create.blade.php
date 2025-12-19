<div class="max-w-3xl mx-auto py-6 animate-fade-in-up dashboard-ui">

    {{-- HEADER & BREADCRUMB --}}
    <div class="mb-8 text-center">
        <div
            class="inline-flex items-center gap-2 text-[#A0A0A0] text-xs font-bold uppercase tracking-widest mb-3 bg-[#1a1a1a] px-4 py-1.5 rounded-full border border-[#333333] shadow-sm">
            <a href="{{ route('dashboard.index') }}" class="hover:text-[#D4AF37] transition">Dashboard</a>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span>New Project</span>
        </div>
        <h2 class="font-serif font-bold text-4xl text-[#E0E0E0] mb-2">Mulai Kisah Baru</h2>
        <p class="text-[#A0A0A0] text-sm max-w-lg mx-auto">
            Isi detail dasar acara bahagiamu. Jangan khawatir, kamu bisa mengubah dan melengkapinya nanti dengan lebih
            detail.
        </p>
    </div>

    @if ($step === 1)
        {{-- STEP 1: PILIH TEMPLATE --}}
        <div class="space-y-8 animate-fade-in-up">
            {{-- Category Filters --}}
            <div class="flex flex-wrap justify-center gap-2">
                @foreach (['All', 'Wedding', 'Engagement', 'Birthday', 'Aqiqah', 'Khitan', 'Event'] as $cat)
                    <button wire:click="setFilter('{{ $cat }}')"
                        class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider border transition-all
                        {{ $selectedFilter === $cat ? 'bg-[#D4AF37] text-[#121212] border-[#D4AF37] shadow-lg shadow-[#D4AF37]/20' : 'bg-[#1a1a1a] text-[#A0A0A0] border-[#333333] hover:border-[#D4AF37] hover:text-[#D4AF37]' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            {{-- Template Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($templates as $tpl)
                    <div class="group bg-[#1a1a1a] rounded-2xl border border-[#333333] overflow-hidden hover:border-[#D4AF37] transition-all cursor-pointer shadow-lg hover:shadow-xl hover:-translate-y-1"
                        wire:click="selectTemplate('{{ $tpl->slug }}')">
                        <div class="aspect-[9/16] relative overflow-hidden bg-[#252525]">
                            @if ($tpl->thumbnail)
                                <img src="{{ asset('storage/' . $tpl->thumbnail) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-[#888]">
                                    <i class="fa-solid fa-image text-3xl mb-2"></i>
                                    <span class="text-[10px] font-bold">No Preview</span>
                                </div>
                            @endif
                            <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
                                <span class="px-2 py-1 bg-black/60 backdrop-blur-md rounded text-[9px] font-bold text-white uppercase tracking-wider border border-white/10">
                                    {{ $tpl->tier }}
                                </span>
                                @if($tpl->category)
                                    <span class="px-2 py-1 bg-blue-500/80 backdrop-blur-md rounded text-[9px] font-bold text-white uppercase tracking-wider border border-white/10">
                                        {{ $tpl->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4 pt-12 translate-y-full group-hover:translate-y-0 transition duration-300">
                                <p class="text-[#D4AF37] text-xs font-bold uppercase tracking-wider text-center">Pilih Template Ini <i class="fa-solid fa-arrow-right ml-1"></i></p>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-serif font-bold text-[#E0E0E0] text-sm truncate">{{ $tpl->name }}</h3>
                            <p class="text-[10px] text-[#A0A0A0] mt-1">Rp {{ number_format($tpl->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center text-[#666] mx-auto mb-4">
                            <i class="fa-solid fa-folder-open text-2xl"></i>
                        </div>
                        <p class="text-[#A0A0A0] text-sm font-bold">Belum ada template untuk kategori ini.</p>
                        <p class="text-[10px] text-[#666] mt-1">Coba pilih kategori lain.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @elseif ($step === 2)
        {{-- STEP 2: ISI DATA --}}
        <div class="animate-fade-in-up">
            <div class="bg-[#1a1a1a] p-8 md:p-10 rounded-3xl shadow-xl border border-[#333333] relative overflow-hidden">
                
                {{-- Header with Back Button --}}
                <div class="flex items-center justify-between mb-8 border-b border-[#333333] pb-6">
                    <div>
                        <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">Lengkapi Data</h3>
                        <p class="text-[#A0A0A0] text-xs mt-1">Template terpilih: <span class="text-[#D4AF37] font-bold">{{ $selectedTemplateName }}</span></p>
                    </div>
                    <button wire:click="backToStep1" class="text-xs font-bold text-[#A0A0A0] hover:text-[#E0E0E0] flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-[#252525] transition">
                        <i class="fa-solid fa-arrow-left"></i> Ganti Template
                    </button>
                </div>

                <form wire:submit="save" class="space-y-8 relative z-10">

                    {{-- SECTION 1: IDENTITAS UNDANGAN --}}
                    <div class="space-y-6">
                        {{-- Judul --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Judul Undangan</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.500ms="title"
                                    class="w-full pl-4 pr-4 py-3 rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] placeholder-[#666] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 focus:bg-[#2d2d2d] transition-all text-sm font-medium"
                                    placeholder="Contoh: The Wedding of Reza & Adinda">
                                <div class="absolute right-3 top-3 text-[#888]">
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
                            <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Tautan Unik (URL)</label>
                            <div
                                class="flex rounded-xl shadow-sm bg-[#252525] border border-[#333333] overflow-hidden focus-within:ring-2 focus-within:ring-[#D4AF37]/20 focus-within:border-[#D4AF37] transition-all">
                                <span
                                    class="inline-flex items-center px-4 bg-[#2d2d2d] text-[#A0A0A0] text-xs font-bold border-r border-[#333333]">
                                    {{ request()->getHost() }}/
                                </span>
                                <input type="text" wire:model.blur="slug"
                                    class="flex-1 block w-full border-none bg-transparent py-3 px-4 text-[#E0E0E0] placeholder-[#666] focus:ring-0 sm:text-sm font-mono"
                                    placeholder="reza-adinda">
                            </div>
                            <p class="text-[10px] text-[#888] mt-1.5 ml-1">
                                *Gunakan huruf kecil dan tanda strip (-). Link ini akan dibagikan ke tamu.
                            </p>
                            @error('slug')
                                <span class="text-red-500 text-xs mt-1 block flex items-center gap-1"><i
                                        class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <hr class="border-[#333333] border-dashed">

                    {{-- SECTION 2: DYNAMIC DATA BASED ON CATEGORY --}}
                    <div>
                        {{-- WEDDING / ENGAGEMENT --}}
                        @if (in_array($selectedCategory, ['Wedding', 'Engagement']))
                            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-user-group text-[#D4AF37]"></i> Pasangan Berbahagia
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Pria (Panggilan)</label>
                                    <input type="text" wire:model="groom_name" placeholder="Nama Pria"
                                        class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                    @error('groom_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Wanita (Panggilan)</label>
                                    <input type="text" wire:model="bride_name" placeholder="Nama Wanita"
                                        class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                    @error('bride_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        
                        {{-- BIRTHDAY --}}
                        @elseif ($selectedCategory === 'Birthday')
                            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-cake-candles text-[#D4AF37]"></i> Profil Ulang Tahun
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Nama Panggilan</label>
                                    <input type="text" wire:model="name" placeholder="Contoh: Budi"
                                        class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Ulang Tahun Ke-</label>
                                    <input type="text" wire:model="age" placeholder="Contoh: 17th"
                                        class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                    @error('age') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        {{-- AQIQAH / KHITAN --}}
                        @elseif (in_array($selectedCategory, ['Aqiqah', 'Khitan']))
                            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-baby text-[#D4AF37]"></i> Data Anak
                            </h3>
                            <div>
                                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Nama Panggilan Anak</label>
                                <input type="text" wire:model="child_name" placeholder="Nama Anak"
                                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                @error('child_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        {{-- EVENT --}}
                        @elseif ($selectedCategory === 'Event')
                            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-calendar-star text-[#D4AF37]"></i> Detail Acara
                            </h3>
                            <div>
                                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Penyelenggara / Host</label>
                                <input type="text" wire:model="organizer" placeholder="Nama Penyelenggara"
                                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                @error('organizer') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        
                        {{-- GENERIC --}}
                        @else
                            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-user text-[#D4AF37]"></i> Profil Utama
                            </h3>
                            <div>
                                <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Nama / Judul</label>
                                <input type="text" wire:model="name" placeholder="Nama Utama"
                                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>

                    {{-- SECTION 3: TANGGAL --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Rencana Tanggal Acara</label>
                        <div class="relative">
                            <input type="date" wire:model="event_date"
                                class="w-full pl-10 rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition-all text-sm">
                            <div class="absolute left-3 top-2.5 text-[#888] pointer-events-none">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                        </div>
                        @error('event_date')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ACTIONS --}}
                    <div class="pt-6 flex items-center justify-end border-t border-[#333333]">
                        <button type="submit"
                            class="px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-full font-bold shadow-lg shadow-[#D4AF37]/30 hover:bg-[#B4912F] hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
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
    @endif
</div>