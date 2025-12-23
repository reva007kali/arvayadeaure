<div class="min-h-screen bg-arvaya-bg">
    {{-- Header --}}
    <div class="bg-arvaya-600 text-arvaya-50 py-10 relative overflow-hidden">
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
                    <div class="relative aspect-[3/4] overflow-hidden bg-arvaya-100">
                        @if($tpl->thumbnail)
                            <img src="{{ asset('storage/' . $tpl->thumbnail) }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-arvaya-300">
                                <i class="fa-solid fa-image text-4xl mb-2"></i>
                                <span class="text-xs font-bold uppercase">No Preview</span>
                            </div>
                        @endif

                        {{-- Tier Badge (Top Left) --}}
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-black/70 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg border border-white/10 shadow">
                                {{ $tpl->tier }}
                            </span>
                        </div>
                        {{-- Category Badge (Top Right) --}}
                        @if($tpl->category)
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 bg-arvaya-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg border border-white/10 shadow">
                                    {{ $tpl->category }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-6 flex flex-col flex-1 bg-zinc-800">
                        <h3 class="font-serif font-bold text-xl text-arvaya-400 group-hover:text-arvaya-600 transition mb-1">{{ $tpl->name }}</h3>
                        @if($tpl->price > 0)
                            @php $original = (int) round($tpl->price * 1.5); @endphp
                            <div class="mt-1 mb-3 flex items-center gap-2">
                                <span class="text-arvaya-300 font-bold text-sm line-through decoration-2 decoration-arvaya-500">Rp{{ number_format($original / 1000, 0) }}k</span>
                                <span class="text-white font-extrabold text-lg">Rp{{ number_format($tpl->price / 1000, 0) }}k</span>
                            </div>
                        @else
                            <span class="mt-1 mb-3 inline-block text-green-500 font-bold text-sm">FREE</span>
                        @endif
                        
                        <div class="pt-4 border-t border-arvaya-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if($tpl->preview_url)
                                    <a href="{{ $tpl->preview_url }}" target="_blank" 
                                       class="px-3 py-1.5 rounded-full bg-white text-arvaya-700 text-[10px] font-bold uppercase tracking-wider border border-arvaya-200 hover:border-arvaya-500 hover:text-arvaya-900 transition">
                                        <i class="fa-solid fa-eye mr-1"></i> Preview
                                    </a>
                                @else
                                    <span class="px-3 py-1.5 rounded-full bg-gray-200 text-gray-500 text-[10px] font-bold uppercase tracking-wider border border-gray-300 cursor-not-allowed">
                                        <i class="fa-solid fa-eye-slash mr-1"></i> Preview
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('register') }}" 
                               class="px-4 py-2 rounded-full bg-arvaya-500 text-white text-[10px] font-bold uppercase tracking-wider hover:bg-arvaya-600 transition">
                                <i class="fa-solid fa-pen-fancy mr-1"></i> Pakai
                            </a>
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
