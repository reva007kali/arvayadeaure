<x-layouts.public>
    <div class="py-20 bg-arvaya-bg min-h-screen">
        {{-- Hero Section --}}
        <div class="max-w-6xl mx-auto px-6 mb-24">
            <div class="text-center max-w-3xl mx-auto" data-anim="fade-up">
                <h1 class="font-serif text-4xl md:text-6xl font-bold mb-6 text-arvaya-100">
                    Tentang <span class="text-arvaya-400">Arvaya De Aure</span>
                </h1>
                <p class="text-arvaya-200 text-lg md:text-xl leading-relaxed">
                    Kami hadir untuk mengubah cara Anda berbagi momen bahagia. Menggabungkan estetika desain premium dengan kecanggihan teknologi untuk menciptakan undangan digital yang tak terlupakan.
                </p>
            </div>
        </div>

        {{-- Vision & Mission --}}
        <div class="max-w-6xl mx-auto px-6 mb-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="relative" data-anim="fade-up">
                    <div class="absolute inset-0 bg-arvaya-400 blur-[100px] opacity-10"></div>
                    <img src="{{ asset('img/about-vision.jpg') }}" onerror="this.src='https://arvaya.id/img/phone-mockup.png'" 
                         class="relative rounded-2xl shadow-2xl border border-arvaya-400/20 w-full object-cover aspect-[4/3]" alt="Vision">
                </div>
                <div class="space-y-8" data-anim="fade-up" data-anim-delay="200">
                    <div>
                        <h3 class="font-serif text-2xl font-bold text-arvaya-100 mb-3">Visi Kami</h3>
                        <p class="text-arvaya-200 leading-relaxed">
                            Menjadi platform undangan digital terdepan yang tidak hanya memudahkan, tetapi juga meningkatkan nilai estetika setiap perayaan di Indonesia.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-serif text-2xl font-bold text-arvaya-100 mb-3">Misi Kami</h3>
                        <ul class="space-y-3 text-arvaya-200">
                            <li class="flex gap-3">
                                <i class="fa-solid fa-check text-arvaya-400 mt-1"></i>
                                <span>Menyediakan desain eksklusif yang modern dan elegan.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fa-solid fa-check text-arvaya-400 mt-1"></i>
                                <span>Mengintegrasikan teknologi AI untuk kemudahan penggunaan.</span>
                            </li>
                            <li class="flex gap-3">
                                <i class="fa-solid fa-check text-arvaya-400 mt-1"></i>
                                <span>Memberikan layanan pelanggan yang responsif dan personal.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats / Values --}}
        <div class="bg-[#1a1a1a] border-y border-white/5 py-20 mb-24">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div data-anim="fade-up">
                        <div class="text-4xl font-serif font-bold text-arvaya-400 mb-2">100+</div>
                        <p class="text-arvaya-200 text-sm uppercase tracking-wider">Undangan Dibuat</p>
                    </div>
                    <div data-anim="fade-up" data-anim-delay="100">
                        <div class="text-4xl font-serif font-bold text-arvaya-400 mb-2">50+</div>
                        <p class="text-arvaya-200 text-sm uppercase tracking-wider">Desain Premium</p>
                    </div>
                    <div data-anim="fade-up" data-anim-delay="200">
                        <div class="text-4xl font-serif font-bold text-arvaya-400 mb-2">99%</div>
                        <p class="text-arvaya-200 text-sm uppercase tracking-wider">Kepuasan Klien</p>
                    </div>
                    <div data-anim="fade-up" data-anim-delay="300">
                        <div class="text-4xl font-serif font-bold text-arvaya-400 mb-2">24/7</div>
                        <p class="text-arvaya-200 text-sm uppercase tracking-wider">Layanan Support</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="max-w-4xl mx-auto px-6 text-center" data-anim="fade-up">
            <h2 class="font-serif text-3xl font-bold text-arvaya-100 mb-6">Siap Membuat Momen Anda Lebih Spesial?</h2>
            <p class="text-arvaya-200 mb-8">Bergabunglah dengan ribuan pasangan yang telah mempercayakan undangan digital mereka kepada kami.</p>
            <a href="{{ route('dashboard.index') }}" 
               class="inline-block px-8 py-4 bg-arvaya-400 text-arvaya-bg rounded-full font-bold hover:bg-arvaya-300 transition shadow-[0_0_20px_rgba(212,175,55,0.3)] transform hover:-translate-y-1">
                Buat Undangan Sekarang
            </a>
        </div>
    </div>
</x-layouts.public>
