<div class="flex justify-between items-center mb-6">
    <div>
        <h4 class="font-bold text-[#E0E0E0]">Rekening & Dompet Digital</h4>
        <p class="text-xs text-[#A0A0A0]">Tamu dapat memberikan kado secara cashless.</p>
    </div>

    {{-- Toggle Enable/Disable --}}
    <div class="flex items-center gap-3">
        <span class="text-xs font-bold {{ ($theme['gifts_enabled'] ?? true) ? 'text-[#D4AF37]' : 'text-[#555]' }}">
            {{ ($theme['gifts_enabled'] ?? true) ? 'Aktif' : 'Nonaktif' }}
        </span>
        <button wire:click="$toggle('theme.gifts_enabled')"
            class="w-12 h-6 rounded-full p-1 transition-colors duration-300 {{ ($theme['gifts_enabled'] ?? true) ? 'bg-[#D4AF37]' : 'bg-[#333]' }}">
            <div
                class="w-4 h-4 bg-white rounded-full shadow-md transform transition-transform duration-300 {{ ($theme['gifts_enabled'] ?? true) ? 'translate-x-6' : '' }}">
            </div>
        </button>
    </div>
</div>

@if(!($theme['gifts_enabled'] ?? true))
    <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-8 text-center opacity-50">
        <p class="text-sm text-[#A0A0A0]">Bagian Kado/Rekening dinonaktifkan. Aktifkan toggle di atas untuk mulai mengedit.
        </p>
    </div>
@else
    <div class="flex justify-end mb-4">
        <button wire:click="addGift"
            class="bg-[#D4AF37] text-[#121212] text-xs px-5 py-2.5 rounded-xl font-bold hover:bg-[#B4912F] hover:shadow-lg transition flex items-center gap-2">
            Tambah
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
            class="md:col-span-1 bg-gradient-to-br from-[#1a1a1a] to-[#252525] p-6 rounded-3xl border border-[#333333] shadow-sm">
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
                    <div class="w-10 h-10 rounded-xl bg-[#121212] flex items-center justify-center text-[#D4AF37]">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <span class="font-bold text-[#E0E0E0]">Rekening
                        {{ $loop->iteration }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        <p class="text-[10px] text-[#666] mt-1">Pilih bank atau dompet digital.</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-[#A0A0A0] uppercase mb-1 block">Nomor
                            Rekening</label>
                        <input type="number" wire:model="gifts.{{ $index }}.account_number"
                            class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 font-mono text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                            placeholder="0000 0000 0000" aria-label="Nomor rekening atau akun e-wallet">
                        <p class="text-[10px] text-[#666] mt-1">Tanpa spasi atau tanda baca.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-bold text-[#A0A0A0] uppercase mb-1 block">Atas
                            Nama</label>
                        <input type="text" wire:model="gifts.{{ $index }}.account_name"
                            class="w-full rounded-xl bg-[#121212] border-[#333333] text-sm py-2 text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                            placeholder="Nama Pemilik" aria-describedby="gift-help-{{ $index }}">
                        <p id="gift-help-{{ $index }}" class="text-[10px] text-[#666] mt-1">Pastikan sesuai dengan nama pada
                            rekening/akun.</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center rounded-3xl border-2 border-dashed border-[#333333] bg-[#1a1a1a]/50">
                <div class="w-16 h-16 bg-[#252525] rounded-full flex items-center justify-center text-[#888] mx-auto mb-4">
                    <i class="fa-solid fa-gift text-2xl"></i>
                </div>
                <h5 class="font-bold text-[#E0E0E0]">Belum ada rekening</h5>
                <p class="text-sm text-[#A0A0A0]">Tambahkan metode pembayaran untuk menerima
                    kado.</p>
            </div>
        @endforelse
    </div>
@endif