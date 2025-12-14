<div class="p-8 shadow-[0_10px_40px_-10px_rgba(184,151,96,0.2)] relative overflow-hidden">
    
    <h3 class="font-serif text-3xl font-bold theme-text mb-1 text-center">Konfirmasi Kehadiran</h3>
    <p class="text-center text-[#9A7D4C] text-[10px] font-bold uppercase tracking-[0.2em] mb-8">RSVP Form</p>

    @if ($isSubmitted)
        <div class="text-center py-8 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#F9F7F2] border border-[#E6D9B8] rounded-full mb-6 relative">
                <div class="absolute inset-0 rounded-full border border-[#B89760] animate-ping opacity-20"></div>
                <i class="fa-solid fa-check text-3xl text-[#B89760]"></i>
            </div>
            <h4 class="text-xl font-serif font-bold text-[#5E4926] mb-2">Terima Kasih!</h4>
            <p class="text-[#7C6339] text-sm max-w-xs mx-auto leading-relaxed">
                Konfirmasi kehadiran Anda telah kami catat. Kami menantikan kehadiran Anda di hari bahagia kami.
            </p>
            <button wire:click="$set('isSubmitted', false)" 
                class="mt-6 text-xs font-bold text-[#B89760] hover:text-[#5E4926] uppercase tracking-wider border-b border-[#B89760] pb-0.5 hover:border-[#5E4926] transition">
                Ubah Data Konfirmasi
            </button>
        </div>
    @else
        <form wire:submit="save" class="space-y-5 text-left relative z-10">
            {{-- Nama --}}
            <div>
                <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">Nama Tamu</label>
                <div class="relative">
                    <input type="text" wire:model="name"
                        class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium"
                        {{ $guest ? 'readonly' : '' }} placeholder="Nama Lengkap">
                    
                    @if ($guest)
                        <div class="absolute right-3 top-3.5 text-[#B89760]" title="Tamu Terundang">
                            <i class="fa-solid fa-envelope-circle-check text-lg"></i>
                        </div>
                    @endif
                </div>
                @if ($guest)
                    <p class="text-[10px] text-[#9A7D4C] mt-1.5 ml-1 flex items-center gap-1">
                        <i class="fa-solid fa-lock text-[8px]"></i> Nama sesuai undangan khusus
                    </p>
                @endif
            </div>

            {{-- WhatsApp --}}
            <div>
                <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">Nomor WhatsApp <span class="text-[#C6AC80] font-normal normal-case">(Opsional)</span></label>
                <input type="number" wire:model="phone"
                    class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium">
            </div>

            {{-- Jumlah Pax --}}
            <div>
                <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5 ml-1">Jumlah Hadir</label>
                <div class="relative">
                    <select wire:model="pax" class="w-full px-4 py-3 rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] transition-all text-sm font-medium appearance-none">
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} Orang</option>
                        @endfor
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#9A7D4C]">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Radio Buttons --}}
            <div>
                <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-3 ml-1">Konfirmasi Kehadiran</label>
                <div class="grid grid-cols-2 gap-4">
                    {{-- Hadir --}}
                    <label class="cursor-pointer relative">
                        <input type="radio" wire:model="rsvp_status" value="1" class="peer sr-only">
                        <div class="p-3 rounded-xl border border-[#E6D9B8] bg-white text-center transition-all peer-checked:bg-[#5E4926] peer-checked:text-white peer-checked:border-[#5E4926] hover:bg-[#F9F7F2]">
                            <i class="fa-solid fa-circle-check mb-1 block text-lg"></i>
                            <span class="text-sm font-bold">Hadir</span>
                        </div>
                    </label>

                    {{-- Tidak Hadir --}}
                    <label class="cursor-pointer relative">
                        <input type="radio" wire:model="rsvp_status" value="2" class="peer sr-only">
                        <div class="p-3 rounded-xl border border-[#E6D9B8] bg-white text-center transition-all peer-checked:bg-[#9A7D4C] peer-checked:text-white peer-checked:border-[#9A7D4C] hover:bg-[#F9F7F2]">
                            <i class="fa-solid fa-circle-xmark mb-1 block text-lg"></i>
                            <span class="text-sm font-bold">Berhalangan</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                class="w-full py-3.5 theme-bg text-white font-bold rounded-xl hover:shadow-lg hover:shadow-[#B89760]/40 transition transform hover:-translate-y-0.5 mt-2 text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                <span wire:loading.remove>Kirim Konfirmasi</span>
                <span wire:loading><i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...</span>
            </button>
        </form>
    @endif
</div>