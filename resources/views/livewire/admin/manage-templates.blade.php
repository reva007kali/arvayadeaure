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
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 md:gap-4">
        @foreach ($templates as $item)
            <div class="group rounded-xl overflow-hidden border border-[#E6D9B8] bg-gray-100 cursor-pointer"
                wire:click="edit({{ $item->id }})">
                <div class="relative aspect-[9/16]">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-[#C6AC80]">
                            <i class="fa-solid fa-image text-2xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2 flex items-center gap-1">
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-white/80 border border-white/60 text-[#7C6339]">
                            {{ ucfirst($item->tier ?? $item->type) }}
                        </span>
                        @if ($item->price > 0)
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#B89760] text-white border border-white/40">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        @else
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-500 text-white border border-white/40">
                                FREE
                            </span>
                        @endif
                    </div>
                    <div class="absolute top-2 right-2">
                        <button wire:click.stop="toggleActive({{ $item->id }})"
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border
                            {{ $item->is_active ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-gray-100 text-gray-500 border-gray-200 hover:bg-gray-200' }}">
                            {{ $item->is_active ? 'Visible' : 'Hidden' }}
                        </button>
                    </div>
                </div>
                <div class="px-2 py-2">
                    <h3 class="font-serif font-bold text-sm text-[#5E4926]">{{ $item->name }}</h3>
                    <p class="text-[10px] opacity-80 text-[#7C6339]">{{ $item->slug }}</p>
                    <span class="text-[10px] inline-flex items-center gap-1 text-[#9A7D4C]"><i
                            class="fa-solid fa-pen"></i> Klik untuk edit</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MODAL FORM --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#2D2418]/60 backdrop-blur-sm px-4"
            x-transition>
            <div
                class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden border border-[#E6D9B8] animate-fade-in-up modal-gold-ui">

                <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2] flex justify-between items-center">
                    <h3 class="font-serif font-bold text-xl text-[#5E4926]">
                        {{ $isEdit ? 'Edit Template' : 'Tambah Template Baru' }}
                    </h3>
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
                            <code>resources/views/components/themes/<b>slug</b>.blade.php</code>
                        </p>
                        @error('slug')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Type & Price Row --}}
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Type --}}
                        {{-- Input Tier --}}
                        <div>
                            <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Kategori Tier</label>
                            <select wire:model="tier"
                                class="w-full rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                                <option value="basic">Basic (Fitur Standar)</option>
                                <option value="premium">Premium (Fitur Lengkap)</option>
                                <option value="exclusive">Exclusive (Full Custom)</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-xs font-bold text-[#7C6339] uppercase mb-1">Harga (IDR)</label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#9A7D4C] font-bold text-xs">Rp</span>
                                <input type="number" wire:model="price" placeholder="0"
                                    class="w-full pl-8 rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                            </div>
                            @error('price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
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
                    <div>
                        <label class="flex items-center gap-2 text-xs font-bold text-[#7C6339] uppercase">
                            <input type="checkbox" wire:model="is_active" class="rounded">
                            Tampilkan ke User
                        </label>
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
