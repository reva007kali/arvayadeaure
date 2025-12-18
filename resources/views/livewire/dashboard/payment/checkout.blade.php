<div class="py-6 max-w-4xl mx-auto animate-fade-in-up dashboard-ui">

    <div class="mb-10 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Selesaikan Pembayaran</h2>
        <p class="text-[#A0A0A0] text-sm mt-1">Satu langkah lagi untuk mengaktifkan undanganmu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- LEFT: INVOICE DETAILS --}}
        <div class="space-y-6">
            <div class="bg-[#1a1a1a] p-8 rounded-3xl border border-[#333333] shadow-sm relative overflow-hidden">
                {{-- Decorative Stamp --}}
                <div
                    class="absolute top-0 right-0 bg-[#252525] px-4 py-2 rounded-bl-2xl border-b border-l border-[#333333] text-[#D4AF37] font-bold text-xs uppercase tracking-wider">
                    Invoice
                </div>

                <h3 class="font-serif font-bold text-xl text-[#E0E0E0] mb-6">Detail Pesanan</h3>

                <div class="flex gap-4 mb-6">
                    <div
                        class="w-16 h-16 bg-[#252525] rounded-xl flex items-center justify-center text-[#D4AF37] text-2xl shadow-inner border border-[#333333]">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <p class="text-xs text-[#A0A0A0] uppercase font-bold">Template Pilihan</p>
                        <h4 class="font-bold text-lg text-[#E0E0E0]">{{ $templateName }}</h4>
                        <span
                            class="inline-block bg-[#D4AF37] text-[#121212] text-[10px] px-2 py-0.5 rounded uppercase tracking-wider font-bold mt-1">
                            {{ ucfirst($templateTier) }} Tier
                        </span>
                    </div>
                </div>

                <div class="bg-[#252525] p-4 rounded-xl mb-6 border border-[#333333]">
                    <p class="text-xs font-bold text-[#A0A0A0] mb-2 uppercase">Fitur Termasuk:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($features as $feat)
                            <div class="flex items-center gap-2 text-xs text-[#E0E0E0]">
                                <i class="fa-solid fa-check text-[#D4AF37]"></i>
                                {{ ucwords(str_replace('_', ' ', $feat)) }}
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($isUpgrade)
                    <div class="space-y-2 border-t border-dashed border-[#333333] pt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#A0A0A0]">Harga Template Baru</span>
                            <span class="font-bold text-[#E0E0E0]">Rp
                                {{ number_format($templatePrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#A0A0A0]">Pembayaran Sebelumnya</span>
                            <span class="font-bold text-[#E0E0E0]">Rp
                                {{ number_format($templatePrice - $payableAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-end mt-2">
                            <span class="text-sm font-bold text-[#A0A0A0]">Selisih yang Harus Dibayar</span>
                            <span class="font-sans font-bold text-2xl md:text-3xl text-[#D4AF37]">Rp
                                {{ number_format($payableAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-t border-dashed border-[#333333] pt-4 gap-1">
                        <span class="text-sm font-bold text-[#A0A0A0]">Total Tagihan</span>
                        <span class="font-sans font-bold text-2xl md:text-3xl text-[#D4AF37]">Rp
                            {{ number_format($templatePrice, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                class="flex items-center justify-center gap-2 text-sm text-[#A0A0A0] hover:text-[#E0E0E0] transition">
                <i class="fa-solid fa-arrow-left"></i> Ganti Template
            </a>
        </div>

        {{-- RIGHT: PAYMENT --}}
        <div class="bg-[#1a1a1a] p-8 rounded-3xl text-[#E0E0E0] shadow-xl relative h-fit border border-[#333333]">
            <h4 class="font-bold text-[#E0E0E0] mb-6 flex items-center gap-2 text-lg">
                <i class="fa-solid fa-wallet text-[#D4AF37]"></i> Metode Transfer
            </h4>

            <div class="bg-[#252525] p-5 rounded-2xl border border-[#333333] mb-8 backdrop-blur-sm">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[10px] text-[#A0A0A0] uppercase font-bold">Bank Transfer</p>
                    <button onclick="navigator.clipboard.writeText('0561621828'); alert('Tersalin!')"
                        class="text-xs text-[#D4AF37] hover:text-white transition cursor-pointer"><i
                            class="fa-regular fa-copy"></i> Salin</button>
                </div>
                <div class="flex items-center gap-3 mb-1">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                        class="h-8 p-1 bg-white rounded px-1">
                    <p class="font-mono text-2xl font-bold text-[#E0E0E0] tracking-wider">0561621828</p>
                </div>
                <p class="text-xs text-[#A0A0A0]">A.N Revaldy Adhityawiguna Sahabu</p>
            </div>

            @if ($isDowngrade)
                <div class="p-4 bg-[#252525] border border-[#333333] rounded-xl text-sm">
                    <p class="text-[#E0E0E0]">Anda mengubah ke template yang lebih murah. Tidak perlu membayar. Admin
                        akan memproses refund sebesar <span class="font-bold text-[#D4AF37]">Rp
                            {{ number_format($invitation->refund_amount, 0, ',', '.') }}</span>.</p>
                </div>
            @endif

            <form wire:submit="save" class="space-y-6" @if ($isDowngrade) x-data
            x-init="$el.querySelector('button[type=submit]').disabled = true" @endif>
                <div>
                    <label class="block text-xs font-bold text-[#A0A0A0] uppercase mb-2">Upload Bukti Transfer</label>
                    <div class="relative w-full">
                        <input type="file" wire:model="proofImage" id="file-upload" class="hidden" accept="image/*" />
                        <label for="file-upload"
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-xl cursor-pointer transition-all duration-300 overflow-hidden relative group
                            {{ $proofImage ? 'border-[#D4AF37] bg-black/20' : 'border-[#333333] hover:bg-[#252525] hover:border-[#D4AF37]' }}">

                            @if ($proofImage)
                                {{-- Preview Image --}}
                                <img src="{{ $proofImage->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 backdrop-blur-[1px]">
                                    <i class="fa-solid fa-cloud-arrow-up text-[#D4AF37] text-3xl mb-2 drop-shadow-md"></i>
                                    <span class="text-xs font-bold text-white drop-shadow-md">Klik untuk Ganti Foto</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center text-[#A0A0A0] group-hover:text-[#D4AF37] transition-colors">
                                    <i class="fa-solid fa-camera text-3xl mb-3"></i>
                                    <p class="text-xs font-bold uppercase tracking-wider">Tap to Upload</p>
                                </div>
                            @endif
                        </label>
                    </div>
                    @error('proofImage')
                        <span class="text-red-400 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-[#D4AF37] text-[#121212] rounded-xl font-bold hover:bg-[#B4912F] transition shadow-lg shadow-[#D4AF37]/20 flex justify-center gap-2 transform hover:-translate-y-0.5"
                    @if ($isDowngrade) disabled @endif>
                    <span wire:loading.remove>Konfirmasi Pembayaran</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Sending...</span>
                </button>
            </form>
        </div>

    </div>
</div>