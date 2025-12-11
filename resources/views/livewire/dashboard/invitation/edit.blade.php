<div class="py-2 animate-fade-in-up">

    {{-- ================= HEADER SECTION ================= --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Editor</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Studio Undangan</h2>
            <p class="text-[#7C6339] text-sm mt-1">Project: <span
                    class="font-semibold italic">{{ $invitation->title }}</span></p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3">
            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-5 py-2.5 bg-white border border-[#E6D9B8] text-[#7C6339] rounded-xl hover:bg-[#F9F7F2] hover:text-[#B89760] transition font-bold text-xs uppercase tracking-wide flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-eye"></i> Preview
            </a>
            <button wire:click="save"
                class="px-6 py-2.5 bg-[#B89760] text-white rounded-xl hover:bg-[#9A7D4C] transition font-bold text-xs uppercase tracking-wide flex items-center shadow-lg shadow-[#B89760]/30 transform hover:-translate-y-0.5">
                <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Simpan Perubahan
                </span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...
                </span>
            </button>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session('message'))
        <div
            class="mb-6 bg-[#F2ECDC] border border-[#B89760] text-[#7C6339] px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm relative overflow-hidden">
            <div class="w-1 absolute left-0 top-0 bottom-0 bg-[#B89760]"></div>
            <i class="fa-solid fa-circle-check text-xl text-[#B89760]"></i>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    {{-- ================= MAIN GRID ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- 1. SIDEBAR NAVIGATION --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.3)] border border-[#E6D9B8]/60 overflow-hidden sticky top-24">
                <nav class="flex flex-col p-2 space-y-1">
                    @php
                        $tabs = [
                            'couple' => ['icon' => 'fa-user-group', 'label' => 'Mempelai'],
                            'events' => ['icon' => 'fa-calendar-days', 'label' => 'Rangkaian Acara'],
                            'gallery' => ['icon' => 'fa-images', 'label' => 'Galeri Foto'],
                            'gifts' => ['icon' => 'fa-gift', 'label' => 'Kado Digital'],
                            'theme' => ['icon' => 'fa-palette', 'label' => 'Tema & Musik'],
                        ];
                    @endphp

                    @foreach ($tabs as $key => $tab)
                        <button wire:click="$set('activeTab', '{{ $key }}')"
                            class="px-4 py-3 text-left rounded-xl flex items-center gap-3 transition-all duration-300
                            {{ $activeTab === $key
                                ? 'bg-[#F9F7F2] text-[#B89760] font-bold shadow-sm border border-[#E6D9B8]'
                                : 'text-[#7C6339] hover:bg-[#F9F7F2] hover:text-[#9A7D4C] border border-transparent' }}">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center {{ $activeTab === $key ? 'bg-[#B89760] text-white' : 'bg-[#F2ECDC] text-[#C6AC80]' }}">
                                <i class="fa-solid {{ $tab['icon'] }} text-xs"></i>
                            </div>
                            <span class="text-sm">{{ $tab['label'] }}</span>
                        </button>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- 2. CONTENT AREA --}}
        <div class="lg:col-span-3">
            <div
                class="bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.1)] border border-[#E6D9B8]/60 p-6 md:p-8 min-h-[600px] relative">

                {{-- Decorative Background --}}
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-[#F9F7F2] rounded-bl-[100px] -z-0 pointer-events-none opacity-50">
                </div>

                <div class="relative z-10">

                    {{-- ########### TAB: COUPLE ########### --}}
                    @if ($activeTab === 'couple')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Data Pengantin</h3>

                        {{-- AI Assistant --}}
                        <div
                            class="bg-gradient-to-br from-[#FFFBF2] to-[#F9F7F2] p-6 rounded-2xl border border-[#E6D9B8] mb-8 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 -mt-4 -mr-4 text-[#E6D9B8] opacity-30 group-hover:opacity-50 transition transform group-hover:scale-110">
                                <i class="fa-solid fa-wand-magic-sparkles text-8xl"></i>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-[#5E4926] flex items-center gap-2 mb-2 text-lg">
                                    <i class="fa-solid fa-robot text-[#B89760]"></i> AI Writer Assistant
                                </h4>
                                <p class="text-xs text-[#9A7D4C] mb-5 max-w-lg leading-relaxed">
                                    Biarkan AI membuatkan kata pengantar yang indah dan menyentuh untuk undanganmu.
                                </p>
                                <div class="flex flex-col md:flex-row gap-4 items-end">
                                    <div class="w-full md:w-1/3">
                                        <label
                                            class="text-[10px] font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 block">Tone</label>
                                        <select wire:model="aiTone"
                                            class="w-full rounded-lg bg-white border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                            <option value="islami">Islami & Penuh Doa</option>
                                            <option value="modern">Modern & Casual</option>
                                            <option value="formal">Formal & Puitis</option>
                                        </select>
                                    </div>
                                    <button wire:click="generateQuote" wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-[#5E4926] text-white rounded-lg text-sm font-bold hover:bg-[#403013] shadow-md flex items-center gap-2 disabled:opacity-50 disabled:cursor-wait transition">
                                        <span wire:loading.remove wire:target="generateQuote"><i
                                                class="fa-solid fa-bolt text-[#F2ECDC] mr-1"></i> Generate</span>
                                        <span wire:loading wire:target="generateQuote"><i
                                                class="fa-solid fa-circle-notch fa-spin mr-1"></i> Berpikir...</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Quote Input --}}
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">Kata
                                Pengantar</label>
                            <textarea wire:model="couple.quote" rows="4"
                                class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] shadow-sm transition placeholder-[#C6AC80]"
                                placeholder="Hasil generate AI akan muncul di sini..."></textarea>
                        </div>

                        {{-- Groom & Bride Form --}}
                        <div class="grid md:grid-cols-2 gap-8">
                            @foreach (['groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'] as $type => $label)
                                <div class="space-y-4">
                                    <h4
                                        class="font-serif font-bold text-xl {{ $type == 'groom' ? 'text-[#5E4926]' : 'text-[#B89760]' }} border-b border-[#E6D9B8] pb-2">
                                        {{ $label }}</h4>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Panggilan</label><input
                                            type="text" wire:model="couple.{{ $type }}.nickname"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Lengkap</label><input
                                            type="text" wire:model="couple.{{ $type }}.fullname"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ayah</label><input
                                            type="text" wire:model="couple.{{ $type }}.father"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Nama Ibu</label><input
                                            type="text" wire:model="couple.{{ $type }}.mother"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    <div><label class="text-xs text-[#9A7D4C] font-bold">Username
                                            Instagram</label><input type="text"
                                            wire:model="couple.{{ $type }}.instagram" placeholder="@username"
                                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- ########### TAB: EVENTS ########### --}}
                    @if ($activeTab === 'events')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Rangkaian Acara</h3>
                            <button wire:click="addEvent"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Tambah Sesi
                            </button>
                        </div>

                        <div class="space-y-6">
                            @foreach ($events as $index => $event)
                                <div
                                    class="bg-[#F9F7F2]/50 p-6 rounded-2xl border border-[#E6D9B8] relative group transition hover:bg-white hover:shadow-sm">
                                    <button wire:click="removeEvent({{ $index }})"
                                        class="absolute top-4 right-4 text-[#C6AC80] hover:text-red-500 transition w-8 h-8 rounded-full bg-white border border-[#E6D9B8] flex items-center justify-center shadow-sm"
                                        title="Hapus Sesi">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>

                                    <div class="grid md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Judul
                                                Acara</label>
                                            <input type="text" wire:model="events.{{ $index }}.title"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div>
                                            <label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Waktu</label>
                                            <input type="datetime-local" wire:model="events.{{ $index }}.date"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label
                                                class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Lokasi</label>
                                            <input type="text" wire:model="events.{{ $index }}.location"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Alamat
                                                Lengkap</label>
                                            <textarea wire:model="events.{{ $index }}.address" rows="2"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]"></textarea>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-xs font-bold text-[#9A7D4C] uppercase mb-1 block">Google
                                                Maps Link</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#C6AC80]"><i
                                                        class="fa-solid fa-map-location-dot"></i></span>
                                                <input type="text"
                                                    wire:model="events.{{ $index }}.map_link"
                                                    class="w-full pl-9 rounded-lg bg-white border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- ########### TAB: GALLERY ########### --}}
                    @if ($activeTab === 'gallery')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Galeri Foto</h3>

                        <div class="space-y-8">
                            {{-- Specific Uploads (Cover, Groom, Bride) --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach (['cover' => 'Foto Sampul', 'groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'] as $key => $label)
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-2">{{ $label }}</label>
                                        {{-- Image Container Ratio 9:16 for Cover, Square for Profile --}}
                                        <div
                                            class="relative group {{ $key == 'cover' ? 'aspect-[9/16]' : 'aspect-square' }} bg-[#F9F7F2] border-2 border-dashed border-[#E6D9B8] rounded-xl overflow-hidden hover:border-[#B89760] transition">

                                            {{-- Logic: Show New Temp -> Show Existing -> Show Placeholder --}}
                                            @php
                                                $newVar = 'new' . ucfirst($key);
                                                $hasExisting = !empty($gallery[$key]);
                                            @endphp

                                            @if ($$newVar)
                                                <img src="{{ $$newVar->temporaryUrl() }}"
                                                    class="w-full h-full object-cover">
                                            @elseif ($hasExisting)
                                                <img src="{{ asset($gallery[$key]) }}"
                                                    class="w-full h-full object-cover">
                                                <button wire:click="removeSpecific('{{ $key }}')"
                                                    class="absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-md z-20"><i
                                                        class="fa-solid fa-times text-xs"></i></button>
                                            @else
                                                <div
                                                    class="absolute inset-0 flex flex-col items-center justify-center text-[#C6AC80]">
                                                    <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i>
                                                    <span class="text-[10px]">Upload</span>
                                                </div>
                                            @endif

                                            {{-- Input Overlay --}}
                                            <input type="file" wire:model="{{ $newVar }}"
                                                class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                            {{-- Loading --}}
                                            <div wire:loading wire:target="{{ $newVar }}"
                                                class="absolute inset-0 bg-white/80 flex items-center justify-center z-30">
                                                <i class="fa-solid fa-circle-notch fa-spin text-[#B89760]"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="border-[#F2ECDC] border-dashed">

                            {{-- Moments (Bulk Upload) --}}
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <label
                                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider">Galeri
                                        Momen</label>
                                    <span class="text-[10px] text-[#9A7D4C]">Total:
                                        {{ count($gallery['moments'] ?? []) }} Foto</span>
                                </div>

                                <div
                                    class="mb-6 p-6 border-2 border-dashed border-[#E6D9B8] rounded-2xl bg-[#F9F7F2]/50 text-center hover:bg-[#F9F7F2] transition relative">
                                    <input type="file" wire:model="newMoments" multiple
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                    <div class="pointer-events-none">
                                        <i class="fa-solid fa-images text-2xl text-[#E6D9B8] mb-2"></i>
                                        <p class="text-sm font-bold text-[#B89760]">Klik untuk upload foto momen</p>
                                        <p class="text-xs text-[#9A7D4C]">Bisa pilih banyak sekaligus</p>
                                    </div>
                                </div>

                                {{-- Previews --}}
                                @if ($newMoments)
                                    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
                                        @foreach ($newMoments as $img)
                                            <img src="{{ $img->temporaryUrl() }}"
                                                class="h-16 w-16 object-cover rounded-lg border border-[#E6D9B8]">
                                        @endforeach
                                    </div>
                                @endif

                                <div class="grid grid-cols-3 md:grid-cols-5 gap-4">
                                    @foreach ($gallery['moments'] as $index => $path)
                                        <div class="relative group rounded-lg overflow-hidden shadow-sm aspect-square">
                                            <img src="{{ asset($path) }}" class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                <button wire:click="removeMoment({{ $index }})"
                                                    class="text-white hover:text-red-400 transition">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ########### TAB: THEME (SLIDER) ########### --}}
                    @if ($activeTab === 'theme')
                        <h3 class="font-serif font-bold text-2xl text-[#5E4926] mb-6 pb-2 border-b border-[#F2ECDC]">
                            Tampilan & Musik</h3>

                        <div class="space-y-10">
                            {{-- Template Slider --}}
                            <div>
                                <div class="flex justify-between items-end mb-4 px-1">
                                    <label
                                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider">Pilih
                                        Desain</label>
                                    <span class="text-[10px] text-[#9A7D4C] italic">Geser untuk melihat opsi lainnya
                                        &rarr;</span>
                                </div>

                                <div class="relative group/slider">
                                    {{-- Fade Overlay --}}
                                    <div
                                        class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none">
                                    </div>
                                    <div
                                        class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none">
                                    </div>

                                    {{-- Scroll Container --}}
                                    <div
                                        class="flex gap-5 overflow-x-auto pb-6 pt-2 px-1 snap-x snap-mandatory scroll-smooth hide-scrollbar">
                                        @foreach ($availableTemplates as $tpl)
                                            <label class="cursor-pointer relative flex-shrink-0 snap-center group">
                                                <input type="radio" wire:model.live="theme_template"
                                                    value="{{ $tpl->slug }}" class="peer sr-only">

                                                <div
                                                    class="w-48 transition-all duration-300 transform {{ $theme_template == $tpl->slug ? 'scale-105' : 'scale-100 hover:scale-105 opacity-80 hover:opacity-100' }}">
                                                    {{-- Card Image --}}
                                                    <div
                                                        class="aspect-[9/16] rounded-2xl overflow-hidden shadow-md relative border-4 transition-all duration-300
                                                        {{ $theme_template == $tpl->slug ? 'border-[#B89760] shadow-lg ring-4 ring-[#B89760]/20' : 'border-transparent shadow-sm' }}">

                                                        @if ($tpl->thumbnail)
                                                            <img src="{{ asset('storage/' . $tpl->thumbnail) }}"
                                                                class="w-full h-full object-cover"
                                                                alt="{{ $tpl->name }}">
                                                        @else
                                                            <div
                                                                class="w-full h-full bg-[#F9F7F2] flex flex-col items-center justify-center text-[#C6AC80] gap-2">
                                                                <i class="fa-regular fa-image text-3xl"></i>
                                                                <span class="text-[10px]">No Preview</span>
                                                            </div>
                                                        @endif

                                                        {{-- Premium Badge --}}
                                                        @if ($tpl->type == 'premium')
                                                            <div
                                                                class="absolute top-2 left-2 bg-[#2D2418] text-[#B89760] text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm z-20">
                                                                Premium</div>
                                                        @endif

                                                        {{-- Checked Overlay --}}
                                                        <div
                                                            class="absolute inset-0 bg-[#B89760]/20 z-10 transition-opacity duration-300 {{ $theme_template == $tpl->slug ? 'opacity-100' : 'opacity-0' }}">
                                                            <div
                                                                class="absolute bottom-3 right-3 bg-[#B89760] text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                                                <i class="fa-solid fa-check"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <p
                                                            class="font-serif font-bold text-[#5E4926] text-sm {{ $theme_template == $tpl->slug ? 'text-[#B89760]' : '' }}">
                                                            {{ $tpl->name }}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <hr class="border-[#F2ECDC] border-dashed">

                            {{-- Config Grid --}}
                            <div class="grid md:grid-cols-2 gap-8">
                                {{-- Warna --}}
                                <div class="bg-[#F9F7F2]/50 p-5 rounded-2xl border border-[#E6D9B8]/50">
                                    <label
                                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-3">Warna
                                        Aksen</label>
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="relative w-16 h-16 rounded-2xl overflow-hidden border-2 border-white shadow-md ring-1 ring-[#E6D9B8] cursor-pointer">
                                            <input type="color" wire:model="theme.primary_color"
                                                class="absolute -top-1/2 -left-1/2 w-[200%] h-[200%] cursor-pointer p-0 border-0">
                                        </div>
                                        <div class="flex-1">
                                            <input type="text" wire:model="theme.primary_color"
                                                class="w-full rounded-xl bg-white border-[#E6D9B8] text-[#5E4926] font-mono text-sm uppercase focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                    </div>
                                </div>

                                {{-- Musik --}}
                                <div class="bg-[#F9F7F2]/50 p-5 rounded-2xl border border-[#E6D9B8]/50">
                                    <label
                                        class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-3">Musik
                                        Latar (YouTube)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-red-500"><i
                                                class="fa-brands fa-youtube text-lg"></i></span>
                                        <input type="text" wire:model="theme.music_url" placeholder="..."
                                            class="w-full pl-10 rounded-xl bg-white border-[#E6D9B8] text-[#5E4926] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                    </div>
                                    @if (!empty($theme['music_url']))
                                        <div
                                            class="mt-2 flex items-center gap-2 text-[10px] text-green-600 bg-green-50 px-3 py-1.5 rounded-lg border border-green-100">
                                            <i class="fa-solid fa-circle-check"></i> Musik terdeteksi.</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Hide Scrollbar CSS --}}
                        <style>
                            .hide-scrollbar::-webkit-scrollbar {
                                display: none;
                            }

                            .hide-scrollbar {
                                -ms-overflow-style: none;
                                scrollbar-width: none;
                            }
                        </style>
                    @endif

                    {{-- ########### TAB: GIFTS ########### --}}
                    @if ($activeTab === 'gifts')
                        <div class="flex justify-between items-center mb-6 pb-2 border-b border-[#F2ECDC]">
                            <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Kado Digital</h3>
                            <button wire:click="addGift"
                                class="bg-[#5E4926] text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-[#403013] shadow-md transition flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i> Tambah Bank
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($gifts as $index => $gift)
                                <div
                                    class="bg-gradient-to-br from-[#F9F7F2] to-white p-5 rounded-2xl border border-[#E6D9B8] relative shadow-sm group hover:shadow-md transition">
                                    <button wire:click="removeGift({{ $index }})"
                                        class="absolute top-3 right-3 text-[#C6AC80] hover:text-red-500 w-6 h-6 flex items-center justify-center transition"><i
                                            class="fa-solid fa-xmark"></i></button>
                                    <div class="space-y-3 pr-6">
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Bank
                                                / E-Wallet</label>
                                            <select wire:model="gifts.{{ $index }}.bank_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-bold text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760]">
                                                <option value="">Pilih...</option>
                                                @foreach (['BCA', 'BRI', 'Mandiri', 'BNI', 'Dana', 'Gopay', 'OVO', 'Lainnya'] as $bank)
                                                    <option value="{{ $bank }}">{{ $bank }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">No.
                                                Rekening</label>
                                            <input type="number"
                                                wire:model="gifts.{{ $index }}.account_number"
                                                placeholder="123xxx"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 font-mono focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                        <div>
                                            <label
                                                class="text-[10px] font-bold text-[#9A7D4C] uppercase mb-1 block">Atas
                                                Nama</label>
                                            <input type="text" wire:model="gifts.{{ $index }}.account_name"
                                                class="w-full rounded-lg bg-white border-[#E6D9B8] text-sm py-1.5 focus:border-[#B89760] focus:ring-[#B89760]">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="col-span-full text-center py-10 bg-[#F9F7F2] rounded-xl border-2 border-dashed border-[#E6D9B8]">
                                    <i class="fa-solid fa-gift text-3xl text-[#E6D9B8] mb-3"></i>
                                    <p class="text-[#7C6339] text-sm font-medium">Belum ada data rekening.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
