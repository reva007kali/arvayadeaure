<div class=" animate-fade-in-up min-h-screen dashboard-ui">

    {{-- CSS Khusus untuk Scrollbar Modal agar rapi --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #333;
            border-radius: 8px;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <div class="flex items-center gap-2 text-[#888] text-[10px] font-bold uppercase tracking-widest mb-1">
                    <a href="{{ route('dashboard.index') }}"
                        class="hover:text-[#D4AF37] transition flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left"></i> Dashboard
                    </a>
                    <span>/</span> <span>Editor</span>
                </div>
                <h2 class="font-serif font-bold text-2xl text-[#E0E0E0]">Studio Undangan</h2>
                <p class="text-[#A0A0A0] text-xs mt-1 flex items-center gap-2">
                    <span class="font-serif italic text-[#D4AF37]">{{ $invitation->title }}</span>
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                    class="px-4 py-2 bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] rounded-xl hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300 font-bold text-[10px] uppercase tracking-wide flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-eye"></i> Preview
                </a>
                <a href="{{ route('dashboard.guests.index', $invitation->id) }}" wire:navigate
                    class="px-4 py-2 text-center bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] rounded-xl hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300 font-bold text-[10px] uppercase tracking-wide flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-user-group"></i> Kelola Tamu
                </a>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
                class="fixed top-6 right-6 z-[9999] bg-[#1a1a1a] border-l-4 border-[#D4AF37] text-[#E0E0E0] px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 max-w-md">
                <div class="w-8 h-8 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-xs text-[#A0A0A0] mt-0.5">{{ session('message') }}</p>
                </div>
                <button @click="show = false" class="text-[#888] hover:text-[#E0E0E0] transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- MAIN CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- MENU NAVIGATION (Full Width on Mobile, Grid on Desktop) --}}
            <div class="lg:col-span-12">
                <div>
                    <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                        @php
                            $menus = [
                                ['id' => 'couple_bio', 'icon' => 'fa-user-group', 'label' => 'Mempelai'],
                                ['id' => 'couple_quote', 'icon' => 'fa-quote-left', 'label' => 'Kata Pengantar'],
                                ['id' => 'events', 'icon' => 'fa-calendar-days', 'label' => 'Acara'],
                                ['id' => 'gallery', 'icon' => 'fa-images', 'label' => 'Galeri'],
                                ['id' => 'gifts', 'icon' => 'fa-gift', 'label' => 'Kado'],
                                ['id' => 'theme', 'icon' => 'fa-palette', 'label' => 'Tema'],
                                ['id' => 'music', 'icon' => 'fa-music', 'label' => 'Musik'],
                            ];
                        @endphp

                        @foreach ($menus as $menu)
                                            <button wire:click="openModal('{{ $menu['id'] }}')" class="flex flex-col items-center justify-center gap-2 p-4 rounded-2xl transition-all duration-300 border
                                                                        {{ $activeTab === $menu['id']
                            ? 'bg-[#1a1a1a] border-[#D4AF37] shadow-[inset_0_2px_4px_rgba(0,0,0,0.6)]'
                            : 'bg-[#1a1a1a] border-[#333333] hover:border-[#D4AF37] hover:shadow-lg' }}">
                                                <div
                                                    class="text-xl transition-all duration-300
                                                                            {{ $activeTab === $menu['id'] ? 'text-[#D4AF37]' : 'text-arvaya-500 md:text-[#888] md:group-hover:text-[#D4AF37]' }}">
                                                    <i class="fa-solid {{ $menu['icon'] }}"></i>
                                                </div>
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-wider {{ $activeTab === $menu['id'] ? 'text-[#D4AF37]' : 'text-[#A0A0A0]' }}">{{ $menu['label'] }}</span>
                                            </button>
                        @endforeach

                        <a href="{{ route('dashboard.guests.index', $invitation->id) }}" wire:navigate
                            class="flex flex-col items-center justify-center text-center gap-2 p-4 rounded-2xl transition-all duration-300 border bg-[#1a1a1a] border-[#333333] hover:border-[#D4AF37] hover:shadow-lg">
                            <div class="text-xl text-arvaya-500 md:text-[#888] transition-all duration-300">
                                <i class="fa-solid fa-user-group"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#A0A0A0]">Kelola
                                Tamu</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL AREA --}}
        <div wire:loading.delay wire:target="openModal"
            class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-[#1a1a1a] border border-[#333333] rounded-2xl px-6 py-5 shadow-xl text-center">
                <div class="mb-3 text-[#D4AF37]">
                    <i class="fa-solid fa-circle-notch fa-spin text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-[#E0E0E0]">Membuka editor...</p>
                <p class="text-[10px] text-[#A0A0A0] mt-1">Mohon tunggu sebentar</p>
            </div>
        </div>
        @if ($modalOpen)
            {{--
            FIX: Z-Index 9999 memastikan modal di atas segalanya.
            FIX: position fixed inset-0 memastikan full screen.
            --}}
            <div class="fixed inset-0 z-[9999] w-full h-full flex items-center justify-center px-4 py-6" x-data
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                {{-- Backdrop dengan Blur yang lebih pekat --}}
                <div class="absolute inset-0 bg-black/80 backdrop-blur-md transition-opacity" wire:click="closeModal">
                </div>

                {{-- Modal Container --}}
                <div
                    class="relative w-full max-w-5xl bg-[#1a1a1a] rounded-[2rem] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform transition-all animate-fade-in-up border border-[#333333]">

                    {{-- Modal Header (Sticky) --}}
                    <div
                        class="px-8 py-6 border-b border-[#333333] bg-[#1a1a1a] flex justify-between items-center shrink-0 z-10 shadow-sm">
                        <div class="flex items-center gap-3">
                            @php
                                $modalLabel = 'Edit';
                                $modalIcon = 'fa-window-restore';
                                // Logic label sama seperti sebelumnya, hanya styling yang berubah
                                foreach ($menus as $m) {
                                    if ($activeTab === $m['id']) {
                                        $modalLabel = $m['label'];
                                        $modalIcon = $m['icon'];
                                        break;
                                    }
                                }
                            @endphp
                            <div
                                class="w-10 h-10 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
                                <i class="fa-solid {{ $modalIcon }}"></i>
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $modalLabel }}</h3>
                                <p class="text-[10px] text-[#A0A0A0] uppercase tracking-wider font-bold">Edit Detail
                                    Undangan</p>
                            </div>
                        </div>
                        <button wire:click="closeModal"
                            class="w-10 h-10 rounded-full bg-[#252525] text-[#888] hover:bg-red-900/20 hover:text-red-500 hover:rotate-90 transition-all duration-300 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    {{-- Modal Content (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-[#121212]">

                        {{-- TAB: COUPLE BIO --}}
                        @if ($activeTab === 'couple_bio')
                            <div class="grid md:grid-cols-2 gap-8">
                                @foreach (['groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'] as $type => $label)
                                    <div
                                        class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-[0_4px_20px_-10px_rgba(0,0,0,0.5)]">
                                        <div class="flex items-center gap-3 mb-6 pb-3 border-b border-[#333333]">
                                            <div
                                                class="w-8 h-8 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
                                                <i class="fa-solid {{ $type == 'groom' ? 'fa-mars' : 'fa-venus' }}"></i>
                                            </div>
                                            <h4 class="font-serif font-bold text-xl text-[#E0E0E0]">{{ $label }}
                                            </h4>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <label
                                                    class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Panggilan</label>
                                                <input type="text" wire:model="couple.{{ $type }}.nickname"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                                            </div>
                                            <div>
                                                <label
                                                    class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama
                                                    Lengkap</label>
                                                <input type="text" wire:model="couple.{{ $type }}.fullname"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                                            </div>
                                            <div>
                                                <label
                                                    class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama
                                                    Ayah</label>
                                                <input type="text" wire:model="couple.{{ $type }}.father"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                                            </div>
                                            <div>
                                                <label
                                                    class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Nama
                                                    Ibu</label>
                                                <input type="text" wire:model="couple.{{ $type }}.mother"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                                            </div>
                                            <div>
                                                <label
                                                    class="text-xs text-[#A0A0A0] font-bold uppercase tracking-wide mb-1 block">Instagram
                                                    (Tanpa @)
                                                </label>
                                                <div class="relative flex items-center gap-x-2">
                                                    <span class=" text-[#D4AF37]"><i class="fa-brands fa-instagram"></i></span>
                                                    <input type="text" wire:model="couple.{{ $type }}.instagram"
                                                        class="w-full pl-10 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] font-medium transition-all">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- TAB: COUPLE QUOTE --}}
                        @if ($activeTab === 'couple_quote')
                            <div
                                class="bg-gradient-to-br from-[#1a1a1a] to-[#252525] p-8 rounded-3xl border border-[#333333] mb-8 relative overflow-hidden group shadow-lg text-white">
                                <div
                                    class="absolute top-0 right-0 -mt-6 -mr-6 text-[#D4AF37] opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110 duration-700">
                                    <i class="fa-solid fa-wand-magic-sparkles text-9xl"></i>
                                </div>
                                <div class="relative z-10">
                                    <h4 class="font-bold text-[#D4AF37] flex items-center gap-2 mb-4 text-xl">
                                        <i class="fa-solid fa-robot"></i> AI Writer Assistant
                                    </h4>
                                    <div class="flex flex-col md:flex-row gap-4 items-end">
                                        <div class="w-full md:w-1/3">
                                            <label class="text-[10px] text-[#A0A0A0] uppercase font-bold mb-1 block">Gaya
                                                Bahasa</label>
                                            <select wire:model="aiTone"
                                                class="w-full rounded-xl bg-white/5 border-white/10 text-white text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] focus:bg-[#1a1a1a]">
                                                <option value="islami">Islami</option>
                                                <option value="modern">Modern</option>
                                                <option value="formal">Formal</option>
                                            </select>
                                        </div>
                                        <div class="w-full md:w-1/3">
                                            <label class="text-[10px] text-[#A0A0A0] uppercase font-bold mb-1 block">Tipe
                                                Konten</label>
                                            <select wire:model="aiContentMode"
                                                class="w-full rounded-xl bg-white/5 border-white/10 text-white text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] focus:bg-[#1a1a1a]">
                                                <option value="quote">Quotes Bijak</option>
                                                <option value="quran">Ayat Al-Quran</option>
                                                <option value="bible">Ayat Alkitab</option>
                                            </select>
                                        </div>
                                        <div class="w-full md:w-1/3">
                                            <label
                                                class="text-[10px] text-[#A0A0A0] uppercase font-bold mb-1 block">Bahasa</label>
                                            <select wire:model="aiLanguage"
                                                class="w-full rounded-xl bg-white/5 border-white/10 text-white text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] focus:bg-[#1a1a1a]">
                                                <option value="id">Indonesia</option>
                                                <option value="en">English</option>
                                            </select>
                                        </div>

                                        @if ($aiContentMode === 'quran')
                                            <div class="w-full md:w-1/3">
                                                <label class="text-[10px] text-[#A0A0A0] uppercase font-bold mb-1 block">Pilihan
                                                    Cepat</label>
                                                <select wire:model="quranPreset"
                                                    class="w-full rounded-xl bg-white/5 border-white/10 text-white text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] focus:bg-[#1a1a1a]">
                                                    <option value="">-- Pilih Ayat --</option>
                                                    <option value="ar_rum_21">QS Ar-Rum 21</option>
                                                    <option value="an_nur_32">QS An-Nur 32</option>
                                                    <option value="an_nisa_1">QS An-Nisa 1</option>
                                                    <option value="al_furqan_74">QS Al-Furqan 74</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <label
                                            class="flex items-center gap-2 text-[#D4AF37] text-sm cursor-pointer hover:text-white transition">
                                            <input type="checkbox" wire:model.live="useAiQuote"
                                                class="rounded border-white/30 bg-white/10 text-[#D4AF37] focus:ring-0">
                                            <span>Mode Edit Manual</span>
                                        </label>
                                        <button wire:click="generateQuote" wire:loading.attr="disabled"
                                            class="px-6 py-2.5 bg-[#D4AF37] text-[#121212] rounded-xl text-sm font-bold hover:bg-[#B4912F] hover:shadow-[0_0_15px_rgba(212,175,55,0.5)] transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                            <span wire:loading.remove><i class="fa-solid fa-bolt"></i> Generate</span>
                                            <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i>
                                                Thinking...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @php $qs = $couple['quote_structured'] ?? null; @endphp

                            {{-- Preview Result --}}
                            @if ($qs && !$useAiQuote)
                                <div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm text-center relative">
                                    <div class="absolute top-4 left-4 text-[#D4AF37]/40 text-6xl font-serif">“</div>
                                    @if (($qs['type'] ?? '') === 'quran')
                                        <div class="mb-4">
                                            <p class="text-[#E0E0E0] font-serif text-2xl leading-loose" dir="rtl">
                                                {{ $qs['arabic'] ?? '' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="text-[#A0A0A0] italic">"{{ $qs['translation'] ?? '' }}"</p>
                                        </div>
                                        <div>
                                            <span
                                                class="inline-block px-4 py-1.5 rounded-full bg-[#252525] text-[#D4AF37] text-xs font-bold border border-[#333333] uppercase tracking-wider">{{ $qs['source'] ?? '' }}</span>
                                        </div>
                                    @elseif (($qs['type'] ?? '') === 'bible')
                                        <div class="mb-3">
                                            <p class="text-[#E0E0E0] font-serif text-lg">
                                                "{{ $qs['verse_text'] ?? '' }}"</p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="text-[#A0A0A0] text-sm">{{ $qs['translation'] ?? '' }}</p>
                                        </div>
                                        <div>
                                            <span
                                                class="inline-block px-4 py-1.5 rounded-full bg-[#252525] text-[#D4AF37] text-xs font-bold border border-[#333333] uppercase tracking-wider">{{ $qs['source'] ?? '' }}</span>
                                        </div>
                                    @elseif (($qs['type'] ?? '') === 'quote')
                                        <div class="mb-4">
                                            <p class="text-[#E0E0E0] font-serif text-xl italic leading-relaxed">
                                                “{{ $qs['quote_text'] ?? '' }}”
                                            </p>
                                        </div>
                                        <div>
                                            <span
                                                class="inline-block px-4 py-1.5 rounded-full bg-[#252525] text-[#D4AF37] text-xs font-bold border border-[#333333] uppercase tracking-wider">{{ $qs['source'] ?? 'Unknown' }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Manual Edit Mode --}}
                            @if ($useAiQuote)
                                <div class="bg-[#1a1a1a] p-6 rounded-3xl border-2 border-dashed border-[#D4AF37]/30">
                                    <h5 class="font-bold text-[#E0E0E0] mb-4 flex items-center gap-2"><i
                                            class="fa-solid fa-pen-to-square"></i> Editor Manual</h5>
                                    @if ($aiContentMode === 'quran')
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Arabic</label>
                                                <textarea rows="3" wire:model="couple.quote_structured.arabic"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-right font-serif text-lg text-[#E0E0E0]"></textarea>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Terjemahan</label>
                                                <textarea rows="2" wire:model="couple.quote_structured.translation"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]"></textarea>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Surat
                                                    / Ayat</label>
                                                <input type="text" wire:model="couple.quote_structured.source"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
                                            </div>
                                        </div>
                                    @elseif ($aiContentMode === 'bible')
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Ayat</label>
                                                <textarea rows="3" wire:model="couple.quote_structured.verse_text"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]"></textarea>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Terjemahan
                                                    / Konteks</label>
                                                <textarea rows="2" wire:model="couple.quote_structured.translation"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]"></textarea>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Sumber
                                                    (e.g. 1 Korintus 13:4)</label>
                                                <input type="text" wire:model="couple.quote_structured.source"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
                                            </div>
                                        </div>
                                    @else
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Isi
                                                    Quotes</label>
                                                <textarea rows="3" wire:model="couple.quote_structured.quote_text"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]"></textarea>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Penulis
                                                    / Sumber</label>
                                                <input type="text" wire:model="couple.quote_structured.source"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-4 flex justify-end">
                                        <button wire:click="composeManualQuote"
                                            class="text-xs font-bold text-[#D4AF37] hover:text-[#B4912F] underline">Update
                                            Preview</button>
                                    </div>
                                </div>
                            @endif
                        @endif

                        {{-- TAB: EVENTS --}}
                        @if ($activeTab === 'events')
                            <div class="flex justify-between items-center mb-6">
                                <h4 class="font-bold text-[#E0E0E0]">Daftar Acara</h4>
                                <button wire:click="addEvent"
                                    class="bg-[#D4AF37] text-[#121212] text-xs px-5 py-2.5 rounded-xl font-bold hover:bg-[#B4912F] hover:shadow-lg transition flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Tambah Acara
                                </button>
                            </div>

                            <div class="space-y-6">
                                @foreach ($events as $index => $event)
                                    <div
                                        class="bg-[#1a1a1a] p-5 rounded-3xl border border-[#333333] relative shadow-sm hover:shadow-md transition-shadow group">
                                        <div class="absolute top-0 right-0 p-4">
                                            <button wire:click="removeEvent({{ $index }})"
                                                class="w-8 h-8 rounded-full bg-[#252525] text-[#888] hover:bg-red-900/20 hover:text-red-500 transition flex items-center justify-center">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>

                                        <div class="flex items-center gap-3 mb-4">
                                            <span
                                                class="bg-[#2d2d2d] text-[#D4AF37] w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">{{ $loop->iteration }}</span>
                                            <span
                                                class="font-bold text-[#E0E0E0] text-lg">{{ $event['title'] ?: 'Acara Baru' }}</span>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-5">
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Nama
                                                    Acara</label>
                                                <input type="text" wire:model="events.{{ $index }}.title"
                                                    placeholder="Contoh: Akad Nikah"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Waktu
                                                    & Tanggal</label>
                                                <input type="datetime-local" wire:model="events.{{ $index }}.date"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Nama
                                                    Lokasi (Gedung/Hotel/Rumah)</label>
                                                <input type="text" wire:model="events.{{ $index }}.location"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Alamat
                                                    Lengkap</label>
                                                <textarea wire:model="events.{{ $index }}.address" rows="5"
                                                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all"></textarea>
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Link
                                                    Google Maps</label>
                                                <div
                                                    class="relative flex items-center gap-x-2 bg-[#252525] rounded border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] transition-all">
                                                    <span class="text-[#D4AF37]"><i class="fa-solid fa-map-location-dot"></i></span>
                                                    <input type="text" wire:model="events.{{ $index }}.map_link"
                                                        class="w-fullrounded-xl border-none bg-transparent text-[#E0E0E0]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- TAB: GALLERY --}}
                        @if ($activeTab === 'gallery')
                            <div class="space-y-8">
                                {{-- Main Photos --}}
                                <div>
                                    <h4 class="font-bold text-[#E0E0E0] mb-4">Foto Utama</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        @foreach (['cover' => 'Sampul Undangan', 'groom' => 'Foto Pria', 'bride' => 'Foto Wanita'] as $key => $label)
                                            <div x-data="{ isUploading: false, progress: 0 }"
                                                x-on:livewire-upload-start="isUploading = true"
                                                x-on:livewire-upload-finish="isUploading = false"
                                                x-on:livewire-upload-error="isUploading = false"
                                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                class="group relative aspect-[3/4] round overflow-hidden bg-[#1a1a1a] border-2 border-dashed border-[#333333] hover:border-[#D4AF37] transition-all cursor-pointer shadow-sm hover:shadow-md">
                                                @php
                                                    $newVar = 'new' . ucfirst($key);
                                                    $hasExisting = !empty($gallery[$key]);
                                                @endphp

                                                {{-- Image Preview --}}
                                                @if ($$newVar)
                                                    <img src="{{ $$newVar->temporaryUrl() }}" class="w-full h-full object-cover">
                                                @elseif ($hasExisting)
                                                    <img src="{{ asset($gallery[$key]) }}" class="w-full h-full object-cover">
                                                    {{-- Delete Button --}}
                                                    <button wire:click.stop="removeSpecific('{{ $key }}')"
                                                        wire:confirm="Yakin ingin menghapus foto ini?"
                                                        class="absolute top-2 right-2 w-8 h-8 rounded-full bg-black/50 text-red-500 shadow-md hover:bg-red-500 hover:text-white transition flex items-center justify-center z-20">
                                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                                    </button>
                                                @else
                                                    <div
                                                        class="absolute inset-0 flex flex-col items-center justify-center text-[#888] group-hover:text-[#D4AF37] transition">
                                                        <div
                                                            class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center mb-2 group-hover:bg-[#D4AF37]/10">
                                                            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                                        </div>
                                                        <span class="text-xs font-bold uppercase tracking-wider">Upload</span>
                                                    </div>
                                                @endif

                                                {{-- Label Overlay --}}
                                                <div
                                                    class="absolute bottom-0 left-0 right-0 bg-[#1a1a1a]/90 backdrop-blur-sm py-2 text-center border-t border-[#333333]">
                                                    <span
                                                        class="text-[10px] font-bold text-[#E0E0E0] uppercase tracking-wide">{{ $label }}</span>
                                                </div>

                                                {{-- File Input --}}
                                                <input type="file" wire:model="{{ $newVar }}"
                                                    class="absolute inset-0 opacity-0 cursor-pointer z-10">

                                                {{-- Progress Bar Overlay --}}
                                                <div x-show="isUploading"
                                                    class="absolute inset-0 bg-[#1a1a1a]/90 flex flex-col items-center justify-center z-30 transition-opacity">
                                                    <div class="relative w-16 h-16">
                                                        <svg class="w-full h-full transform -rotate-90">
                                                            <circle cx="32" cy="32" r="28" stroke="#333" stroke-width="4"
                                                                fill="none" />
                                                            <circle cx="32" cy="32" r="28" stroke="#D4AF37" stroke-width="4"
                                                                fill="none" stroke-dasharray="175.9"
                                                                :stroke-dashoffset="175.9 - (progress / 100 * 175.9)"
                                                                class="transition-all duration-300 ease-out" />
                                                        </svg>
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <span class="text-xs font-bold text-[#E0E0E0]"
                                                                x-text="progress + '%'"></span>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-[10px] font-bold text-[#A0A0A0] mt-2 uppercase tracking-wide">Uploading...</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr class="border-[#333333] border-dashed">

                                {{-- Moments Gallery --}}
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-bold text-[#E0E0E0]">Galeri Momen</h4>
                                        <span
                                            class="text-xs font-bold bg-[#252525] text-[#D4AF37] px-3 py-1 rounded-full">{{ count($gallery['moments'] ?? []) }}
                                            Foto</span>
                                    </div>

                                    {{-- Upload Area --}}
                                    <div x-data="{ isUploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                                        class="mb-6 relative group">

                                        {{-- Dropzone UI --}}
                                        <div
                                            class="w-full pt-6 rounded-3xl border-2 border-dashed border-[#D4AF37]/40 bg-[#1a1a1a] hover:bg-[#252525] transition flex flex-col items-center justify-center cursor-pointer gap-2">

                                            <div
                                                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] mb-1 group-hover:scale-110 transition-transform">
                                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                            </div>

                                            <div class="text-center">
                                                <h5 class="font-bold text-[#E0E0E0] text-sm">Upload Foto Galeri</h5>
                                                <p class="text-[10px] text-[#A0A0A0] mt-1">Bisa satu per satu atau banyak
                                                    sekaligus</p>
                                            </div>

                                            <button type="button"
                                                class="mt-2 px-4 py-2 bg-[#D4AF37] text-[#121212] text-xs font-bold rounded-xl shadow-sm hover:shadow-md transition">
                                                <i class="fa-solid fa-plus"></i> Tambah Foto
                                            </button>

                                            <p
                                                class="text-[10px] text-green-500 font-bold mt-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <i class="fa-solid fa-bolt"></i> Tersimpan Otomatis
                                            </p>
                                        </div>

                                        {{-- Hidden Input --}}
                                        <input type="file" wire:model="newMoments" multiple
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            title="Klik untuk memilih foto">

                                        {{-- Progress Bar Overlay (Upload Phase) --}}
                                        <div x-show="isUploading"
                                            class="absolute inset-0 bg-[#1a1a1a]/95 rounded-3xl flex flex-col items-center justify-center z-30 transition-opacity">
                                            <div class="relative w-16 h-16 mb-2">
                                                <svg class="w-full h-full transform -rotate-90">
                                                    <circle cx="32" cy="32" r="28" stroke="#333" stroke-width="4" fill="none" />
                                                    <circle cx="32" cy="32" r="28" stroke="#D4AF37" stroke-width="4" fill="none"
                                                        stroke-dasharray="175.9"
                                                        :stroke-dashoffset="175.9 - (progress / 100 * 175.9)"
                                                        class="transition-all duration-300 ease-out" />
                                                </svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span class="text-xs font-bold text-[#E0E0E0]"
                                                        x-text="progress + '%'"></span>
                                                </div>
                                            </div>
                                            <span
                                                class="text-[10px] font-bold text-[#A0A0A0] uppercase tracking-wide animate-pulse">Mengupload...</span>
                                        </div>

                                        {{-- Processing Overlay (Server Phase) --}}
                                        <div wire:loading.flex wire:target="newMoments"
                                            class="absolute inset-0 bg-[#1a1a1a]/95 rounded-3xl flex-col items-center justify-center z-30 transition-opacity hidden">
                                            <div
                                                class="w-12 h-12 rounded-full border-4 border-[#333] border-t-[#D4AF37] animate-spin mb-3">
                                            </div>
                                            <h5 class="font-bold text-[#E0E0E0] text-sm">Menyimpan...</h5>
                                            <p class="text-[10px] text-[#A0A0A0]">Mohon tunggu sebentar</p>
                                        </div>
                                    </div>

                                    {{-- Preview New Uploads --}}
                                    @if ($newMoments)
                                        <div class="mb-6 p-4 bg-[#1a1a1a] rounded-2xl border border-[#333333]">
                                            <p class="text-xs font-bold text-[#D4AF37] mb-2">Siap diupload:</p>
                                            <div class="flex gap-3 overflow-x-auto pb-2 custom-scrollbar">
                                                @foreach ($newMoments as $img)
                                                    <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden relative shadow-sm">
                                                        <img src="{{ $img->temporaryUrl() }}" class="w-full h-full object-cover">
                                                        <div class="absolute inset-0 bg-black/10"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <h5 class="font-serif font-bold text-[#E0E0E0]">Urutan Galeri</h5>
                                            <span
                                                class="text-[10px] font-bold bg-[#252525] text-[#D4AF37] px-2 py-0.5 rounded-full border border-[#333333]">{{ count($gallery['moments'] ?? []) }}
                                                foto</span>
                                        </div>
                                        <div class="space-y-3">
                                            @foreach ($gallery['moments'] as $index => $path)
                                                <div
                                                    class="flex items-center gap-3 bg-[#1a1a1a] rounded-xl border border-[#333333] p-2 shadow-sm">
                                                    <div
                                                        class="w-24 aspect-[3/4] rounded-lg overflow-hidden border border-[#333333] bg-[#252525] shrink-0">
                                                        <img src="{{ asset($path) }}" loading="lazy"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <button wire:click="moveMomentUp({{ $index }})"
                                                            class="md:w-8 md:h-8 w-10 h-10 rounded-full bg-[#252525] text-[#E0E0E0] hover:bg-[#2d2d2d] shadow-sm flex items-center justify-center border border-[#333333] {{ $index === 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fa-solid fa-chevron-up text-sm md:text-xs"></i>
                                                        </button>
                                                        <button wire:click="moveMomentDown({{ $index }})"
                                                            class="md:w-8 md:h-8 w-10 h-10 rounded-full bg-[#252525] text-[#E0E0E0] hover:bg-[#2d2d2d] shadow-sm flex items-center justify-center border border-[#333333] {{ $index === count($gallery['moments']) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                            <i class="fa-solid fa-chevron-down text-sm md:text-xs"></i>
                                                        </button>
                                                        <button wire:click="removeMoment({{ $index }})"
                                                            wire:confirm="Hapus foto ini dari galeri?"
                                                            class="md:w-8 md:h-8 w-10 h-10 rounded-full bg-[#252525] text-red-500 hover:bg-red-900/20 shadow-sm flex items-center justify-center border border-red-900/20">
                                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- TAB: THEME --}}
                        @if ($activeTab === 'theme')

                            {{-- Pricing Info --}}
                            <div
                                class="bg-gradient-to-r from-[#1a1a1a] to-[#252525] rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-xl">
                                <div
                                    class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-3xl opacity-20 -mr-16 -mt-16">
                                </div>
                                <div class="flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span
                                                class="bg-[#D4AF37] text-[#121212] text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Active
                                                Plan</span>
                                        </div>
                                        <h4 class="font-serif font-bold text-3xl mb-2">{{ $currentTierName }}</h4>
                                        <div class="flex flex-wrap gap-2 text-xs text-[#E0E0E0]">
                                            @foreach ($currentTierFeatures as $feat)
                                                <span class="flex items-center gap-1 bg-white/10 px-2 py-1 rounded"><i
                                                        class="fa-solid fa-check text-[#D4AF37]"></i>
                                                    {{ ucwords(str_replace('_', ' ', $feat)) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-[#A0A0A0] uppercase tracking-wide mb-1">Total Harga
                                            Template</p>
                                        <p class="font-serif text-4xl font-bold">Rp
                                            {{ number_format($currentTemplatePrice, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Template Grid --}}
                            <div class="mb-8">
                                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 px-2 mb-4">
                                    <label class="font-bold text-[#E0E0E0] text-lg">Pilih Desain</label>
                                    <div class="w-full sm:w-80">
                                        <div
                                            class="flex items-center gap-3 rounded-xl bg-[#1a1a1a] border border-[#333333] px-3 py-2 focus-within:border-[#D4AF37] focus-within:ring-1 focus-within:ring-[#D4AF37]">
                                            <i class="fa-solid fa-magnifying-glass text-[#D4AF37]"></i>
                                            <input type="text" wire:model.live="search" placeholder="Cari desain..."
                                                class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-sm text-[#E0E0E0]">
                                            <span wire:loading wire:target="search" class="text-[#D4AF37]">
                                                <i class="fa-solid fa-circle-notch fa-spin"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                    @foreach ($availableTemplates as $tpl)
                                        <div class="group cursor-pointer rounded-xl overflow-hidden" wire:click="selectTemplate('{{ $tpl->slug }}')">
                                            <div
                                                class="aspect-[9/16] overflow-hidden relative border-2 transition-all
                                                                                                                                                                                                                                    {{ $theme_template == $tpl->slug ? 'border-[#D4AF37] ring-2 ring-[#D4AF37]/30 shadow-xl' : 'border-[#333333] hover:border-[#D4AF37]/50 hover:shadow-lg' }}">
                                                @if ($tpl->thumbnail)
                                                    <img src="{{ asset('storage/' . $tpl->thumbnail) }}" loading="lazy"
                                                        class="w-full h-full object-cover group-hover:scale-[1.02] transition">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-[#252525] flex flex-col items-center justify-center text-[#888]">
                                                        <i class="fa-solid fa-image text-3xl mb-2"></i>
                                                        <span class="text-xs font-bold">No Preview</span>
                                                    </div>
                                                @endif
                                                <div class="absolute top-2 left-2">
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full shadow-sm
                                                                                                                                                                                                                                            {{ $tpl->tier == 'exclusive' ? 'bg-[#2D2418] text-[#D4AF37]' : ($tpl->tier == 'premium' ? 'bg-[#D4AF37] text-[#121212]' : 'bg-[#1a1a1a] text-[#E0E0E0]') }}">
                                                        {{ $tpl->tier }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="absolute bottom-0 left-0 right-0 bg-[#1a1a1a]/95 backdrop-blur-sm p-2 text-center border-t border-[#333333]">
                                                    <p class="font-bold text-[#E0E0E0] text-xs">Rp
                                                        {{ number_format($tpl->price, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                @if ($theme_template == $tpl->slug)
                                                    <div class="absolute inset-0 bg-[#D4AF37]/25 flex items-center justify-center">
                                                        <div
                                                            class="w-10 h-10 rounded-full bg-[#D4AF37] text-[#121212] flex items-center justify-center shadow-md">
                                                            <i class="fa-solid fa-check"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-center mt-2">
                                                <p class="font-serif font-bold text-[#E0E0E0] text-sm">
                                                    {{ $tpl->name }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4" x-data
                                    x-init="const observer = new IntersectionObserver((entries) => {
                                                                                                                                                            entries.forEach(entry => {
                                                                                                                                                                if (entry.isIntersecting) { $wire.loadMoreTemplates() }
                                                                                                                                                            });
                                                                                                                                                        }, { root: null, threshold: 1 });
                                                                                                                                                        observer.observe($refs.sentinel);">
                                    <div x-ref="sentinel" class="h-6"></div>
                                    @unless ($hasMoreTemplates)
                                        <p class="text-center text-[10px] text-[#A0A0A0] mt-2">Semua desain telah dimuat
                                        </p>
                                    @endunless
                                </div>
                            </div>

                            <hr class="border-[#333333] border-dashed mb-8">

                            {{-- Color Picker --}}
                            <div class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-sm flex items-center gap-6">
                                <div class="relative w-20 h-20 rounded-2xl overflow-hidden shadow-inner ring-1 ring-[#333333]">
                                    <input type="color" wire:model="theme.primary_color"
                                        class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] cursor-pointer p-0 border-0">
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase tracking-wider mb-2">Warna
                                        Aksen Undangan</label>
                                    <input type="text" wire:model="theme.primary_color"
                                        class="w-full rounded-xl bg-[#252525] border border-[#333333] font-mono text-[#E0E0E0] uppercase focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                                    <p class="text-[10px] text-[#888] mt-1">Digunakan untuk tombol, link, dan
                                        dekorasi.</p>
                                </div>
                            </div>
                        @endif

                        {{-- TAB: MUSIC --}}
                        @if ($activeTab === 'music')
                            <div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm text-center">
                                <div
                                    class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center text-[#D4AF37] mx-auto mb-4 text-2xl">
                                    <i class="fa-brands fa-youtube"></i>
                                </div>
                                <h4 class="font-bold text-[#E0E0E0] text-lg mb-2">Latar Musik (YouTube)</h4>
                                <p class="text-sm text-[#A0A0A0] mb-6 max-w-md mx-auto">Tempelkan link video YouTube
                                    lagu yang Anda inginkan. Kami akan memutarnya secara otomatis di undangan.</p>

                                <div class="relative max-w-xl mx-auto">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-red-500">
                                        <i class="fa-solid fa-play"></i>
                                    </span>
                                    <input type="text" wire:model="theme.music_url"
                                        placeholder="https://www.youtube.com/watch?v=..."
                                        class="w-full pl-10 py-3 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0]">
                                </div>

                                @if (!empty($theme['music_url']))
                                    <div
                                        class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-green-500 bg-green-900/20 px-4 py-2 rounded-full border border-green-900/30 animate-fade-in-up">
                                        <i class="fa-solid fa-circle-check"></i> Link valid
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- TAB: GIFTS --}}
                        @if ($activeTab === 'gifts')
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h4 class="font-bold text-[#E0E0E0]">Rekening & Dompet Digital</h4>
                                    <p class="text-xs text-[#A0A0A0]">Tamu dapat memberikan kado secara cashless.</p>
                                </div>
                                <button wire:click="addGift"
                                    class="bg-[#D4AF37] text-[#121212] text-xs px-5 py-2.5 rounded-xl font-bold hover:bg-[#B4912F] hover:shadow-lg transition flex items-center gap-2">
                                    Tambah
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div
                                    class="md:col-span-2 bg-gradient-to-br from-[#1a1a1a] to-[#252525] p-6 rounded-3xl border border-[#333333] shadow-sm">
                                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Alamat
                                        Pengiriman Kado (Opsional)</label>
                                    <textarea rows="2" wire:model="theme.gift_address"
                                        class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                                        placeholder="Contoh: Jl. Mawar No. 12, RT 03/ RW 04, Kel. ..."></textarea>
                                    <p class="text-[10px] text-[#888] mt-1">Alamat ini ditampilkan pada undangan
                                        agar tamu dapat mengirim kado fisik.</p>
                                </div>
                                @forelse($gifts as $index => $gift)
                                    <div
                                        class="bg-gradient-to-br from-[#1a1a1a] to-[#252525] p-6 rounded-3xl border border-[#333333] relative shadow-sm hover:shadow-md transition group">
                                        {{-- Delete Button --}}
                                        <button wire:click="removeGift({{ $index }})"
                                            class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#252525] text-[#888] hover:bg-red-900/20 hover:text-red-500 shadow-sm flex items-center justify-center transition">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                        <div class="flex items-center gap-3 mb-6">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-[#121212] flex items-center justify-center text-[#D4AF37]">
                                                <i class="fa-solid fa-credit-card"></i>
                                            </div>
                                            <span class="font-bold text-[#E0E0E0]">Rekening
                                                {{ $loop->iteration }}</span>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-[10px] font-bold text-[#A0A0A0] uppercase mb-1 block">Nama
                                                    Bank / E-Wallet</label>
                                                <select wire:model="gifts.{{ $index }}.bank_name"
                                                    class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 font-bold text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                                                    <option value="">Pilih...</option>
                                                    @foreach (['BCA', 'BRI', 'Mandiri', 'BNI', 'Dana', 'Gopay', 'OVO', 'ShopeePay', 'Lainnya'] as $bank)
                                                        <option value="{{ $bank }}">{{ $bank }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-[#A0A0A0] uppercase mb-1 block">Nomor
                                                    Rekening</label>
                                                <input type="number" wire:model="gifts.{{ $index }}.account_number"
                                                    class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 font-mono text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                                                    placeholder="0000...">
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-[#A0A0A0] uppercase mb-1 block">Atas
                                                    Nama</label>
                                                <input type="text" wire:model="gifts.{{ $index }}.account_name"
                                                    class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                                                    placeholder="Nama Pemilik">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="col-span-full py-16 text-center rounded-3xl border-2 border-dashed border-[#333333] bg-[#1a1a1a]/50">
                                        <div
                                            class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center text-[#888] mx-auto mb-4">
                                            <i class="fa-solid fa-gift text-2xl"></i>
                                        </div>
                                        <h5 class="font-bold text-[#E0E0E0]">Belum ada rekening</h5>
                                        <p class="text-sm text-[#A0A0A0]">Tambahkan metode pembayaran untuk menerima
                                            kado.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    {{-- Modal Footer (Sticky) --}}
                    <div class="px-8 py-5 border-t border-[#333333] bg-[#1a1a1a] flex justify-end gap-3 z-10">
                        <button wire:click="closeModal"
                            class="px-6 py-3 bg-[#252525] border border-[#333333] text-[#A0A0A0] rounded-xl font-bold hover:bg-[#2d2d2d] transition text-sm">
                            Batal
                        </button>
                        <button wire:click="save"
                            class="px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-xl hover:bg-[#B4912F] shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all font-bold text-sm uppercase tracking-wide flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-circle-notch fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>