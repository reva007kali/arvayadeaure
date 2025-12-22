<div class="space-y-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h4 class="font-bold text-[#E0E0E0] text-lg">Panduan Busana (Dress Code)</h4>
            <p class="text-xs text-[#A0A0A0]">Atur ketentuan pakaian untuk tamu undangan Anda.</p>
        </div>
        
        {{-- Toggle Enable/Disable --}}
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold {{ ($dressCode['enabled'] ?? true) ? 'text-[#D4AF37]' : 'text-[#555]' }}">
                {{ ($dressCode['enabled'] ?? true) ? 'Aktif' : 'Nonaktif' }}
            </span>
            <button wire:click="$toggle('dressCode.enabled')" 
                class="w-12 h-6 rounded-full p-1 transition-colors duration-300 {{ ($dressCode['enabled'] ?? true) ? 'bg-[#D4AF37]' : 'bg-[#333]' }}">
                <div class="w-4 h-4 bg-white rounded-full shadow-md transform transition-transform duration-300 {{ ($dressCode['enabled'] ?? true) ? 'translate-x-6' : '' }}"></div>
            </button>
        </div>
    </div>

    {{-- Feature Gating Check --}}
    @if(!$invitation->hasFeature('dress_code'))
        <div class="bg-[#252525] border border-dashed border-[#555] rounded-xl p-8 text-center">
            <div class="w-16 h-16 bg-[#1a1a1a] rounded-full flex items-center justify-center mx-auto mb-4 text-[#555]">
                <i class="fa-solid fa-lock text-2xl"></i>
            </div>
            <h3 class="font-bold text-[#E0E0E0] mb-2">Fitur Terkunci</h3>
            <p class="text-xs text-[#A0A0A0] mb-4 max-w-xs mx-auto">Fitur Dress Code hanya tersedia untuk paket Premium. Upgrade sekarang untuk mengaktifkan fitur ini.</p>
            <button wire:click="openModal('theme')" class="px-6 py-2 bg-[#D4AF37] text-[#121212] font-bold rounded-xl text-sm hover:bg-[#b8962e] transition">
                Lihat Paket Upgrade
            </button>
        </div>
    @elseif(!($dressCode['enabled'] ?? true))
        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-8 text-center opacity-50">
            <p class="text-sm text-[#A0A0A0]">Fitur Dress Code dinonaktifkan. Aktifkan toggle di atas untuk mulai mengedit.</p>
        </div>
    @else
        {{-- Form Content --}}
        <div class="grid md:grid-cols-2 gap-6 animate-fade-in">
            
            {{-- 1. Description --}}
            <div class="md:col-span-2">
                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Deskripsi Gaya (Style)</label>
                <textarea wire:model="dressCode.description" rows="3"
                    placeholder="Contoh: Tamu harap mengenakan pakaian Formal atau Batik. Hindari warna putih."
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all"></textarea>
            </div>

            {{-- 2. Color Palette --}}
            <div>
                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Palet Warna</label>
                <div class="space-y-3">
                    <div class="flex flex-wrap gap-3">
                        @foreach($dressCode['colors'] as $index => $color)
                            <div class="relative group">
                                <input type="color" wire:model.live="dressCode.colors.{{ $index }}"
                                    class="w-10 h-10 rounded-lg border-none cursor-pointer bg-transparent p-0">
                                <button wire:click="removeDressCodeColor({{ $index }})"
                                    class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-[10px] opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        @endforeach
                        
                        <button wire:click="addDressCodeColor"
                            class="w-10 h-10 rounded-lg border border-dashed border-[#555] text-[#555] hover:text-[#D4AF37] hover:border-[#D4AF37] flex items-center justify-center transition">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <p class="text-[10px] text-[#666]">Klik kotak warna untuk mengubah. Gunakan 2–5 warna.</p>
                </div>
            </div>

            {{-- 3. Palette Image / Moodboard --}}
            <div>
                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Contoh Visual / Moodboard</label>
                
                <div class="flex items-start gap-4">
                    {{-- Preview --}}
                    @if ($newPaletteImage)
                        <div class="w-24 h-24 rounded-xl overflow-hidden border border-[#333] relative group">
                            <img src="{{ $newPaletteImage->temporaryUrl() }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                <span class="text-[10px] text-white font-bold">New</span>
                            </div>
                        </div>
                    @elseif(!empty($dressCode['palette_image']))
                         <div class="w-24 h-24 rounded-xl overflow-hidden border border-[#333] relative group">
                            <img src="{{ asset($dressCode['palette_image']) }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 rounded-xl bg-[#252525] border border-dashed border-[#444] flex items-center justify-center text-[#444]">
                            <i class="fa-regular fa-image text-2xl"></i>
                        </div>
                    @endif

                    {{-- Upload Button --}}
                    <div class="flex-1">
                        <input type="file" id="paletteUpload" wire:model="newPaletteImage" class="hidden" accept="image/*">
                        <label for="paletteUpload" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#252525] hover:bg-[#333] text-[#E0E0E0] text-xs font-bold rounded-xl cursor-pointer transition border border-[#333]">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Gambar
                        </label>
                        <p class="text-[10px] text-[#666] mt-2">Max 5MB. Gunakan gambar inspirasi style pakaian.</p>
                        @error('newPaletteImage') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- 4. Notes --}}
            <div class="md:col-span-2">
                <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-2 block">Catatan Tambahan (Lokasi/Cuaca)</label>
                <textarea wire:model="dressCode.note" rows="2"
                    placeholder="Contoh: Lokasi outdoor berumput, disarankan tidak menggunakan high heels runcing."
                    class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all"></textarea>
            </div>

        </div>
    @endif
</div>
