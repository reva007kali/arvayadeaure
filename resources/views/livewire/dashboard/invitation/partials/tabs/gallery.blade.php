<div class="space-y-8 max-w-5xl mx-auto">
    <style>
        .sortable-ghost {
            opacity: 0.5;
        }
    </style>
    {{-- Main Photos --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h4 class="font-bold text-[#E0E0E0] mb-1">Foto Utama</h4>
            <p class="text-xs text-[#A0A0A0]">Atur foto sampul dan foto mempelai.</p>
        </div>
        
        {{-- Toggle Enable/Disable --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold {{ $gallery['enabled'] ? 'text-[#D4AF37]' : 'text-[#555]' }}">
                {{ $gallery['enabled'] ? 'Aktif' : 'Nonaktif' }}
            </span>
            <button wire:click="$toggle('gallery.enabled')" 
                class="w-12 h-6 rounded-full p-1 transition-colors duration-300 {{ $gallery['enabled'] ? 'bg-[#D4AF37]' : 'bg-[#333]' }}">
                <div class="w-4 h-4 bg-white rounded-full shadow-md transform transition-transform duration-300 {{ $gallery['enabled'] ? 'translate-x-6' : '' }}"></div>
            </button>
        </div>
    </div>

    @if(!$gallery['enabled'])
        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-8 text-center opacity-50">
            <p class="text-sm text-[#A0A0A0]">Galeri Foto dinonaktifkan. Aktifkan toggle di atas untuk mulai mengedit.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @foreach (['cover' => 'Sampul Undangan', 'groom' => 'Foto Pria', 'bride' => 'Foto Wanita'] as $key => $label)
                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
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
                        <button wire:click.stop="removeSpecific('{{ $key }}')" wire:confirm="Yakin ingin menghapus foto ini?"
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
                        <span class="text-[10px] font-bold text-[#E0E0E0] uppercase tracking-wide">{{ $label }}</span>
                        <p class="text-[8px] text-[#888]">Max 10MB</p>
                    </div>

                    {{-- Error Message --}}
                    @error($newVar)
                        <div
                            class="absolute inset-0 pointer-events-none bg-red-900/90 flex items-center justify-center p-2 text-center z-40">
                            <span class="text-[10px] text-white font-bold">{{ $message }}</span>
                        </div>
                    @enderror

                    {{-- File Input --}}
                    <input type="file" wire:model="{{ $newVar }}" class="absolute inset-0 opacity-0 cursor-pointer z-10">

                    {{-- Progress Bar Overlay --}}
                    <div x-show="isUploading"
                        class="absolute inset-0 bg-[#1a1a1a]/90 flex flex-col items-center justify-center z-30 transition-opacity">
                        <div class="relative w-16 h-16">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="32" cy="32" r="28" stroke="#333" stroke-width="4" fill="none" />
                                <circle cx="32" cy="32" r="28" stroke="#D4AF37" stroke-width="4" fill="none"
                                    stroke-dasharray="175.9" :stroke-dashoffset="175.9 - (progress / 100 * 175.9)"
                                    class="transition-all duration-300 ease-out" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-bold text-[#E0E0E0]" x-text="progress + '%'"></span>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-[#A0A0A0] mt-2 uppercase tracking-wide">Uploading...</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <hr class="border-[#333333] border-dashed">

    {{-- Moments Gallery --}}
    <div>
        {{-- Shared Hidden Input --}}
        <input type="file" id="galleryUploadInput" wire:model="newMoments" multiple class="hidden" accept="image/*">

        {{-- Global Processing Overlay (When uploading/saving) --}}
        <div wire:loading.flex wire:target="newMoments"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
            <div class="bg-[#1a1a1a] p-6 rounded-2xl border border-[#333] flex flex-col items-center shadow-2xl">
                <div class="w-12 h-12 border-4 border-[#333] border-t-[#D4AF37] rounded-full animate-spin mb-3"></div>
                <h5 class="text-[#E0E0E0] font-bold text-sm">Menyimpan Foto...</h5>
                <p class="text-[10px] text-[#A0A0A0] mt-1">Mohon tunggu sebentar</p>
            </div>
        </div>

        {{-- Header --}}
        <div class="flex gap-4 justify-between items-center mb-4">

            {{-- foto rules --}}
            <div class="max-w-[300px] border border-[#333333] p-2 rounded-md">
                <h4 class="font-bold text-[#E0E0E0]">Galeri Momen</h4>
                <p class="text-arvaya-500/70 leading-[15px] text-[11px]">Max 10MB per foto. Silahkan kompres foto anda
                    terlebih dahulu jika
                    file terlalu besar.</p>
            </div>


            {{-- Small Add Button (Visible only when there are photos) --}}
            @if(count($gallery['moments'] ?? []) > 0)
                <div class="flex flex-col gap-2 items-center">
                    <label for="galleryUploadInput"
                        class="cursor-pointer px-4 py-2 bg-[#D4AF37] text-[#121212] text-xs font-bold rounded-xl shadow-sm hover:shadow-md hover:bg-[#b8962e] transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Foto
                    </label>
                </div>
            @endif
        </div>

        {{-- Error Message for Moments --}}
        @error('newMoments.*')
            <div class="text-center py-5 z-40">
                <span class="inline-block bg-red-900/90 text-white text-[10px] font-bold px-3 py-1 rounded shadow-lg">
                    @if(Str::contains($message, '10'))
                        Ukuran foto terlalu besar. Maksimal 10MB.
                    @else
                        Foto tidak dapat diupload, pastikan ukurannya tidak lebih dari 10MB.
                        <a href="https://www.iloveimg.com/id/kompres-gambar" class="text-[#D4AF37] text-[10px] font-bold underline">
                            klik untuk kompres foto
                        </a>
                    @endif
                </span>
            </div>
        @enderror

        {{-- Condition: Empty State (Big Upload Box) --}}
        @if(count($gallery['moments'] ?? []) == 0)
            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress" class="mb-6 relative group">

                <label for="galleryUploadInput"
                    class="w-full pt-12 pb-12 rounded-3xl border-2 border-dashed border-[#D4AF37]/40 bg-[#1a1a1a] hover:bg-[#252525] transition flex flex-col items-center justify-center cursor-pointer gap-3 block">

                    <div
                        class="w-16 h-16 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] mb-2 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl"></i>
                    </div>

                    <div class="text-center">
                        <h5 class="font-bold text-[#E0E0E0] text-sm">Upload Foto Galeri</h5>
                        <p class="text-[10px] text-[#A0A0A0] mt-1">Klik untuk memilih foto dari perangkat Anda</p>
                        <p class="text-[9px] text-[#666] mt-1">Max 10MB per foto.</p>
                    </div>

                    <div class="mt-2 px-4 py-2 bg-[#252525] text-[#D4AF37] text-[10px] font-bold rounded-lg">
                        <i class="fa-solid fa-images"></i> Pilih Foto
                    </div>
                </label>

                {{-- Upload Progress Overlay --}}
                <div x-show="isUploading"
                    class="absolute inset-0 bg-[#1a1a1a]/95 rounded-3xl flex flex-col items-center justify-center z-30 transition-opacity">
                    <div class="relative w-16 h-16 mb-2">
                        <svg class="w-full h-full transform -rotate-90">
                            <circle cx="32" cy="32" r="28" stroke="#333" stroke-width="4" fill="none" />
                            <circle cx="32" cy="32" r="28" stroke="#D4AF37" stroke-width="4" fill="none"
                                stroke-dasharray="175.9" :stroke-dashoffset="175.9 - (progress / 100 * 175.9)"
                                class="transition-all duration-300 ease-out" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-[#E0E0E0]" x-text="progress + '%'"></span>
                        </div>
                    </div>
                    <span
                        class="text-[10px] font-bold text-[#A0A0A0] uppercase tracking-wide animate-pulse">Mengupload...</span>
                </div>

                {{-- Error Message for Moments --}}
                @error('newMoments.*')
                    <div class="absolute bottom-4 left-0 right-0 text-center z-40">
                        <span
                            class="inline-block bg-red-900/90 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-lg">{{ $message }}</span>
                    </div>
                @enderror
            </div>
        @endif

        {{-- Condition: List State (Sortable List) --}}
        @if(count($gallery['moments'] ?? []) > 0)
            <div class="space-y-3">
                <div class="space-y-3 max-w-xl mx-auto" x-data="{
                        init() {
                        let el = this.$refs.items;

                        const initSortable = () => {
                        if (typeof Sortable === 'undefined') {
                        setTimeout(initSortable, 100);
                        return;
                        }

                            let sortable = new Sortable(el, {
                                animation: 150,
                                delay: 0, 
                                handle: '.drag-handle',
                                forceFallback: true,
                                fallbackOnBody: true,
                                swapThreshold: 0.65,
                                ghostClass: 'sortable-ghost',
                                dragClass: 'sortable-drag',
                                onEnd: (evt) => {
                                    let order = sortable.toArray(); 
                                    $wire.reorderMoments(order);
                                        }
                                          });
                                            }

                                             initSortable();
                                                 }
                                                    }">
                    {{-- Note: wire:ignore REMOVED to allow realtime updates --}}
                    <div x-ref="items" class="space-y-3">
                        @foreach ($gallery['moments'] as $index => $path)
                            <div wire:key="moment-{{ $index }}-{{ md5($path) }}" data-id="{{ $index }}"
                                class="flex items-center gap-3 bg-[#1a1a1a] rounded-xl border border-[#333333] p-2 shadow-sm select-none group hover:border-[#D4AF37]/50 transition">
                                {{-- Drag Handle --}}
                                <div
                                    class="pl-2 pr-2 py-4 text-[#555] group-hover:text-[#D4AF37] transition cursor-move drag-handle touch-none">
                                    <i class="fa-solid fa-grip-vertical text-lg"></i>
                                </div>

                                <div
                                    class="w-20 h-20 aspect-square rounded-lg overflow-hidden border border-[#333333] bg-[#252525] shrink-0 pointer-events-none">
                                    <img src="{{ asset($path) }}" loading="lazy" class="w-full h-full object-cover">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-[#E0E0E0]">Foto #{{ $loop->iteration }}</p>
                                    <p class="text-[10px] text-[#555] hidden sm:block">Geser untuk urutkan</p>
                                </div>

                                <div class="flex items-center gap-2 pr-2">
                                    <button wire:click="removeMoment({{ $index }})"
                                        class="md:w-8 md:h-8 w-10 h-10 rounded-full bg-[#252525] text-red-500 hover:bg-red-500 hover:text-white shadow-sm flex items-center justify-center border border-red-900/20 transition">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Mobile Helper Text --}}
                    <div class="text-center sm:hidden mt-2">
                        <p class="text-[10px] text-[#555] italic">
                            <i class="fa-solid fa-hand-pointer"></i> Gunakan icon grip untuk memindah urutan
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>