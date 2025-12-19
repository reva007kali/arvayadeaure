<div class="min-h-screen bg-arvaya-bg">
    {{-- Header --}}
    <div class="bg-arvaya-600 text-arvaya-50 pt-32 pb-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="font-serif text-4xl md:text-6xl font-bold mb-4">Galeri Tema Eksklusif</h1>
            <p class="text-arvaya-200 text-lg max-w-2xl mx-auto">
                Temukan desain undangan yang sempurna untuk momen spesialmu. Dari elegan hingga playful, semua ada di sini.
            </p>
        </div>
    </div>

    {{-- Filters & Content --}}
    <div class="container mx-auto px-6 py-12">
        
        {{-- Search & Filters --}}
        <div class="mb-12 space-y-6">
            {{-- Search Bar --}}
            <div class="max-w-xl mx-auto relative">
                <input type="text" wire:model.live.debounce.300ms="search" 
                    class="w-full !pl-12 pr-4 py-4 rounded-full bg-white border border-arvaya-200 focus:border-arvaya-500 focus:ring-2 focus:ring-arvaya-500/20 shadow-lg text-arvaya-900 placeholder-arvaya-300 transition"
                    placeholder="Cari nama tema atau style (e.g., Rustic, Minimalist)...">
                <div class="absolute left-5 top-4 text-arvaya-400">
                    <i class="fa-solid fa-search"></i>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-center items-center gap-6">
                {{-- Category Filter --}}
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach(['All', 'Wedding', 'Engagement', 'Birthday', 'Aqiqah', 'Khitan', 'Event'] as $cat)
                        <button wire:click="setCategory('{{ $cat }}')"
                            class="px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider border transition-all transform hover:-translate-y-0.5
                            {{ $category === $cat 
                                ? 'bg-arvaya-500 text-white border-arvaya-500 shadow-md' 
                                : 'bg-white text-arvaya-600 border-arvaya-200 hover:border-arvaya-500 hover:text-arvaya-500' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                {{-- Tier Filter --}}
                <div class="flex items-center gap-2 bg-white px-2 py-1 rounded-full border border-arvaya-200 shadow-sm">
                    @foreach(['All', 'basic', 'premium', 'exclusive'] as $t)
                        <button wire:click="setTier('{{ $t }}')"
                            class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all
                            {{ $tier === $t 
                                ? 'bg-arvaya-900 text-white shadow-sm' 
                                : 'text-arvaya-400 hover:text-arvaya-900' }}">
                            {{ ucfirst($t) }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Loading State --}}
        <div wire:loading class="w-full text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-arvaya-200 border-t-arvaya-500"></div>
            <p class="text-arvaya-500 text-sm mt-2 font-bold animate-pulse">Memuat tema...</p>
        </div>

        {{-- Grid --}}
        <div wire:loading.remove class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @forelse($templates as $tpl)
                <div class="group bg-arvaya-bg rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-arvaya-500/20 border border-arvaya-100 transition-all duration-500 hover:-translate-y-2 flex flex-col h-full">
                    {{-- Thumbnail --}}
                    <div class="relative aspect-[4/5] overflow-hidden bg-arvaya-100">
                        @if($tpl->thumbnail)
                            <img src="{{ asset('storage/' . $tpl->thumbnail) }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-arvaya-300">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <span class="text-xs font-bold uppercase">No Preview</span>
                            </div>
                        @endif

                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1 items-start">
                            <span class="px-3 py-1 bg-black/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg border border-white/10 shadow-lg">
                                {{ $tpl->tier }}
                            </span>
                            @if($tpl->category)
                                <span class="px-3 py-1 bg-arvaya-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg border border-white/10 shadow-lg">
                                    {{ $tpl->category }}
                                </span>
                            @endif
                        </div>

                        {{-- Overlay Actions --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 backdrop-blur-[2px]">
                            {{-- Preview Button --}}
                            @if($tpl->preview_url)
                                <a href="{{ $tpl->preview_url }}" target="_blank" 
                                   class="w-10 h-10 rounded-full bg-white text-arvaya-100 flex items-center justify-center hover:scale-110 transition shadow-xl" 
                                   title="Lihat Preview">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @else
                                <button class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center cursor-not-allowed" 
                                        title="Preview belum tersedia">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            @endif
                            
                            {{-- Use Button --}}
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-arvaya-500 text-white rounded-full font-bold text-xs uppercase tracking-wider hover:bg-arvaya-600 transition shadow-xl hover:scale-105 flex items-center gap-2">
                                <i class="fa-solid fa-pen-fancy"></i> Pakai
                            </a>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-6 flex flex-col flex-1 bg-zinc-800">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-serif font-bold text-xl text-arvaya-400 group-hover:text-arvaya-600 transition">{{ $tpl->name }}</h3>
                            @if($tpl->price > 0)
                                <span class="text-arvaya-600 font-bold text-sm bg-arvaya-50 px-2 py-1 rounded-lg">Rp{{ number_format($tpl->price / 1000, 0) }}k</span>
                            @else
                                <span class="text-green-600 font-bold text-sm bg-green-50 px-2 py-1 rounded-lg">FREE</span>
                            @endif
                        </div>
                        <p class="text-gray-200 text-sm line-clamp-2 mb-4 flex-1">{{ $tpl->description ?? 'Template eksklusif dengan desain modern dan fitur lengkap.' }}</p>
                        
                        <div class="pt-4 border-t border-arvaya-50 flex items-center justify-between text-xs text-arvaya-400 font-bold uppercase tracking-wider">
                            <span><i class="fa-solid fa-layer-group mr-1"></i> {{ $tpl->category ?? 'General' }}</span>
                            <span class="group-hover:translate-x-1 transition duration-300 text-arvaya-300 group-hover:text-arvaya-500">Pilih <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-20 h-20 bg-arvaya-100 rounded-full flex items-center justify-center text-arvaya-400 mx-auto mb-6 animate-pulse">
                        <i class="fa-solid fa-magnifying-glass text-3xl"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-arvaya-900 mb-2">Tidak ditemukan</h3>
                    <p class="text-gray-500">Coba ganti kata kunci atau filter kategori lainnya.</p>
                    <button wire:click="$set('search', '')" class="mt-6 text-arvaya-600 font-bold hover:underline">Reset Pencarian</button>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $templates->links() }}
        </div>
    </div>
</div>
