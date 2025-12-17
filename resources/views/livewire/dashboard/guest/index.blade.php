<div class="py-2 animate-fade-in-up dashboard-ui">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('dashboard.index') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Dashboard
                </a>
                <span>/</span>
                <span>Management</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Buku Tamu Eksklusif</h2>
            <p class="text-[#7C6339] text-sm mt-1">Undangan: <span
                    class="font-semibold italic">{{ $invitation->title }}</span></p>
        </div>

        {{-- Quick Stats (Ringkasan Kecil) --}}
        <div class="flex gap-3">
            <div class="bg-white border border-[#E6D9B8] px-4 py-2 rounded-xl shadow-sm text-center">
                <p class="text-[10px] text-[#9A7D4C] font-bold uppercase">Total</p>
                <p class="text-lg font-serif font-bold text-[#5E4926]">{{ $guests->total() }}</p>
            </div>
            <div class="bg-white border border-[#E6D9B8] px-4 py-2 rounded-xl shadow-sm text-center">
                <p class="text-[10px] text-[#9A7D4C] font-bold uppercase">Hadir</p>
                <p class="text-lg font-serif font-bold text-green-600">
                    {{ $invitation->guests()->where('rsvp_status', 1)->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT COLUMN: FORM INPUT --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.2)] border border-[#E6D9B8]/60 sticky top-24">
                <div class="flex items-center gap-3 mb-6 border-b border-[#F2ECDC] pb-4">
                    <div class="w-8 h-8 rounded-full bg-[#F2ECDC] flex items-center justify-center text-[#B89760]">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <h3 class="font-serif font-bold text-lg text-[#5E4926]">Tambah Tamu</h3>
                </div>

                <form wire:submit="save" class="space-y-5">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5">Nama
                            Tamu</label>
                        <input type="text" wire:model="name" placeholder="Contoh: Bpk. Budi & Keluarga"
                            class="w-full rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-[#B89760] text-sm transition shadow-sm">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5">WhatsApp
                            <span class="text-[#C6AC80] font-normal normal-case">(Opsional)</span></label>
                        <div class="relative">
                            <span
                                class="absolute hidden inset-y-0 left-0 pl-3 md:flex items-center pointer-events-none">
                                <i class="fa-brands fa-whatsapp text-green-500/60"></i>
                            </span>
                            <input type="number" wire:model="phone" placeholder="0812..."
                                class="w-full pl-9 rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] placeholder-[#C6AC80] focus:border-[#B89760] focus:ring-[#B89760] text-sm transition shadow-sm">
                        </div>
                        <p class="text-[10px] text-[#9A7D4C] mt-1.5 italic">*Nomor HP diperlukan untuk fitur kirim
                            undangan otomatis.</p>
                        <div x-data="{
                            async pickContacts() {
                                if (!('contacts' in navigator && 'select' in navigator.contacts)) { alert('Browser belum mendukung impor kontak.'); return }
                                try {
                                    const selected = await navigator.contacts.select(['name', 'tel'], { multiple: true });
                                    const out = [];
                                    for (const c of selected) {
                                        const name = Array.isArray(c.name) ? (c.name[0] || '') : (c.name || '');
                                        const tel = Array.isArray(c.tel) ? (c.tel[0] || '') : (c.tel || '');
                                        if (name && tel) out.push({ name, phone: tel });
                                    }
                                    if (out.length) { $wire.importContacts(out) }
                                } catch (e) {}
                            }
                        }" class="mt-3">
                            <button type="button" x-on:click="pickContacts()"
                                class="w-full py-2 bg-white border border-[#E6D9B8] text-[#7C6339] rounded-lg text-xs font-bold hover:bg-[#F2ECDC] transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-address-book"></i> Import dari Kontak
                            </button>
                            <p class="text-[10px] text-[#9A7D4C] mt-1">Hanya didukung di browser yang kompatibel.</p>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            class="block text-xs font-bold text-[#7C6339] uppercase tracking-wider mb-1.5">Kategori</label>
                        <div class="relative">
                            <select wire:model="category"
                                class="w-full appearance-none rounded-lg bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760] text-sm transition shadow-sm">
                                <option value="Keluarga">Keluarga</option>
                                <option value="Teman Kantor">Teman Kantor</option>
                                <option value="Teman Sekolah">Teman Sekolah</option>
                                <option value="VIP">VIP</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#9A7D4C]">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                        class="w-full py-3 bg-[#5E4926] text-white rounded-lg text-sm font-bold hover:bg-[#403013] transition shadow-lg shadow-[#5E4926]/20 flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-plus group-hover:rotate-90 transition duration-300"></i> Simpan Data
                    </button>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN: GUEST LIST --}}
        <div class="lg:col-span-2">
            <div
                class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(230,217,184,0.2)] border border-[#E6D9B8]/60 overflow-hidden flex flex-col h-full">

                {{-- Toolbar (Search) --}}
                <div
                    class="p-5 border-b border-[#F2ECDC] bg-[#F9F7F2]/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="font-serif font-bold text-lg text-[#5E4926]">Daftar Tamu</h3>

                    <div class="w-full sm:w-64">
                        <div
                            class="flex items-center gap-3 rounded-full bg-white border border-[#E6D9B8] px-3 py-2 focus-within:border-[#B89760] focus-within:ring-1 focus-within:ring-[#B89760]">
                            <i class="fa-solid fa-magnifying-glass text-[#B89760] text-xs"></i>
                            <input type="text" wire:model.live="search" placeholder="Cari nama tamu..."
                                class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-xs text-[#5E4926]">
                            <span wire:loading wire:target="search" class="text-[#B89760]">
                                <i class="fa-solid fa-circle-notch fa-spin text-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#F2ECDC] text-[#7C6339] font-bold text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-lg">Informasi Tamu</th>
                                <th class="px-6 py-4 text-center">Status RSVP</th>
                                <th class="px-6 py-4">Link & Undangan</th>
                                <th class="px-6 py-4 text-right rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2ECDC]">
                            @forelse($guests as $guest)
                                <tr class="hover:bg-[#F9F7F2] transition duration-150 group">
                                    {{-- Kolom Nama --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full hidden bg-[#E6D9B8] text-[#5E4926] font-serif font-bold md:flex items-center justify-center text-xs shrink-0">
                                                {{ substr($guest->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#5E4926] text-sm">{{ $guest->name }}</p>
                                                <span
                                                    class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-[#E6D9B8]/30 text-[#7C6339] border border-[#E6D9B8]">
                                                    {{ $guest->category }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom RSVP --}}
                                    <td class="px-6 py-4 text-center">
                                        @if ($guest->rsvp_status == 1)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                                <i class="fa-solid fa-circle-check"></i> Hadir ({{ $guest->pax }})
                                            </span>
                                        @elseif($guest->rsvp_status == 2)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">
                                                <i class="fa-solid fa-circle-xmark"></i> Tidak
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-gray-50 text-gray-500 border border-gray-200">
                                                <i class="fa-regular fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Action Share --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $link = route('invitation.show', [
                                                'slug' => $invitation->slug,
                                                'to' => $guest->slug,
                                            ]);

                                            $msg = "Kepada Yth. {$guest->name},\n\n";
                                            $msg .=
                                                "Tanpa mengurangi rasa hormat, kami bermaksud mengundang Anda untuk hadir di acara pernikahan kami.\n\n";
                                            $msg .= "Info lengkap & RSVP:\n{$link}\n\n";
                                            $msg .=
                                                "Merupakan suatu kehormatan bagi kami apabila Anda berkenan hadir.\nTerima kasih.";

                                            $waUrl = "https://wa.me/{$guest->phone}?text=" . urlencode($msg);
                                        @endphp

                                        <div class="flex items-center gap-2">
                                            {{-- WA Button --}}
                                            @if ($guest->phone)
                                                <a href="{{ $waUrl }}" target="_blank"
                                                    class="bg-[#25D366] hover:bg-[#20bd5a] text-white px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                                    <i class="fa-brands fa-whatsapp text-sm"></i> <span
                                                        class="hidden sm:inline">Kirim</span>
                                                </a>
                                            @else
                                                <button disabled
                                                    class="bg-gray-100 text-gray-400 px-3 py-1.5 rounded-lg text-xs font-bold cursor-not-allowed border border-gray-200">
                                                    <i class="fa-brands fa-whatsapp"></i>
                                                </button>
                                            @endif

                                            {{-- Copy Button --}}
                                            <button
                                                onclick="navigator.clipboard.writeText('{{ $link }}'); alert('Link tersalin!');"
                                                class="bg-white border border-[#E6D9B8] text-[#7C6339] hover:bg-[#F9F7F2] hover:text-[#B89760] px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5"
                                                title="Copy Link">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Kolom Hapus --}}
                                    <td class="px-6 py-4 text-right">
                                        <button wire:click="delete({{ $guest->id }})"
                                            wire:confirm="Hapus tamu ini?"
                                            class="w-8 h-8 rounded-full bg-white border border-red-100 text-red-400 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition flex items-center justify-center shadow-sm"
                                            title="Hapus Data">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-[#F9F7F2] rounded-full flex items-center justify-center mb-3 text-[#E6D9B8]">
                                                <i class="fa-solid fa-user-group text-2xl"></i>
                                            </div>
                                            <h4 class="font-serif font-bold text-[#5E4926] text-lg">Belum ada tamu</h4>
                                            <p class="text-[#9A7D4C] text-xs max-w-xs mt-1">
                                                Mulai tambahkan daftar undangan Anda melalui formulir di sebelah kiri.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="p-4 border-t border-[#F2ECDC] bg-[#F9F7F2]/30">
                    {{ $guests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
