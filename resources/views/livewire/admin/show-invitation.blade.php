<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- HEADER HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#A0A0A0] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('admin.invitations') }}"
                    class="hover:text-[#D4AF37] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <span>/</span>
                <span>Super Admin View</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Inspeksi & Edit Project</h2>
            <div class="flex items-center gap-2 text-[#A0A0A0] text-sm mt-1">
                <span>Owner: <b class="text-[#D4AF37]">{{ $invitation->user->name }}</b></span>
                <span>•</span>
                <span>{{ $invitation->user->email }}</span>
            </div>
        </div>

        <div class="flex gap-3">
            {{-- Quick Status Toggle --}}
            <button wire:click="toggleStatus"
                class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wide border transition shadow-sm flex items-center gap-2
                {{ $invitation->is_active ? 'bg-green-900/20 text-green-500 border-green-900/30 hover:bg-green-900/30' : 'bg-[#252525] text-[#888] border-[#333] hover:bg-[#333]' }}">
                <i class="fa-solid fa-power-off"></i>
                {{ $invitation->is_active ? 'Website ON' : 'Website OFF' }}
            </button>

            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-5 py-2 bg-[#D4AF37] text-[#121212] rounded-xl hover:bg-[#B4912F] transition font-bold text-xs uppercase tracking-wide flex items-center gap-2 shadow-lg shadow-[#D4AF37]/30">
                <i class="fa-solid fa-external-link-alt"></i> Buka Website
            </a>
        </div>
    </div>

    {{-- 1. INFO CARD & CONFIG --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Card: Status & Finance --}}
        <div class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-lg relative overflow-hidden">
            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4">Status & Paket</h3>

            <div class="space-y-4 relative z-10">
                <div class="flex justify-between items-center border-b border-[#333333] pb-2">
                    <span class="text-xs text-[#A0A0A0] uppercase font-bold">Tipe Paket</span>
                    <span
                        class="text-sm font-bold text-[#D4AF37] uppercase bg-[#252525] px-2 py-1 rounded">{{ $invitation->package_type }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#333333] pb-2">
                    <span class="text-xs text-[#A0A0A0] uppercase font-bold">Total Tagihan</span>
                    <span class="text-sm font-mono text-[#E0E0E0]">Rp
                        {{ number_format($invitation->amount, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-xs text-[#A0A0A0] uppercase font-bold block mb-2">Status Pembayaran</span>
                    <div class="flex gap-2">
                        <button wire:click="updatePaymentStatus('paid')"
                            class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'paid' ? 'bg-green-600 text-white border-green-600' : 'text-[#666] border-[#333] hover:border-green-500 hover:text-green-500' }}">Paid</button>
                        <button wire:click="updatePaymentStatus('pending')"
                            class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'text-[#666] border-[#333] hover:border-yellow-500 hover:text-yellow-500' }}">Pending</button>
                        <button wire:click="updatePaymentStatus('unpaid')"
                            class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'unpaid' ? 'bg-[#333] text-white border-[#333]' : 'text-[#666] border-[#333] hover:border-[#666] hover:text-[#888]' }}">Unpaid</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Theme & Music --}}
        <div class="bg-[#1a1a1a] p-6 rounded-3xl border border-[#333333] shadow-lg">
            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] mb-4">Tema & Musik</h3>

            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    {{-- Thumbnail Template --}}
                    <div class="w-16 h-24 bg-[#252525] rounded-lg overflow-hidden border border-[#333333]">
                        @if($templateInfo && $templateInfo->thumbnail)
                            <img src="{{ asset('storage/' . $templateInfo->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-[#666]">No Img</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-[#A0A0A0] uppercase font-bold">Template</p>
                        <p class="font-bold text-[#E0E0E0]">
                            {{ $templateInfo->name ?? ucfirst($invitation->theme_template) }}</p>

                        <p class="text-xs text-[#A0A0A0] uppercase font-bold mt-2">Warna Aksen</p>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full border border-[#444]"
                                style="background-color: {{ $invitation->theme_config['primary_color'] ?? '#000' }}">
                            </div>
                            <span
                                class="text-xs font-mono text-[#E0E0E0]">{{ $invitation->theme_config['primary_color'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-xs text-[#A0A0A0] uppercase font-bold block mb-1">Musik Latar</label>
                    @if(!empty($invitation->theme_config['music_url']))
                        <div class="flex items-center gap-2 bg-[#252525] p-2 rounded-lg border border-[#333333]">
                            <i class="fa-brands fa-youtube text-red-500"></i>
                            <a href="{{ $invitation->theme_config['music_url'] }}" target="_blank"
                                class="text-xs text-blue-400 truncate hover:underline flex-1">
                                {{ $invitation->theme_config['music_url'] }}
                            </a>
                        </div>
                    @else
                        <span class="text-xs text-[#666] italic">Tidak ada musik.</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card: Raw Edit Trigger --}}
        <div
            class="bg-[#252525] p-6 rounded-3xl shadow-lg flex flex-col justify-center items-center text-center relative overflow-hidden group border border-[#333333]">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5">
            </div>
            <i class="fa-solid fa-database text-4xl text-[#D4AF37] mb-3 group-hover:scale-110 transition"></i>
            <h3 class="font-serif font-bold text-lg text-[#E0E0E0] relative z-10">Developer Mode</h3>
            <p class="text-[#A0A0A0] text-xs mb-4 max-w-xs relative z-10">Edit raw JSON data jika terjadi error format
                atau kebutuhan custom mendesak.</p>
            <a href="#raw-editor"
                class="px-4 py-2 bg-[#D4AF37] text-[#121212] rounded-lg text-xs font-bold uppercase hover:bg-[#B4912F] transition relative z-10 shadow-lg">
                Scroll ke Editor <i class="fa-solid fa-arrow-down ml-1"></i>
            </a>
        </div>
    </div>

    {{-- 2. ASSET GALERI (READ ONLY / DOWNLOADABLE) --}}
    @php
        $gallery = $invitation->gallery_data ?? [];
        $moments = $gallery['moments'] ?? [];
        if (isset($gallery[0])) {
            $moments = $gallery;
            $gallery['cover'] = null;
            $gallery['groom'] = null;
            $gallery['bride'] = null;
        }
    @endphp

    <div class="bg-[#1a1a1a] rounded-3xl shadow-lg border border-[#333333] overflow-hidden mb-8">
        <div class="p-6 border-b border-[#333333] bg-[#252525] flex justify-between items-center">
            <h3 class="font-serif font-bold text-xl text-[#E0E0E0]"><i
                    class="fa-solid fa-images text-[#D4AF37] mr-2"></i> Aset Galeri</h3>
            <span class="text-xs font-bold text-[#A0A0A0] uppercase">Cover, Profil & Momen</span>
        </div>
        <div class="p-8">
            {{-- Main Photos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach(['cover' => 'Sampul', 'groom' => 'Pria', 'bride' => 'Wanita'] as $key => $label)
                    @if(!empty($gallery[$key]))
                        <div
                            class="group relative rounded-xl overflow-hidden border border-[#333333] bg-[#252525] aspect-square shadow-sm">
                            <img src="{{ asset($gallery[$key]) }}" class="w-full h-full object-cover">
                            <span
                                class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded uppercase backdrop-blur-sm">{{ $label }}</span>
                            <div
                                class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 backdrop-blur-sm">
                                <a href="{{ asset($gallery[$key]) }}" target="_blank"
                                    class="p-2 bg-white text-[#121212] rounded-full hover:bg-[#D4AF37] hover:text-[#121212]"><i
                                        class="fa-solid fa-eye"></i></a>
                                <a href="{{ asset($gallery[$key]) }}" download
                                    class="p-2 bg-[#D4AF37] text-[#121212] rounded-full hover:bg-[#B4912F]"><i
                                        class="fa-solid fa-download"></i></a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Moments --}}
            @if(count($moments) > 0)
                <p
                    class="text-xs font-bold text-[#A0A0A0] uppercase mb-3 border-b border-dashed border-[#333333] pb-1 inline-block">
                    Galeri Momen ({{ count($moments) }})</p>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                    @foreach($moments as $path)
                        @if(is_string($path))
                            <div
                                class="group relative rounded-lg overflow-hidden border border-[#333333] aspect-square shadow-sm bg-[#252525]">
                                <img src="{{ asset($path) }}" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                    <a href="{{ asset($path) }}" download class="text-white hover:text-[#D4AF37]"><i
                                            class="fa-solid fa-download"></i></a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- 3. GUEST LIST (READ ONLY TABLE) --}}
    <div class="bg-[#1a1a1a] rounded-3xl shadow-lg border border-[#333333] overflow-hidden mb-8">
        <div class="p-6 border-b border-[#333333] flex justify-between items-center bg-[#252525]">
            <h3 class="font-serif font-bold text-xl text-[#E0E0E0]"><i
                    class="fa-solid fa-users text-[#D4AF37] mr-2"></i> Daftar Tamu</h3>
            <div class="relative w-48">
                <input type="text" wire:model.live.debounce.300ms="searchGuest" placeholder="Cari tamu..."
                    class="w-full pl-8 pr-3 py-1 text-xs rounded-full bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37] placeholder-[#666]">
                <i class="fa-solid fa-search absolute left-3 top-1.5 text-[#666] text-xs"></i>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#252525] text-[#D4AF37] font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Status RSVP</th>
                        <th class="px-6 py-3">Link</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#333333]">
                    @forelse($guests as $guest)
                        <tr class="hover:bg-[#252525]">
                            <td class="px-6 py-3 font-bold text-[#E0E0E0]">{{ $guest->name }}</td>
                            <td class="px-6 py-3 text-[#A0A0A0] text-xs">{{ $guest->category }}</td>
                            <td class="px-6 py-3">
                                @if($guest->rsvp_status == 1) <span class="text-green-500 text-xs font-bold">Hadir
                                    ({{ $guest->pax }})</span>
                                @elseif($guest->rsvp_status == 2) <span class="text-red-500 text-xs">Tidak Hadir</span>
                                @else <span class="text-[#666] text-xs">Belum Konfirmasi</span> @endif
                            </td>
                            <td class="px-6 py-3 font-mono text-xs text-[#A0A0A0]">{{ $guest->slug }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-[#666]">Belum ada data tamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#333333]">{{ $guests->links() }}</div>
    </div>

    {{-- 4. RAW JSON EDITOR (GOD MODE) --}}
    <div id="raw-editor" class="bg-[#1a1a1a] rounded-3xl shadow-2xl border border-[#D4AF37] overflow-hidden"
        x-data="{ openEditor: false }">
        <div @click="openEditor = !openEditor"
            class="p-6 cursor-pointer flex justify-between items-center hover:bg-[#252525] transition bg-[#252525]">
            <div>
                <h3 class="font-mono font-bold text-[#D4AF37] flex items-center gap-3 text-lg">
                    <i class="fa-solid fa-code"></i> RAW DATA EDITOR
                </h3>
                <p class="text-[#A0A0A0] text-xs mt-1">Mode pengembang untuk mengedit data JSON secara langsung.
                    Hati-hati!</p>
            </div>
            <i class="fa-solid text-[#D4AF37] text-xl" :class="openEditor ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </div>

        <div x-show="openEditor" class="p-8 border-t border-[#333333] bg-black/50 space-y-8" x-transition>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Couple Editor --}}
                <div>
                    <label class="text-[#D4AF37] text-xs font-bold block mb-2 uppercase tracking-wider">Couple Data
                        (JSON)</label>
                    <textarea wire:model="jsonCouple"
                        class="w-full h-64 bg-[#121212] text-green-400 font-mono text-xs p-4 rounded-xl border border-[#333333] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Events Editor --}}
                <div>
                    <label class="text-[#D4AF37] text-xs font-bold block mb-2 uppercase tracking-wider">Events Data
                        (JSON)</label>
                    <textarea wire:model="jsonEvents"
                        class="w-full h-64 bg-[#121212] text-blue-400 font-mono text-xs p-4 rounded-xl border border-[#333333] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Gifts Editor --}}
                <div>
                    <label class="text-[#D4AF37] text-xs font-bold block mb-2 uppercase tracking-wider">Gifts Data
                        (JSON)</label>
                    <textarea wire:model="jsonGifts"
                        class="w-full h-64 bg-[#121212] text-yellow-400 font-mono text-xs p-4 rounded-xl border border-[#333333] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Theme Config Editor --}}
                <div>
                    <label class="text-[#D4AF37] text-xs font-bold block mb-2 uppercase tracking-wider">Theme Config
                        (JSON)</label>
                    <textarea wire:model="jsonTheme"
                        class="w-full h-64 bg-[#121212] text-purple-400 font-mono text-xs p-4 rounded-xl border border-[#333333] focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-[#333333]">
                <button wire:click="saveJsonData"
                    wire:confirm="Yakin ingin menyimpan perubahan RAW data? Kesalahan format JSON dapat merusak tampilan undangan."
                    class="px-8 py-3 bg-red-600 text-white rounded-xl font-bold uppercase tracking-wider hover:bg-red-700 transition shadow-lg shadow-red-900/50 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Paksa
                </button>
            </div>

        </div>
    </div>

</div>