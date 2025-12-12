<div class="py-2 animate-fade-in-up">
    
    {{-- HEADER HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('admin.invitations') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <span>/</span>
                <span>Super Admin View</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Inspeksi & Edit Project</h2>
            <div class="flex items-center gap-2 text-[#7C6339] text-sm mt-1">
                <span>Owner: <b>{{ $invitation->user->name }}</b></span>
                <span>•</span>
                <span>{{ $invitation->user->email }}</span>
            </div>
        </div>

        <div class="flex gap-3">
            {{-- Quick Status Toggle --}}
            <button wire:click="toggleStatus" 
                class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wide border transition shadow-sm flex items-center gap-2
                {{ $invitation->is_active ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-gray-50 text-gray-500 border-gray-200 hover:bg-gray-100' }}">
                <i class="fa-solid fa-power-off"></i>
                {{ $invitation->is_active ? 'Website ON' : 'Website OFF' }}
            </button>

            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-5 py-2 bg-[#B89760] text-white rounded-xl hover:bg-[#9A7D4C] transition font-bold text-xs uppercase tracking-wide flex items-center gap-2 shadow-lg shadow-[#B89760]/30">
                <i class="fa-solid fa-external-link-alt"></i> Buka Website
            </a>
        </div>
    </div>

    {{-- 1. INFO CARD & CONFIG --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        {{-- Card: Status & Finance --}}
        <div class="bg-white p-6 rounded-3xl border border-[#E6D9B8] shadow-sm relative overflow-hidden">
            <h3 class="font-serif font-bold text-lg text-[#5E4926] mb-4">Status & Paket</h3>
            
            <div class="space-y-4 relative z-10">
                <div class="flex justify-between items-center border-b border-[#F2ECDC] pb-2">
                    <span class="text-xs text-[#9A7D4C] uppercase font-bold">Tipe Paket</span>
                    <span class="text-sm font-bold text-[#5E4926] uppercase bg-[#F9F7F2] px-2 py-1 rounded">{{ $invitation->package_type }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#F2ECDC] pb-2">
                    <span class="text-xs text-[#9A7D4C] uppercase font-bold">Total Tagihan</span>
                    <span class="text-sm font-mono text-[#5E4926]">Rp {{ number_format($invitation->amount, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-xs text-[#9A7D4C] uppercase font-bold block mb-2">Status Pembayaran</span>
                    <div class="flex gap-2">
                        <button wire:click="updatePaymentStatus('paid')" class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'paid' ? 'bg-green-600 text-white border-green-600' : 'text-gray-400 border-gray-200 hover:border-green-400 hover:text-green-600' }}">Paid</button>
                        <button wire:click="updatePaymentStatus('pending')" class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'text-gray-400 border-gray-200 hover:border-yellow-400 hover:text-yellow-600' }}">Pending</button>
                        <button wire:click="updatePaymentStatus('unpaid')" class="flex-1 py-1.5 rounded text-[10px] font-bold uppercase transition border {{ $invitation->payment_status == 'unpaid' ? 'bg-gray-600 text-white border-gray-600' : 'text-gray-400 border-gray-200 hover:border-gray-400 hover:text-gray-600' }}">Unpaid</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Theme & Music --}}
        <div class="bg-white p-6 rounded-3xl border border-[#E6D9B8] shadow-sm">
            <h3 class="font-serif font-bold text-lg text-[#5E4926] mb-4">Tema & Musik</h3>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    {{-- Thumbnail Template --}}
                    <div class="w-16 h-24 bg-gray-200 rounded-lg overflow-hidden border border-[#E6D9B8]">
                        @if($templateInfo && $templateInfo->thumbnail)
                            <img src="{{ asset('storage/'.$templateInfo->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-[#9A7D4C] uppercase font-bold">Template</p>
                        <p class="font-bold text-[#5E4926]">{{ $templateInfo->name ?? ucfirst($invitation->theme_template) }}</p>
                        
                        <p class="text-xs text-[#9A7D4C] uppercase font-bold mt-2">Warna Aksen</p>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $invitation->theme_config['primary_color'] ?? '#000' }}"></div>
                            <span class="text-xs font-mono text-[#5E4926]">{{ $invitation->theme_config['primary_color'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-xs text-[#9A7D4C] uppercase font-bold block mb-1">Musik Latar</label>
                    @if(!empty($invitation->theme_config['music_url']))
                        <div class="flex items-center gap-2 bg-[#F9F7F2] p-2 rounded-lg border border-[#E6D9B8]">
                            <i class="fa-brands fa-youtube text-red-500"></i>
                            <a href="{{ $invitation->theme_config['music_url'] }}" target="_blank" class="text-xs text-blue-600 truncate hover:underline flex-1">
                                {{ $invitation->theme_config['music_url'] }}
                            </a>
                        </div>
                    @else
                        <span class="text-xs text-gray-400 italic">Tidak ada musik.</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card: Raw Edit Trigger --}}
        <div class="bg-[#2D2418] p-6 rounded-3xl shadow-lg flex flex-col justify-center items-center text-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <i class="fa-solid fa-database text-4xl text-[#B89760] mb-3 group-hover:scale-110 transition"></i>
            <h3 class="font-serif font-bold text-lg text-[#F9F7F2] relative z-10">Developer Mode</h3>
            <p class="text-[#9A7D4C] text-xs mb-4 max-w-xs relative z-10">Edit raw JSON data jika terjadi error format atau kebutuhan custom mendesak.</p>
            <a href="#raw-editor" class="px-4 py-2 bg-[#B89760] text-white rounded-lg text-xs font-bold uppercase hover:bg-[#9A7D4C] transition relative z-10">
                Scroll ke Editor <i class="fa-solid fa-arrow-down ml-1"></i>
            </a>
        </div>
    </div>

    {{-- 2. ASSET GALERI (READ ONLY / DOWNLOADABLE) --}}
    @php
        $gallery = $invitation->gallery_data ?? [];
        $moments = $gallery['moments'] ?? [];
        if (isset($gallery[0])) { $moments = $gallery; $gallery['cover'] = null; $gallery['groom'] = null; $gallery['bride'] = null; }
    @endphp

    <div class="bg-white rounded-3xl shadow-sm border border-[#E6D9B8] overflow-hidden mb-8">
        <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2]/50 flex justify-between items-center">
            <h3 class="font-serif font-bold text-xl text-[#5E4926]"><i class="fa-solid fa-images text-[#B89760] mr-2"></i> Aset Galeri</h3>
            <span class="text-xs font-bold text-[#9A7D4C] uppercase">Cover, Profil & Momen</span>
        </div>
        <div class="p-8">
            {{-- Main Photos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach(['cover' => 'Sampul', 'groom' => 'Pria', 'bride' => 'Wanita'] as $key => $label)
                    @if(!empty($gallery[$key]))
                        <div class="group relative rounded-xl overflow-hidden border border-[#E6D9B8] bg-gray-100 aspect-square shadow-sm">
                            <img src="{{ asset($gallery[$key]) }}" class="w-full h-full object-cover">
                            <span class="absolute top-2 left-2 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded uppercase backdrop-blur-sm">{{ $label }}</span>
                            <div class="absolute inset-0 bg-[#5E4926]/70 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 backdrop-blur-sm">
                                <a href="{{ asset($gallery[$key]) }}" target="_blank" class="p-2 bg-white text-[#5E4926] rounded-full hover:bg-[#B89760] hover:text-white"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ asset($gallery[$key]) }}" download class="p-2 bg-[#B89760] text-white rounded-full hover:bg-[#9A7D4C]"><i class="fa-solid fa-download"></i></a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            
            {{-- Moments --}}
            @if(count($moments) > 0)
                <p class="text-xs font-bold text-[#9A7D4C] uppercase mb-3 border-b border-dashed border-[#E6D9B8] pb-1 inline-block">Galeri Momen ({{ count($moments) }})</p>
                <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                    @foreach($moments as $path)
                        @if(is_string($path))
                            <div class="group relative rounded-lg overflow-hidden border border-[#E6D9B8] aspect-square shadow-sm">
                                <img src="{{ asset($path) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                    <a href="{{ asset($path) }}" download class="text-white hover:text-[#B89760]"><i class="fa-solid fa-download"></i></a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- 3. GUEST LIST (READ ONLY TABLE) --}}
    <div class="bg-white rounded-3xl shadow-sm border border-[#E6D9B8] overflow-hidden mb-8">
        <div class="p-6 border-b border-[#F2ECDC] flex justify-between items-center bg-[#F9F7F2]/50">
            <h3 class="font-serif font-bold text-xl text-[#5E4926]"><i class="fa-solid fa-users text-[#B89760] mr-2"></i> Daftar Tamu</h3>
            <div class="relative w-48">
                <input type="text" wire:model.live.debounce.300ms="searchGuest" placeholder="Cari tamu..." class="w-full pl-8 pr-3 py-1 text-xs rounded-full border border-[#E6D9B8] focus:border-[#B89760] focus:ring-[#B89760]">
                <i class="fa-solid fa-search absolute left-3 top-1.5 text-[#C6AC80] text-xs"></i>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F9F7F2] text-[#7C6339] font-bold text-xs uppercase tracking-wider">
                    <tr><th class="px-6 py-3">Nama</th><th class="px-6 py-3">Kategori</th><th class="px-6 py-3">Status RSVP</th><th class="px-6 py-3">Link</th></tr>
                </thead>
                <tbody class="divide-y divide-[#F2ECDC]">
                    @forelse($guests as $guest)
                        <tr class="hover:bg-[#F9F7F2]/50">
                            <td class="px-6 py-3 font-bold text-[#5E4926]">{{ $guest->name }}</td>
                            <td class="px-6 py-3 text-[#7C6339] text-xs">{{ $guest->category }}</td>
                            <td class="px-6 py-3">
                                @if($guest->rsvp_status == 1) <span class="text-green-600 text-xs font-bold">Hadir ({{ $guest->pax }})</span>
                                @elseif($guest->rsvp_status == 2) <span class="text-red-500 text-xs">Tidak Hadir</span>
                                @else <span class="text-gray-400 text-xs">Belum Konfirmasi</span> @endif
                            </td>
                            <td class="px-6 py-3 font-mono text-xs text-[#9A7D4C]">{{ $guest->slug }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-[#9A7D4C]">Belum ada data tamu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#F2ECDC]">{{ $guests->links() }}</div>
    </div>

    {{-- 4. RAW JSON EDITOR (GOD MODE) --}}
    <div id="raw-editor" class="bg-[#2D2418] rounded-3xl shadow-2xl border border-[#5E4926] overflow-hidden" x-data="{ openEditor: false }">
        <div @click="openEditor = !openEditor" class="p-6 cursor-pointer flex justify-between items-center hover:bg-white/5 transition">
            <div>
                <h3 class="font-mono font-bold text-[#E6D9B8] flex items-center gap-3 text-lg">
                    <i class="fa-solid fa-code"></i> RAW DATA EDITOR
                </h3>
                <p class="text-[#9A7D4C] text-xs mt-1">Mode pengembang untuk mengedit data JSON secara langsung. Hati-hati!</p>
            </div>
            <i class="fa-solid text-[#E6D9B8] text-xl" :class="openEditor ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </div>
        
        <div x-show="openEditor" class="p-8 border-t border-[#5E4926] bg-black/30 space-y-8" x-transition>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Couple Editor --}}
                <div>
                    <label class="text-[#E6D9B8] text-xs font-bold block mb-2 uppercase tracking-wider">Couple Data (JSON)</label>
                    <textarea wire:model="jsonCouple" class="w-full h-64 bg-[#1a1612] text-green-400 font-mono text-xs p-4 rounded-xl border border-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Events Editor --}}
                <div>
                    <label class="text-[#E6D9B8] text-xs font-bold block mb-2 uppercase tracking-wider">Events Data (JSON)</label>
                    <textarea wire:model="jsonEvents" class="w-full h-64 bg-[#1a1612] text-blue-400 font-mono text-xs p-4 rounded-xl border border-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Gifts Editor --}}
                <div>
                    <label class="text-[#E6D9B8] text-xs font-bold block mb-2 uppercase tracking-wider">Gifts Data (JSON)</label>
                    <textarea wire:model="jsonGifts" class="w-full h-64 bg-[#1a1612] text-yellow-400 font-mono text-xs p-4 rounded-xl border border-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>

                {{-- Theme Config Editor --}}
                <div>
                    <label class="text-[#E6D9B8] text-xs font-bold block mb-2 uppercase tracking-wider">Theme Config (JSON)</label>
                    <textarea wire:model="jsonTheme" class="w-full h-64 bg-[#1a1612] text-purple-400 font-mono text-xs p-4 rounded-xl border border-[#5E4926] focus:border-[#B89760] focus:ring-1 focus:ring-[#B89760] focus:outline-none custom-scrollbar leading-relaxed"></textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-[#5E4926]">
                <button wire:click="saveJsonData" 
                    wire:confirm="Yakin ingin menyimpan perubahan RAW data? Kesalahan format JSON dapat merusak tampilan undangan."
                    class="px-8 py-3 bg-red-600 text-white rounded-xl font-bold uppercase tracking-wider hover:bg-red-700 transition shadow-lg shadow-red-900/50 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Paksa
                </button>
            </div>

        </div>
    </div>

</div>