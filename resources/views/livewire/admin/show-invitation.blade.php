<div class="py-2 animate-fade-in-up">
    
    {{-- HEADER HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 text-[#9A7D4C] text-xs font-bold uppercase tracking-widest mb-1">
                <a href="{{ route('admin.invitations') }}" class="hover:text-[#5E4926] transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <span>/</span>
                <span>Asset Inspection</span>
            </div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Detail Data & Aset</h2>
            <p class="text-[#7C6339] text-sm mt-1">
                Project: <span class="font-semibold italic">{{ $invitation->title }}</span> | 
                Owner: <span class="font-semibold">{{ $invitation->user->name }}</span>
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                class="px-5 py-2.5 bg-white border border-[#E6D9B8] text-[#7C6339] rounded-xl hover:bg-[#F9F7F2] hover:text-[#B89760] transition font-bold text-xs uppercase tracking-wide flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-eye"></i> Lihat Website
            </a>
        </div>
    </div>

    @php
        // Helper untuk menormalkan data galeri
        $gallery = $invitation->gallery_data ?? [];
        $moments = $gallery['moments'] ?? [];
        
        // Cek jika struktur data masih format lama (array indexed)
        if (isset($gallery[0])) {
            $moments = $gallery;
            $gallery['cover'] = null;
            $gallery['groom'] = null;
            $gallery['bride'] = null;
        }
    @endphp

    <div class="space-y-8">

        {{-- SECTION 1: GALERI UTAMA (Cover & Profile) --}}
        <div class="bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border border-[#E6D9B8] overflow-hidden">
            <div class="p-6 border-b border-[#F2ECDC] flex justify-between items-center bg-[#F9F7F2]/50">
                <h3 class="font-serif font-bold text-xl text-[#5E4926] flex items-center gap-2">
                    <i class="fa-solid fa-images text-[#B89760]"></i> Aset Foto Utama
                </h3>
            </div>
            
            <div class="p-8">
                @if(empty($gallery['cover']) && empty($gallery['groom']) && empty($gallery['bride']))
                    <div class="text-center py-6 border-2 border-dashed border-[#E6D9B8] rounded-xl text-[#9A7D4C]">
                        User belum mengupload foto utama (Cover/Profil).
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach(['cover' => 'Foto Sampul', 'groom' => 'Mempelai Pria', 'bride' => 'Mempelai Wanita'] as $key => $label)
                            @if(!empty($gallery[$key]))
                                <div>
                                    <p class="text-xs font-bold text-[#9A7D4C] uppercase tracking-wider mb-2">{{ $label }}</p>
                                    <div class="group relative rounded-xl overflow-hidden border border-[#E6D9B8] shadow-sm bg-gray-100 {{ $key == 'cover' ? 'aspect-[9/16]' : 'aspect-square' }}">
                                        <img src="{{ asset($gallery[$key]) }}" class="w-full h-full object-cover">
                                        
                                        <div class="absolute inset-0 bg-[#5E4926]/70 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center gap-2 backdrop-blur-sm">
                                            <a href="{{ asset($gallery[$key]) }}" target="_blank" 
                                               class="px-3 py-1 bg-white text-[#5E4926] text-[10px] font-bold uppercase rounded hover:bg-[#B89760] hover:text-white transition">
                                                Lihat
                                            </a>
                                            <a href="{{ asset($gallery[$key]) }}" download
                                               class="px-3 py-1 bg-[#B89760] text-white text-[10px] font-bold uppercase rounded hover:bg-[#9A7D4C] transition">
                                                Save
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- SECTION 2: GALERI MOMEN (Many Photos) --}}
        <div class="bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(184,151,96,0.15)] border border-[#E6D9B8] overflow-hidden">
            <div class="p-6 border-b border-[#F2ECDC] flex justify-between items-center bg-[#F9F7F2]/50">
                <h3 class="font-serif font-bold text-xl text-[#5E4926] flex items-center gap-2">
                    <i class="fa-regular fa-images text-[#B89760]"></i> Galeri Momen
                </h3>
                <span class="text-xs font-bold text-[#9A7D4C] uppercase tracking-wider">
                    Total: {{ count($moments) }} Foto
                </span>
            </div>
            
            <div class="p-8">
                @if(empty($moments))
                    <div class="text-center py-10 border-2 border-dashed border-[#E6D9B8] rounded-xl text-[#9A7D4C]">
                        User belum mengupload foto momen.
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($moments as $path)
                            @if(is_string($path)) {{-- Safety Check --}}
                                <div class="group relative rounded-xl overflow-hidden border border-[#E6D9B8] shadow-sm bg-gray-100 aspect-square">
                                    <img src="{{ asset($path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                    
                                    <div class="absolute inset-0 bg-[#5E4926]/70 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center gap-2 backdrop-blur-sm">
                                        <a href="{{ asset($path) }}" target="_blank" 
                                           class="px-3 py-1 bg-white text-[#5E4926] text-[10px] font-bold uppercase rounded hover:bg-[#B89760] hover:text-white transition">
                                            Lihat
                                        </a>
                                        <a href="{{ asset($path) }}" download
                                           class="px-3 py-1 bg-[#B89760] text-white text-[10px] font-bold uppercase rounded hover:bg-[#9A7D4C] transition">
                                            Save
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- SECTION 3: DATA MEMPELAI --}}
            <div class="bg-white rounded-3xl shadow-sm border border-[#E6D9B8]">
                <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2]/30">
                    <h3 class="font-serif font-bold text-xl text-[#5E4926] flex items-center gap-2">
                        <i class="fa-solid fa-user-group text-[#B89760]"></i> Data Mempelai
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    {{-- Pria --}}
                    <div class="bg-[#F9F7F2] p-5 rounded-2xl border border-[#E6D9B8]/50 relative">
                        <span class="absolute top-0 right-0 bg-[#5E4926] text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl rounded-tr-xl">GROOM</span>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Nama Lengkap</label>
                                <p class="font-serif text-lg text-[#5E4926] font-bold select-all">{{ $invitation->couple_data['groom']['fullname'] ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Panggilan</label>
                                    <p class="text-sm text-[#5E4926] select-all">{{ $invitation->couple_data['groom']['nickname'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Instagram</label>
                                    <p class="text-sm text-[#5E4926] select-all">{{ $invitation->couple_data['groom']['instagram'] ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Nama Orang Tua</label>
                                <div class="grid grid-cols-2 gap-2 mt-1">
                                    <div class="bg-white px-3 py-2 rounded-lg border border-[#E6D9B8] text-sm text-[#7C6339]">
                                        <span class="text-[8px] block opacity-50 uppercase">Ayah</span>
                                        <span class="select-all">{{ $invitation->couple_data['groom']['father'] ?? '-' }}</span>
                                    </div>
                                    <div class="bg-white px-3 py-2 rounded-lg border border-[#E6D9B8] text-sm text-[#7C6339]">
                                        <span class="text-[8px] block opacity-50 uppercase">Ibu</span>
                                        <span class="select-all">{{ $invitation->couple_data['groom']['mother'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Wanita --}}
                    <div class="bg-[#F9F7F2] p-5 rounded-2xl border border-[#E6D9B8]/50 relative">
                        <span class="absolute top-0 right-0 bg-[#B89760] text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl rounded-tr-xl">BRIDE</span>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Nama Lengkap</label>
                                <p class="font-serif text-lg text-[#5E4926] font-bold select-all">{{ $invitation->couple_data['bride']['fullname'] ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Panggilan</label>
                                    <p class="text-sm text-[#5E4926] select-all">{{ $invitation->couple_data['bride']['nickname'] ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Instagram</label>
                                    <p class="text-sm text-[#5E4926] select-all">{{ $invitation->couple_data['bride']['instagram'] ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] text-[#9A7D4C] uppercase font-bold block">Nama Orang Tua</label>
                                <div class="grid grid-cols-2 gap-2 mt-1">
                                    <div class="bg-white px-3 py-2 rounded-lg border border-[#E6D9B8] text-sm text-[#7C6339]">
                                        <span class="text-[8px] block opacity-50 uppercase">Ayah</span>
                                        <span class="select-all">{{ $invitation->couple_data['bride']['father'] ?? '-' }}</span>
                                    </div>
                                    <div class="bg-white px-3 py-2 rounded-lg border border-[#E6D9B8] text-sm text-[#7C6339]">
                                        <span class="text-[8px] block opacity-50 uppercase">Ibu</span>
                                        <span class="select-all">{{ $invitation->couple_data['bride']['mother'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quote --}}
                    <div class="bg-[#FFFBF2] p-4 rounded-xl border border-[#E6D9B8] italic text-[#7C6339] text-sm relative">
                        <i class="fa-solid fa-quote-left absolute -top-2 -left-2 text-[#B89760] text-xl bg-white rounded-full p-1"></i>
                        <span class="select-all">{{ $invitation->couple_data['quote'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: DETAIL ACARA (EVENTS) --}}
            <div class="space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-[#E6D9B8]">
                    <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2]/30">
                        <h3 class="font-serif font-bold text-xl text-[#5E4926] flex items-center gap-2">
                            <i class="fa-solid fa-calendar-days text-[#B89760]"></i> Detail Acara
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        @forelse($invitation->event_data ?? [] as $index => $event)
                            <div class="relative pl-6 border-l-2 border-[#E6D9B8]">
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-[#B89760] border-2 border-white shadow-sm"></div>
                                
                                <h4 class="font-bold text-lg text-[#5E4926] select-all mb-1">{{ $event['title'] }}</h4>
                                
                                <div class="space-y-2 mt-3">
                                    <div class="flex items-start gap-3">
                                        <i class="fa-regular fa-clock text-[#9A7D4C] mt-1 text-xs"></i>
                                        <div>
                                            <p class="text-xs font-bold text-[#9A7D4C] uppercase">Waktu</p>
                                            <p class="text-sm text-[#5E4926] select-all">
                                                {{ \Carbon\Carbon::parse($event['date'])->format('l, d F Y') }} <br>
                                                Pukul {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <i class="fa-solid fa-location-dot text-[#9A7D4C] mt-1 text-xs"></i>
                                        <div>
                                            <p class="text-xs font-bold text-[#9A7D4C] uppercase">Lokasi</p>
                                            <p class="text-sm font-bold text-[#5E4926] select-all">{{ $event['location'] }}</p>
                                            <p class="text-sm text-[#7C6339] mt-1 select-all bg-[#F9F7F2] p-2 rounded-lg border border-[#F2ECDC]">
                                                {{ $event['address'] }}
                                            </p>
                                        </div>
                                    </div>

                                    @if(!empty($event['map_link']))
                                    <div class="flex items-start gap-3">
                                        <i class="fa-solid fa-map text-[#9A7D4C] mt-1 text-xs"></i>
                                        <div class="w-full">
                                            <p class="text-xs font-bold text-[#9A7D4C] uppercase mb-1">Google Maps URL</p>
                                            <div class="bg-gray-50 border border-gray-200 rounded p-2 flex justify-between items-center">
                                                <a href="{{ $event['map_link'] }}" target="_blank" class="text-xs text-blue-600 hover:underline truncate w-40 block">
                                                    {{ $event['map_link'] }}
                                                </a>
                                                <button onclick="navigator.clipboard.writeText('{{ $event['map_link'] }}'); alert('Copied!');" class="text-[#B89760] text-xs hover:text-[#5E4926]">
                                                    <i class="fa-regular fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-[#9A7D4C] italic">Belum ada data acara.</p>
                        @endforelse
                    </div>
                </div>

                {{-- SECTION 5: DATA REKENING (GIFTS) --}}
                <div class="bg-white rounded-3xl shadow-sm border border-[#E6D9B8]">
                    <div class="p-6 border-b border-[#F2ECDC] bg-[#F9F7F2]/30">
                        <h3 class="font-serif font-bold text-xl text-[#5E4926] flex items-center gap-2">
                            <i class="fa-solid fa-gift text-[#B89760]"></i> Data Rekening
                        </h3>
                    </div>
                    <div class="p-6">
                        @if(!empty($invitation->gifts_data))
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($invitation->gifts_data as $gift)
                                    <div class="bg-[#F9F7F2] p-4 rounded-xl border border-[#E6D9B8] relative">
                                        <i class="fa-solid fa-credit-card absolute top-4 right-4 text-[#E6D9B8] text-2xl"></i>
                                        <p class="text-xs font-bold text-[#9A7D4C] uppercase mb-1">Bank / Wallet</p>
                                        <p class="font-bold text-[#5E4926] text-lg select-all">{{ $gift['bank_name'] }}</p>
                                        
                                        <p class="text-xs font-bold text-[#9A7D4C] uppercase mt-3 mb-1">Nomor Rekening</p>
                                        <p class="font-mono text-[#5E4926] bg-white px-2 py-1 rounded border border-[#E6D9B8] inline-block select-all cursor-text">
                                            {{ $gift['account_number'] }}
                                        </p>
                                        
                                        <p class="text-xs font-bold text-[#9A7D4C] uppercase mt-3 mb-1">Atas Nama</p>
                                        <p class="text-sm text-[#5E4926] select-all">{{ $gift['account_name'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-[#9A7D4C] italic">User tidak mengaktifkan fitur kado digital.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 6: RAW DATA INSPECTOR --}}
        <div class="bg-[#2D2418] rounded-3xl shadow-lg border border-[#5E4926] overflow-hidden" x-data="{ open: false }">
            <div @click="open = !open" class="p-4 cursor-pointer flex justify-between items-center hover:bg-white/5 transition">
                <h3 class="font-mono font-bold text-[#E6D9B8] flex items-center gap-2">
                    <i class="fa-solid fa-code"></i> Developer / Raw JSON Data
                </h3>
                <i class="fa-solid text-[#E6D9B8]" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </div>
            
            <div x-show="open" class="p-6 border-t border-[#5E4926] bg-black/30">
                <p class="text-[#9A7D4C] text-xs mb-2">Copy data ini jika ingin membuat custom invitation manual.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[#E6D9B8] text-xs font-bold block mb-1">COUPLE DATA</label>
                        <textarea readonly class="w-full h-40 bg-black text-green-400 font-mono text-xs p-3 rounded border border-[#5E4926] focus:outline-none custom-scrollbar">{{ json_encode($invitation->couple_data, JSON_PRETTY_PRINT) }}</textarea>
                    </div>
                    <div>
                        <label class="text-[#E6D9B8] text-xs font-bold block mb-1">EVENT DATA</label>
                        <textarea readonly class="w-full h-40 bg-black text-blue-400 font-mono text-xs p-3 rounded border border-[#5E4926] focus:outline-none custom-scrollbar">{{ json_encode($invitation->event_data, JSON_PRETTY_PRINT) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>