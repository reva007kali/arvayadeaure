<div class="flex justify-between items-center mb-6">
    <h4 class="font-bold text-[#E0E0E0]">Daftar Acara</h4>
    <button wire:click="addEvent"
        class="bg-[#D4AF37] text-[#121212] text-xs px-5 py-2.5 rounded-xl font-bold hover:bg-[#B4912F] hover:shadow-lg transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Acara
    </button>
</div>

<div class="space-y-6">
    @foreach ($events as $index => $event)
        <div
            class="bg-[#1a1a1a] p-5 rounded-3xl border border-[#333333] relative shadow-sm hover:shadow-md transition-shadow group">
            <div class="absolute top-0 right-0 p-4">
                <button wire:click="removeEvent({{ $index }})"
                    class="w-8 h-8 rounded-full bg-[#252525] text-[#888] hover:bg-red-900/20 hover:text-red-500 transition flex items-center justify-center">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>

            <div class="flex items-center gap-3 mb-4">
                <span
                    class="bg-[#2d2d2d] text-[#D4AF37] w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm">{{ $loop->iteration }}</span>
                <span
                    class="font-bold text-[#E0E0E0] text-lg">{{ $event['title'] ?: 'Acara Baru' }}</span>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Nama
                        Acara</label>
                    <input type="text" wire:model="events.{{ $index }}.title"
                        placeholder="Contoh: Akad Nikah"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                </div>
                <div>
                    <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Waktu
                        & Tanggal</label>
                    <div class="flex gap-2">
                        <input type="datetime-local" wire:model="events.{{ $index }}.date"
                            class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                        <select wire:model="events.{{ $index }}.timezone"
                            class="w-24 rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all font-bold">
                            <option value="WIB">WIB</option>
                            <option value="WITA">WITA</option>
                            <option value="WIT">WIT</option>
                        </select>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Nama
                        Lokasi (Gedung/Hotel/Rumah)</label>
                    <input type="text" wire:model="events.{{ $index }}.location"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Alamat
                        Lengkap</label>
                    <textarea wire:model="events.{{ $index }}.address" rows="5"
                        class="w-full rounded-xl bg-[#252525] border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] text-[#E0E0E0] transition-all"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-[#A0A0A0] uppercase mb-1 block">Link
                        Google Maps</label>
                    <div
                        class="relative flex items-center gap-x-2 bg-[#252525] rounded border border-[#333333] focus:bg-[#2d2d2d] focus:border-[#D4AF37] focus:ring-[#D4AF37] transition-all">
                        <span class="text-[#D4AF37]"><i class="fa-solid fa-map-location-dot"></i></span>
                        <input type="text" wire:model="events.{{ $index }}.map_link"
                            class="w-fullrounded-xl border-none bg-transparent text-[#E0E0E0]">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
