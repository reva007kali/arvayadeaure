<section id="themes" class="py-24 bg-arvaya-900 text-arvaya-50 relative overflow-hidden">
    <!-- Background Texture -->
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-arvaya-900 via-transparent to-arvaya-900 z-0"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-arvaya-400 font-bold tracking-[0.2em] uppercase text-xs mb-3 block">Koleksi
                Eksklusif</span>
            <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4">Pilih Vibe <span
                    class="italic text-arvaya-400 font-light">Pernikahanmu</span></h2>
            <p class="text-gray-400 max-w-xl mx-auto">
                Desain premium yang fleksibel. Satu akun untuk akses ke semua tema tanpa batas.
            </p>
        </div>

        <!-- Slider Wrapper -->
        <div x-data="{
            activeSlide: 0,
            slides: {{ $templates->count() }},
            next() {
                this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1
            },
            prev() {
                this.activeSlide = this.activeSlide === 0 ? this.slides - 1 : this.activeSlide - 1
            }
        }" class="relative w-full max-w-6xl mx-auto">

            <!-- Navigation Buttons -->
            <button @click="prev()"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-12 z-20 w-12 h-12 rounded-full border border-arvaya-700 bg-arvaya-900/50 hover:bg-arvaya-500 text-white flex items-center justify-center transition backdrop-blur-sm group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition"></i>
            </button>
            <button @click="next()"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-12 z-20 w-12 h-12 rounded-full border border-arvaya-700 bg-arvaya-900/50 hover:bg-arvaya-500 text-white flex items-center justify-center transition backdrop-blur-sm group">
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
            </button>

            <!-- Cards Container -->
            <div class="overflow-hidden py-10">
                <div class="flex transition-transform duration-700 ease-out will-change-transform"
                    :style="`transform: translateX(-${activeSlide * 100}%)`">

                    @foreach ($templates as $template)
                        <div class="w-full md:w-1/3 flex-shrink-0 px-4">
                            <div
                                class="group relative rounded-[2rem] overflow-hidden bg-gray-800 border border-arvaya-800 shadow-2xl transition duration-500 hover:-translate-y-3">
                                <!-- Image -->
                                <div class="aspect-[9/16] overflow-hidden relative">
                                    <img src="{{ asset($template->thumbnail) ?? 'https://placehold.co/400x700/1a1a1a/FFF?text=Theme+Preview' }}"
                                        alt="{{ $template->name }}"
                                        class="object-cover w-full h-full transform group-hover:scale-105 transition duration-700">

                                    <!-- Overlay Actions -->
                                    <div
                                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center gap-3 backdrop-blur-[2px]">
                                        <a href="#"
                                            class="px-6 py-2 bg-white text-arvaya-900 rounded-full font-bold text-sm hover:bg-arvaya-400 hover:text-white transition transform hover:scale-105">
                                            <i class="fa-solid fa-eye mr-2"></i> {{$template->slug}}
                                        </a>
                                        <button
                                            class="px-6 py-2 border border-white text-white rounded-full font-bold text-sm hover:bg-white hover:text-arvaya-900 transition">
                                            Pilih Tema
                                        </button>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6 bg-gradient-to-t from-black to-arvaya-900/90 absolute bottom-0 w-full">
                                    <h3 class="text-xl font-serif font-bold text-white mb-1">{{ $template->name }}</h3>
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-xs text-arvaya-400 uppercase tracking-wider">{{ $template->category ?? 'Wedding' }}</span>
                                            <span class="px-2 rounded-full bg-arvaya-500">{{ $template->tier }}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Dots Indicator -->
            <div class="flex justify-center gap-2 mt-4">
                <template x-for="i in slides">
                    <button @click="activeSlide = i - 1" class="h-1.5 rounded-full transition-all duration-300"
                        :class="activeSlide === i - 1 ? 'w-8 bg-arvaya-500' : 'w-2 bg-arvaya-800'">
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>
