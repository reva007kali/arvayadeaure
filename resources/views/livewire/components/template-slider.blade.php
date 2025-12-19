<div class="relative w-full">
    {{-- Header & Filter --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
        <div>
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-arvaya-100">Koleksi Tema Eksklusif</h2>
            <p class="text-arvaya-200 mt-2">Dekorasi undangan yang unik dan memukau untuk setiap acara.</p>
        </div>
    </div>

    {{-- Swiper Container --}}
    {{-- Wire:ignore is crucial here to prevent Livewire from destroying the Swiper instance --}}
    <div wire:ignore x-data="{
            swiper: null,
            init() {
                this.swiper = new Swiper(this.$refs.container, {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    spaceBetween: 50,
                    coverflowEffect: {
                        rotate: -13,
                        stretch: 0,
                        depth: 300,
                        modifier: 1,
                        slideShadows: true,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    loop: true,
                    observer: true, 
                    observeParents: true
                });
            }
         }" class="swiper w-full py-10" x-ref="container">

        <div class="swiper-wrapper">
            @forelse ($templates as $tpl)
                <div class="swiper-slide group cursor-pointer bg-arvaya-bg rounded-2xl p-3 shadow-[5px_5px_10px_#0a0a0a,-5px_-5px_10px_#1e1e1e] transition duration-300 mb-20"
                    style="width: 300px; background-position: center; background-size: cover;">

                    {{-- Card Content --}}
                    <div
                        class="aspect-[3/4] rounded-xl overflow-hidden relative bg-[#1a1a1a] mb-4 shadow-[inset_2px_2px_5px_#0a0a0a,inset_-2px_-2px_5px_#1e1e1e]">
                        @if ($tpl->thumbnail)
                            <img src="{{ asset('storage/' . $tpl->thumbnail) }}" alt="{{ $tpl->name }}"
                                class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-arvaya-900">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif

                        <div class="absolute top-2 left-2">
                            <span
                                class="px-2 py-1 text-[10px] font-bold rounded-md bg-black/50 backdrop-blur text-arvaya-400 uppercase tracking-wider shadow-sm">
                                {{ $tpl->tier }}
                            </span>
                        </div>

                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 backdrop-blur-[1px]">
                            <a href="{{ $tpl->preview_url ?? route('invitation.show', $tpl->slug) }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-arvaya-bg text-arvaya-400 flex items-center justify-center hover:text-white transition shadow-[3px_3px_6px_#000]"
                                title="Preview">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('dashboard.create') }}"
                                class="w-10 h-10 rounded-full bg-arvaya-400 text-arvaya-bg flex items-center justify-center hover:bg-arvaya-300 transition shadow-[3px_3px_6px_#000]"
                                title="Gunakan">
                                <i class="fa-solid fa-check"></i>
                            </a>
                        </div>
                    </div>

                    <div class="px-1">
                        <h3 class="font-serif font-bold text-arvaya-100 truncate">{{ $tpl->name }}</h3>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-xs text-arvaya-500 uppercase tracking-wide">{{ $tpl->category ?? 'Wedding' }}</p>
                            <p class="text-sm font-bold text-arvaya-400">
                                {{ $tpl->price > 0 ? 'Rp ' . number_format($tpl->price, 0, ',', '.') : 'FREE' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide col-span-full py-12 text-center text-arvaya-500 bg-arvaya-bg rounded-2xl shadow-[inset_5px_5px_10px_#0a0a0a,inset_-5px_-5px_10px_#1e1e1e]"
                    style="width: 300px;">
                    Tidak ada template ditemukan.
                </div>
            @endforelse
        </div>

        <div class="swiper-pagination !bottom-0"></div>
    </div>

    <div class="py-8">
        <a href="{{ route('templates.index') }}"
            class="block w-fit mx-auto text-center py-3 px-4 rounded-2xl bg-arvaya-400 text-arvaya-bg font-bold hover:bg-arvaya-300 transition shadow-[4px_4px_10px_#0a0a0a,-4px_-4px_10px_#1e1e1e]">
            Lihat Semua Template
        </a>
    </div>
</div>