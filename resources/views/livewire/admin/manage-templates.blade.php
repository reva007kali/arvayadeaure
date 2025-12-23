<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Galeri Tema</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Kelola desain undangan yang tersedia untuk user.</p>
        </div>
        <button wire:click="openModal"
            class="px-6 py-2.5 bg-[#D4AF37] hover:bg-[#B4912F] text-[#121212] rounded-xl shadow-lg shadow-[#D4AF37]/30 font-bold text-sm flex items-center gap-2 transition transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Tambah Tema
        </button>
    </div>

    {{-- GRID TEMPLATES --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4">
        @foreach ($templates as $item)
            <div class="group rounded-xl overflow-hidden border border-[#333333] bg-[#1a1a1a] cursor-pointer hover:border-[#D4AF37] transition-all"
                wire:click="edit({{ $item->id }})">
                <div class="relative aspect-[3/4]">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#333333] bg-[#252525]">
                            <i class="fa-solid fa-image text-2xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-black/60 backdrop-blur-md border border-white/10 text-[#E0E0E0]">
                            {{ ucfirst($item->tier ?? $item->type) }}
                        </span>
                        @if ($item->category)
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-blue-500/20 backdrop-blur-md border border-blue-500/30 text-blue-400">
                                {{ $item->category }}
                            </span>
                        @endif
                        @if ($item->price > 0)
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#D4AF37] text-[#121212] border border-[#D4AF37]">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        @else
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-500 text-white border border-green-500">
                                FREE
                            </span>
                        @endif
                    </div>
                    <div class="absolute top-2 right-2">
                        <button wire:click.stop="toggleActive({{ $item->id }})"
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border backdrop-blur-md
                                    {{ $item->is_active ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-gray-800/80 text-gray-400 border-gray-600' }}">
                            {{ $item->is_active ? 'Visible' : 'Hidden' }}
                        </button>
                    </div>
                </div>
                <div class="px-3 py-3">
                    <h3 class="font-serif font-bold text-sm text-[#E0E0E0] truncate">{{ $item->name }}</h3>
                    <p class="text-[10px] opacity-60 text-[#A0A0A0] font-mono">{{ $item->slug }}</p>
                    <span class="text-[10px] inline-flex items-center gap-1 text-[#D4AF37] mt-1"><i
                            class="fa-solid fa-pen"></i> Edit</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODAL FORM --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm px-4" x-transition>
            <div
                class="bg-[#1a1a1a] rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-[#333333] animate-fade-in-up">

                <div class="p-6 border-b border-[#333333] bg-[#252525] flex justify-between items-center">
                    <h3 class="font-serif font-bold text-xl text-[#E0E0E0]">
                        {{ $isEdit ? 'Edit Template' : 'Tambah Template Baru' }}
                    </h3>
                    <button wire:click="$set('isOpen', false)" class="text-[#888] hover:text-red-500 transition"><i
                            class="fa-solid fa-times text-xl"></i></button>
                </div>

                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Nama Tampilan</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Arvaya Rustic"
                            class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Slug / Key (Wajib Sama
                            dengan File Blade)</label>
                        <input type="text" wire:model="slug" placeholder="rustic"
                            class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37] font-mono">
                        <p class="text-[10px] text-[#666] mt-1">Pastikan ada file
                            <code>resources/views/components/themes/<b>slug</b>.blade.php</code>
                        </p>
                        @error('slug')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Type & Price Row --}}
                    <div class="grid grid-cols-3 gap-4">
                        {{-- Type --}}
                        <div>
                            <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Kategori Tier</label>
                            <select wire:model="tier"
                                class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                                <option value="basic">Basic (Fitur Standar)</option>
                                <option value="premium">Premium (Fitur Lengkap)</option>
                                <option value="exclusive">Exclusive (Full Custom)</option>
                            </select>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Kategori Acara</label>
                            <select wire:model="category"
                                class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                                <option value="Wedding">Wedding</option>
                                <option value="Engagement">Engagement</option>
                                <option value="Birthday">Birthday</option>
                                <option value="Aqiqah">Aqiqah</option>
                                <option value="Khitan">Khitan</option>
                                <option value="Event">Event</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('category')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Harga (IDR)</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#666] font-bold text-xs">Rp</span>
                                <input type="number" wire:model="price" placeholder="0"
                                    class="w-full pl-8 rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37]">
                            </div>
                            @error('price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Deskripsi Singkat</label>
                        <textarea wire:model="description" rows="2"
                            class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm focus:border-[#D4AF37] focus:ring-[#D4AF37]"></textarea>
                    </div>

                    {{-- Upload Thumbnail --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Thumbnail Image
                            (Potrait)</label>
                        <input type="file" wire:model="thumbnail"
                            class="block w-full text-sm text-[#888] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#333] file:text-[#D4AF37] hover:file:bg-[#444]">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}" class="h-20 mt-2 rounded border border-[#333]">
                        @endif
                        @error('thumbnail')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Upload Video --}}
                    <div>
                        <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-1">Video Preview
                            (Optional)</label>
                        <input type="file" wire:model="preview_video"
                            class="block w-full text-sm text-[#888] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#333] file:text-[#D4AF37] hover:file:bg-[#444]">
                        @error('preview_video')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-[#A0A0A0] uppercase cursor-pointer">
                            <input type="checkbox" wire:model="is_active"
                                class="rounded bg-[#252525] border-[#333333] text-[#D4AF37] focus:ring-[#D4AF37]">
                            Tampilkan ke User
                        </label>
                    </div>
                </div>

                <div class="p-6 border-t border-[#333333] bg-[#252525] flex justify-end gap-3">
                    <button wire:click="$set('isOpen', false)"
                        class="px-4 py-2 text-xs font-bold text-[#888] hover:text-[#E0E0E0] transition">Batal</button>
                    <button wire:click="save"
                        class="px-6 py-2 bg-[#D4AF37] text-[#121212] rounded-xl text-xs font-bold hover:bg-[#B4912F] shadow-lg transition">
                        <span wire:loading.remove>Simpan Template</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>