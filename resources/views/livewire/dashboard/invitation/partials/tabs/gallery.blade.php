<div class="space-y-8 max-w-5xl mx-auto">
    <style>
        .sortable-ghost {
            opacity: 0.5;
        }
    </style>
    {{-- Main Photos --}}
    <div>
        <h4 class="font-bold text-[#E0E0E0] mb-4">Foto Utama</h4>
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
                    </div>

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
        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress" class="mb-6 relative group">

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
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" title="Klik untuk memilih foto">

            {{-- Progress Bar Overlay (Upload Phase) --}}
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

            {{-- Processing Overlay (Server Phase) --}}
            <div wire:loading.flex wire:target="newMoments"
                class="absolute inset-0 bg-[#1a1a1a]/95 rounded-3xl flex-col items-center justify-center z-30 transition-opacity hidden">
                <div class="w-12 h-12 rounded-full border-4 border-[#333] border-t-[#D4AF37] animate-spin mb-3">
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
            <div class="space-y-3 max-w-xl mx-auto" wire:ignore x-data="{
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
                            forceFallback: true, // Penting untuk drag instan tanpa delay native
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
                <div x-ref="items" class="space-y-3">
                    @foreach ($gallery['moments'] as $index => $path)
                        <div data-id="{{ $index }}"
                            class="flex items-center gap-3 bg-[#1a1a1a] rounded-xl border border-[#333333] p-2 shadow-sm select-none group">
                            {{-- Drag Handle --}}
                            <div
                                class="pl-2 pr-2 py-4 text-[#555] group-hover:text-[#D4AF37] transition cursor-move drag-handle touch-none">
                                <i class="fa-solid fa-grip-vertical text-lg"></i>
                            </div>

                            <div
                                class="w-24 aspect-[3/4] rounded-lg overflow-hidden border border-[#333333] bg-[#252525] shrink-0 pointer-events-none">
                                <img src="{{ asset($path) }}" loading="lazy" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-[#A0A0A0]">Foto #{{ $loop->iteration }}</p>
                                <p class="text-[10px] text-[#555] hidden sm:block">Geser menggunakan icon grip</p>
                            </div>

                            <div class="flex items-center gap-2 pr-2">
                                {{-- Remove only --}}
                                <button wire:click="removeMoment({{ $index }})" wire:confirm="Hapus foto ini dari galeri?"
                                    class="md:w-8 md:h-8 w-10 h-10 rounded-full bg-[#252525] text-red-500 hover:bg-red-900/20 shadow-sm flex items-center justify-center border border-red-900/20">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile Helper Text --}}
                <div class="text-center sm:hidden mt-2">
                    <p class="text-[10px] text-[#555] italic">
                        <i class="fa-solid fa-hand-pointer"></i> Gunakan icon grip di kiri untuk memindah urutan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>