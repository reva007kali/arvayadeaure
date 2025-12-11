<div class="py-6 max-w-4xl mx-auto animate-fade-in-up">

    <div class="mb-8 text-center">
        <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Aktivasi Undangan</h2>
        <p class="text-[#9A7D4C] text-sm mt-1">Pilih paket dan lakukan pembayaran agar undangan bisa diakses tamu.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- KIRI: PILIH PAKET --}}
        <div class="space-y-4">
            @foreach ($packages as $key => $pkg)
                <label class="block cursor-pointer relative group">
                    <input type="radio" wire:model.live="selectedPackage" value="{{ $key }}"
                        class="peer sr-only">

                    <div
                        class="p-6 rounded-2xl border-2 transition-all duration-300
                        {{ $selectedPackage === $key
                            ? 'bg-white border-[#B89760] shadow-[0_4px_20px_rgba(184,151,96,0.2)]'
                            : 'bg-[#F9F7F2] border-transparent hover:border-[#E6D9B8]' }}">

                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-serif font-bold text-lg text-[#5E4926]">{{ $pkg['name'] }}</h3>
                            <span class="text-[#B89760] font-bold">Rp
                                {{ number_format($pkg['price'], 0, ',', '.') }}</span>
                        </div>

                        <ul class="text-xs text-[#7C6339] space-y-1">
                            @foreach ($pkg['features'] as $feat)
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-check text-green-600"></i>
                                    {{ ucwords(str_replace('_', ' ', $feat)) }}
                                </li>
                            @endforeach
                            @foreach ($pkg['limitations'] as $limit)
                                <li class="flex items-center gap-2 opacity-50">
                                    <i class="fa-solid fa-xmark text-red-400"></i>
                                    <del>{{ ucwords(str_replace('_', ' ', $limit)) }}</del>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Check Icon --}}
                        <div
                            class="absolute top-4 right-4 text-[#B89760] opacity-0 peer-checked:opacity-100 transition">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>

        {{-- KANAN: INSTRUKSI & UPLOAD --}}
        <div class="bg-white p-8 rounded-3xl border border-[#E6D9B8] shadow-sm">
            <h4 class="font-bold text-[#5E4926] mb-4 flex items-center gap-2">
                <i class="fa-solid fa-wallet text-[#B89760]"></i> Transfer Pembayaran
            </h4>

            <div class="bg-[#F9F7F2] p-4 rounded-xl border border-[#F2ECDC] mb-6">
                <p class="text-xs text-[#9A7D4C] uppercase font-bold mb-1">Bank BCA</p>
                <p class="font-mono text-xl font-bold text-[#5E4926] mb-1">123 456 7890</p>
                <p class="text-xs text-[#7C6339]">A.N PT Arvaya De Aure</p>
                <p class="mt-3 text-sm font-bold text-[#B89760]">
                    Total: Rp {{ number_format($packages[$selectedPackage]['price'], 0, ',', '.') }}
                </p>
            </div>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#7C6339] uppercase mb-2">Upload Bukti Transfer</label>
                    <div
                        class="border-2 border-dashed border-[#E6D9B8] rounded-xl p-6 text-center hover:bg-[#F9F7F2] transition relative">
                        <input type="file" wire:model="proofImage"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                        @if ($proofImage)
                            <img src="{{ $proofImage->temporaryUrl() }}"
                                class="h-32 mx-auto rounded-lg shadow-sm object-cover">
                        @else
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-[#E6D9B8] mb-2"></i>
                            <p class="text-xs text-[#9A7D4C]">Klik untuk upload (JPG/PNG)</p>
                        @endif
                    </div>
                    @error('proofImage')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-[#5E4926] text-white rounded-xl font-bold hover:bg-[#403013] transition shadow-lg flex justify-center gap-2">
                    <span wire:loading.remove>Konfirmasi Pembayaran</span>
                    <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Sending...</span>
                </button>
            </form>
        </div>

    </div>
</div>
