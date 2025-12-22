{{-- Pricing Info --}}
<div
    class="bg-gradient-to-r from-[#1a1a1a] to-[#252525] rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-xl">
    <div
        class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-3xl opacity-20 -mr-16 -mt-16">
    </div>
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span
                    class="bg-[#D4AF37] text-[#121212] text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Active
                    Plan</span>
            </div>
            <h4 class="font-serif font-bold text-3xl mb-2">{{ $currentTierName }}</h4>
            <div class="flex flex-wrap gap-2 text-xs text-[#E0E0E0]">
                @foreach ($currentTierFeatures as $feat)
                    <span class="flex items-center gap-1 bg-white/10 px-2 py-1 rounded"><i
                            class="fa-solid fa-check text-[#D4AF37]"></i>
                        {{ ucwords(str_replace('_', ' ', $feat)) }}</span>
                @endforeach
            </div>
        </div>
        <div class="text-right">
            <p class="text-xs text-[#A0A0A0] uppercase tracking-wide mb-1">Total Harga
                Template</p>
            <p class="font-serif text-4xl font-bold">Rp
                {{ number_format($currentTemplatePrice, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

{{-- Template Grid --}}
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 px-2 mb-4">
        <label class="font-bold text-[#E0E0E0] text-lg">Pilih Desain</label>
        <div class="w-full sm:w-80">
            <div
                class="flex items-center gap-3 rounded-xl bg-[#1a1a1a] border border-[#333333] px-3 py-2 focus-within:border-[#D4AF37] focus-within:ring-1 focus-within:ring-[#D4AF37]">
                <i class="fa-solid fa-magnifying-glass text-[#D4AF37]"></i>
                <input type="text" wire:model.live="search" placeholder="Cari desain..."
                    class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-sm text-[#E0E0E0]">
                <span wire:loading wire:target="search" class="text-[#D4AF37]">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach ($availableTemplates as $tpl)
            <div class="group cursor-pointer rounded-xl overflow-hidden"
                wire:click="selectTemplate('{{ $tpl->slug }}')">
                <div
                    class="aspect-[9/16] overflow-hidden relative border-2 transition-all
                                                                                                                                                                                                                                {{ $theme_template == $tpl->slug ? 'border-[#D4AF37] ring-2 ring-[#D4AF37]/30 shadow-xl' : 'border-[#333333] hover:border-[#D4AF37]/50 hover:shadow-lg' }}">
                    @if ($tpl->thumbnail)
                        <img src="{{ asset('storage/' . $tpl->thumbnail) }}" loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-[1.02] transition">
                    @else
                        <div
                            class="w-full h-full bg-[#252525] flex flex-col items-center justify-center text-[#888]">
                            <i class="fa-solid fa-image text-3xl mb-2"></i>
                            <span class="text-xs font-bold">No Preview</span>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2">
                        <span
                            class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full shadow-sm
                                                                                                                                                                                                                                        {{ $tpl->tier == 'exclusive' ? 'bg-[#2D2418] text-[#D4AF37]' : ($tpl->tier == 'premium' ? 'bg-[#D4AF37] text-[#121212]' : 'bg-[#1a1a1a] text-[#E0E0E0]') }}">
                            {{ $tpl->tier }}
                        </span>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-[#1a1a1a]/95 backdrop-blur-sm p-2 text-center border-t border-[#333333]">
                        <p class="font-bold text-[#E0E0E0] text-xs">Rp
                            {{ number_format($tpl->price, 0, ',', '.') }}
                        </p>
                    </div>
                    @if ($theme_template == $tpl->slug)
                        <div class="absolute inset-0 bg-[#D4AF37]/25 flex items-center justify-center">
                            <div
                                class="w-10 h-10 rounded-full bg-[#D4AF37] text-[#121212] flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="text-center mt-2">
                    <p class="font-serif font-bold text-[#E0E0E0] text-sm">
                        {{ $tpl->name }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4" x-data
        x-init="const observer = new IntersectionObserver((entries) => {
                                                                                                                                        entries.forEach(entry => {
                                                                                                                                            if (entry.isIntersecting) { $wire.loadMoreTemplates() }
                                                                                                                                        });
                                                                                                                                    }, { root: null, threshold: 1 });
                                                                                                                                    observer.observe($refs.sentinel);">
        <div x-ref="sentinel" class="h-6"></div>
        @unless ($hasMoreTemplates)
            <p class="text-center text-[10px] text-[#A0A0A0] mt-2">Semua desain telah dimuat
            </p>
        @endunless
    </div>
</div>

