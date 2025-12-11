<div class="py-2 animate-fade-in-up">

    {{-- HEADER --}}
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Galeri Tema</h2>
            <p class="text-[#9A7D4C] text-sm mt-1">Kelola desain undangan yang tersedia untuk user.</p>
        </div>
        <button wire:click="openModal"
            class="px-6 py-2.5 bg-[#B89760] hover:bg-[#9A7D4C] text-white rounded-xl shadow-lg shadow-[#B89760]/30 font-bold text-sm flex items-center gap-2 transition transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Tambah Tema
        </button>
    </div>

    {{-- GRID TEMPLATES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($templates as $item)
            <div
                class="group bg-white rounded-2xl border border-[#E6D9B8] overflow-hidden shadow-sm hover:shadow-[0_10px_30px_rgba(184,151,96,0.2)] transition duration-300 flex flex-col h-full relative">

                {{-- Badge Type --}}
                <div class="absolute top-3 left-3 z-10">
                    <span
                        class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider shadow-sm border border-white/20
                        {{ $item->type == 'premium' ? 'bg-[#2D2418] text-[#B89760]' : 'bg-white/90 text-[#7C6339]' }}">
                        {{ $item->type }}
                    </span>
                </div>

                {{-- Thumbnail / Video Area --}}
                <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden group/media">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#C6AC80]">
                            <i class="fa-solid fa-image text-3xl"></i>
                        </div>
                    @endif

                    {{-- Hover Overlay Actions --}}
                    <div
                        class="absolute inset-0 bg-[#5E4926]/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center gap-3">
                        <button wire:click="edit({{ $item->id }})"
                            class="px-4 py-2 bg-white text-[#5E4926] rounded-lg text-xs font-bold hover:bg-[#B89760] hover:text-white transition">
                            <i class="fa-solid fa-pen"></i> Edit
                        </button>

                        <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus template ini?"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg text-xs font-bold hover:bg-red-600 transition">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>

                        @if ($item->preview_video)
                            <a href="{{ asset('storage/' . $item->preview_video) }}" target="_blank"
                                class="text-white text-xs mt-2 hover:underline">
                                <i class="fa-solid fa-play-circle"></i> Cek Video
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="font-serif font-bold text-lg text-[#5E4926]">{{ $item->name }}</h3>
                    <p class="text-xs font-mono text-[#B89760] mb-2 bg-[#F9F7F2] inline-block px-2 py-0.5 rounded">Slug:
                        {{ $item->slug }}</p>
                    <p class="text-xs text-[#7C6339] line-clamp-2">{{ $item->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODAL FORM (Slide Over / Center Modal) --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#2D2418]/60 backdrop-blur-sm px-4"
            x-transition>
            <div
                class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-[#E6D9B8] animate-fade-in-up">

                <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2] flex justify-between items-center">
                    <h3 class="font-serif font-bold text-xl text-[#5E4926]">
                        {{ $isEdit ? 'Edit Template' : 'Tambah Template Baru' }}</h3>
                    <button wire:click="$set('isOpen', false)" class="text-[#9A7D4C] hover:text-[#5E4926]"><i
                            class="fa-solid fa-times text-xl"></i></button>
                </div>

                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Nama Tampilan</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Arvaya Rustic"
                            class="w-full rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Slug / Key (Wajib Sama
                            dengan File Blade)</label>
                        <input type="text" wire:model="slug" placeholder="rustic"
                            class="w-full rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760] bg-[#F9F7F2] font-mono">
                        <p class="text-[10px] text-[#9A7D4C] mt-1">Pastikan ada file
                            <code>resources/views/components/themes/<b>slug</b>.blade.php</code></p>
                        @error('slug')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Kategori</label>
                        <select wire:model="type"
                            class="w-full rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                            <option value="basic">Basic</option>
                            <option value="premium">Premium (Berbayar)</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Deskripsi Singkat</label>
                        <textarea wire:model="description" rows="2"
                            class="w-full rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]"></textarea>
                    </div>

                    {{-- Upload Thumbnail --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Thumbnail Image
                            (Potrait)</label>
                        <input type="file" wire:model="thumbnail"
                            class="block w-full text-sm text-[#7C6339] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#B89760] file:text-white hover:file:bg-[#9A7D4C]">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}"
                                class="h-20 mt-2 rounded border border-[#E6D9B8]">
                        @endif
                        @error('thumbnail')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Upload Video --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Video Preview
                            (Optional)</label>
                        <input type="file" wire:model="preview_video"
                            class="block w-full text-sm text-[#7C6339] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#E6D9B8] file:text-[#5E4926] hover:file:bg-[#D4C1A0]">
                        @error('preview_video')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="p-6 border-t border-[#F2ECDC] bg-[#F9F7F2] flex justify-end gap-3">
                    <button wire:click="$set('isOpen', false)"
                        class="px-4 py-2 text-xs font-bold text-[#7C6339] hover:text-[#5E4926]">Batal</button>
                    <button wire:click="save"
                        class="px-6 py-2 bg-[#B89760] text-white rounded-xl text-xs font-bold hover:bg-[#9A7D4C] shadow-md">
                        <span wire:loading.remove>Simpan Template</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
