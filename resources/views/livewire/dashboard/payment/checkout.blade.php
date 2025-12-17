<div class="py-6 max-w-4xl mx-auto animate-fade-in-up dashboard-ui">

    <div class="mb-10 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Selesaikan Pembayaran</h2>
        <p class="text-[#9A7D4C] text-sm mt-1">Satu langkah lagi untuk mengaktifkan undanganmu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- LEFT: INVOICE DETAILS --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-[#E6D9B8] shadow-sm relative overflow-hidden">
                {{-- Decorative Stamp --}}
                <div
                    class="absolute top-0 right-0 bg-[#F9F7F2] px-4 py-2 rounded-bl-2xl border-b border-l border-[#E6D9B8] text-[#B89760] font-bold text-xs uppercase tracking-wider">
                    Invoice
                </div>

                <h3 class="font-serif font-bold text-xl text-[#5E4926] mb-6">Detail Pesanan</h3>

                <div class="flex gap-4 mb-6">
                    <div
                        class="w-16 h-16 bg-[#E6D9B8] rounded-xl flex items-center justify-center text-white text-2xl shadow-inner">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <div>
                        <p class="text-xs text-[#9A7D4C] uppercase font-bold">Template Pilihan</p>
                        <h4 class="font-bold text-lg text-[#5E4926]">{{ $templateName }}</h4>
                        <span
                            class="inline-block bg-[#2D2418] text-[#B89760] text-[10px] px-2 py-0.5 rounded uppercase tracking-wider font-bold mt-1">
                            {{ ucfirst($templateTier) }} Tier
                        </span>
                    </div>
                </div>

                <div class="bg-[#F9F7F2] p-4 rounded-xl mb-6">
                    <p class="text-xs font-bold text-[#7C6339] mb-2 uppercase">Fitur Termasuk:</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach ($features as $feat)
                            <div class="flex items-center gap-2 text-xs text-[#5E4926]">
                                <i class="fa-solid fa-check text-green-600"></i>
                                {{ ucwords(str_replace('_', ' ', $feat)) }}
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($isUpgrade)
                    <div class="space-y-2 border-t border-dashed border-[#E6D9B8] pt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#7C6339]">Harga Template Baru</span>
                            <span class="font-bold text-[#5E4926]">Rp
                                {{ number_format($templatePrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-[#7C6339]">Pembayaran Sebelumnya</span>
                            <span class="font-bold text-[#5E4926]">Rp
                                {{ number_format($templatePrice - $payableAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-end mt-2">
                            <span class="text-sm font-bold text-[#7C6339]">Selisih yang Harus Dibayar</span>
                            <span class="font-sans font-bold text-3xl text-[#B89760]">Rp
                                {{ number_format($payableAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="flex justify-between items-end border-t border-dashed border-[#E6D9B8] pt-4">
                        <span class="text-sm font-bold text-[#7C6339]">Total Tagihan</span>
                        <span class="font-sans font-bold text-3xl text-[#B89760]">Rp
                            {{ number_format($templatePrice, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            <a href="{{ route('dashboard.invitation.edit', $invitation->id) }}"
                class="flex items-center justify-center gap-2 text-sm text-[#9A7D4C] hover:text-[#5E4926] transition">
                <i class="fa-solid fa-arrow-left"></i> Ganti Template
            </a>
        </div>

        {{-- RIGHT: PAYMENT --}}
        <div class="bg-[#2D2418] p-8 rounded-3xl text-[#E6D9B8] shadow-xl relative h-fit">
            <h4 class="font-bold text-white mb-6 flex items-center gap-2 text-lg">
                <i class="fa-solid fa-wallet text-[#B89760]"></i> Metode Transfer
            </h4>

            <div class="bg-white/5 p-5 rounded-2xl border border-white/10 mb-8 backdrop-blur-sm">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[10px] text-[#9A7D4C] uppercase font-bold">Bank Transfer</p>
                    <button onclick="navigator.clipboard.writeText('0561621828'); alert('Tersalin!')"
                        class="text-xs text-[#B89760] hover:text-white transition cursor-pointer"><i
                            class="fa-regular fa-copy"></i> Salin</button>
                </div>
                <div class="flex items-center gap-3 mb-1">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                        class="h-8 p-1 bg-white rounded px-1">
                    <p class="font-mono text-2xl font-bold text-white tracking-wider">0561621828</p>
                </div>
                <p class="text-xs text-[#E6D9B8]/80">A.N Revaldy Adhityawiguna Sahabu</p>
            </div>

            @if ($isDowngrade)
                <div class="p-4 bg-white/5 border border-white/10 rounded-xl text-sm">
                    <p class="text-[#E6D9B8]">Anda mengubah ke template yang lebih murah. Tidak perlu membayar. Admin
                        akan memproses refund sebesar <span class="font-bold text-[#B89760]">Rp
                            {{ number_format($invitation->refund_amount, 0, ',', '.') }}</span>.</p>
                </div>
            @endif

            <form wire:submit="save" class="space-y-6"
                @if ($isDowngrade) x-data x-init="$el.querySelector('button[type=submit]').disabled = true" @endif>
                <div>
                    <label class="block text-xs font-bold text-[#E6D9B8] uppercase mb-2">Upload Bukti Transfer</label>
                    <div class="relative w-full">
                        <input type="file" wire:model="proofImage" id="file-upload" class="hidden" />
                        <label for="file-upload"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer transition-all duration-300
                            {{ $proofImage ? 'border-green-500/50 bg-green-500/10' : 'border-[#E6D9B8]/30 hover:bg-white/5 hover:border-[#B89760]' }}">

                            @if ($proofImage)
                                <div class="text-green-400 flex flex-col items-center">
                                    <i class="fa-solid fa-circle-check text-3xl mb-2"></i>
                                    <span class="text-xs font-bold">File Diupload, Konfirmasi Pembayaran</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center text-[#9A7D4C]">
                                    <i class="fa-solid fa-camera text-2xl mb-2"></i>
                                    <p class="text-xs">Upload Foto</p>
                                </div>
                            @endif
                        </label>
                    </div>
                    @error('proofImage')
                        <span class="text-red-400 text-xs mt-2 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-[#B89760] text-white rounded-xl font-bold hover:bg-[#9A7D4C] transition shadow-lg shadow-[#B89760]/20 flex justify-center gap-2 transform hover:-translate-y-0.5"
                    @if ($isDowngrade) disabled @endif>
                    <span wire:loading.remove>Konfirmasi Pembayaran</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Sending...</span>
                </button>
            </form>
        </div>

    </div>
</div>
