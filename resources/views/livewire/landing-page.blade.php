<div class="">

    <!-- HERO SECTION -->
    <header class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden bg-arvaya-50">
        <!-- Minimalist Background Decoration -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white to-transparent opacity-60"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-arvaya-100 rounded-full blur-3xl opacity-30 -translate-x-1/2 translate-y-1/2"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10 w-full grid md:grid-cols-2 gap-16 items-center">
            <!-- Left: Content -->
            <div data-aos="fade-up" data-aos-duration="1000">
                <span class="inline-block py-1 px-3 rounded-full bg-white border border-arvaya-200 text-arvaya-800 text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
                    Undangan Pernikahan Digital
                </span>

                <h1 class="font-serif text-5xl md:text-7xl font-bold leading-tight mb-6 text-arvaya-900">
                    Rayakan Cinta dengan <span class="italic font-light text-arvaya-600">Elegan.</span>
                </h1>

                <p class="text-lg text-arvaya-700 mb-10 max-w-lg leading-relaxed font-light">
                    Buat undangan digital yang memukau dalam hitungan menit. Dilengkapi AI Assistant, manajemen tamu pintar, dan desain premium tanpa batas.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="px-8 py-4 bg-arvaya-900 text-white rounded-xl font-bold hover:bg-arvaya-800 transition shadow-lg shadow-arvaya-900/20 text-center">
                            Buka Dashboard
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-arvaya-900 text-white rounded-xl font-bold hover:bg-arvaya-800 transition shadow-lg shadow-arvaya-900/20 text-center">
                            Buat Undangan Gratis
                        </a>
                        <a href="#themes"
                            class="px-8 py-4 bg-white border border-arvaya-200 text-arvaya-900 rounded-xl font-bold hover:bg-arvaya-50 transition shadow-sm text-center flex items-center justify-center gap-2 group">
                            <i class="fa-solid fa-play text-xs text-arvaya-500 group-hover:text-arvaya-900 transition"></i>
                            Lihat Demo
                        </a>
                    @endguest
                </div>

                <div class="mt-12 flex items-center gap-4 text-sm text-arvaya-600">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-arvaya-200 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-arvaya-300 border-2 border-white"></div>
                        <div class="w-8 h-8 rounded-full bg-arvaya-400 border-2 border-white"></div>
                    </div>
                    <p>Bergabung dengan <span class="font-bold text-arvaya-900">2,000+</span> pasangan bahagia.</p>
                </div>
            </div>

            <!-- Right: Clean Visual -->
            <div class="relative hidden md:block" data-aos="fade-left" data-aos-duration="1200">
                <div class="relative z-10 animate-float">
                    <img src="img/hero.png" alt="App Preview"
                        class="rounded-[2rem] w-80 mx-auto shadow-2xl shadow-arvaya-900/10 border-4 border-white rotate-[-2deg] hover:rotate-0 transition duration-700">
                </div>
                <!-- Clean Floating Elements -->
                <div class="absolute top-1/2 -right-4 bg-white p-4 rounded-xl shadow-xl border border-arvaya-50 animate-bounce-slow">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-arvaya-900">Auto-Send</p>
                            <p class="text-[10px] text-arvaya-500">Terkirim ke 500+ tamu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- FEATURES SECTION (Clean Grid) -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16 max-w-2xl mx-auto" data-aos="fade-up">
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-arvaya-900">Fitur Modern untuk <br>Pernikahan Impian</h2>
                <p class="text-arvaya-600">Kami menyederhanakan proses rumit menjadi pengalaman yang menyenangkan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="p-8 rounded-2xl bg-arvaya-50 border border-arvaya-100 hover:border-arvaya-300 transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 rounded-xl bg-white text-arvaya-600 flex items-center justify-center text-xl mb-6 shadow-sm group-hover:bg-arvaya-900 group-hover:text-white transition">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-900">AI Writer Assistant</h3>
                    <p class="text-arvaya-600 text-sm leading-relaxed">
                        Bingung merangkai kata? Biarkan AI kami menuliskan doa dan ucapan yang menyentuh hati dalam hitungan detik.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="p-8 rounded-2xl bg-arvaya-50 border border-arvaya-100 hover:border-arvaya-300 transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 rounded-xl bg-white text-arvaya-600 flex items-center justify-center text-xl mb-6 shadow-sm group-hover:bg-arvaya-900 group-hover:text-white transition">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-900">Smart Guest Management</h3>
                    <p class="text-arvaya-600 text-sm leading-relaxed">
                        Kelola data tamu, grup, dan status RSVP dalam satu dashboard yang intuitif dan mudah digunakan.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="p-8 rounded-2xl bg-arvaya-50 border border-arvaya-100 hover:border-arvaya-300 transition duration-300 group"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 rounded-xl bg-white text-arvaya-600 flex items-center justify-center text-xl mb-6 shadow-sm group-hover:bg-arvaya-900 group-hover:text-white transition">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold mb-3 text-arvaya-900">Digital Check-in</h3>
                    <p class="text-arvaya-600 text-sm leading-relaxed">
                        Sistem QR Code untuk check-in tamu di hari H. Cepat, aman, dan tercatat otomatis real-time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- THEMES SECTION -->
    <section id="themes" class="py-24 bg-arvaya-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-arvaya-900">Koleksi Tema Eksklusif</h2>
                    <p class="text-arvaya-600 mt-2">Pilih desain yang mencerminkan kepribadian Anda.</p>
                </div>
                
                <div class="flex gap-4">
                    <select wire:model.live="tier"
                        class="px-4 py-2 rounded-lg border-arvaya-200 bg-white text-sm text-arvaya-800 focus:border-arvaya-500 focus:ring-arvaya-500">
                        <option value="all">Semua Kategori</option>
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="exclusive">Exclusive</option>
                    </select>
                </div>
            </div>

            @php $basicFeatures = $tiers['basic']['features'] ?? []; @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($templates as $tpl)
                    @php
                        $tierMeta = $tiers[$tpl->tier] ?? ['features' => []];
                    @endphp
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 border border-arvaya-100 hover:border-arvaya-300 hover:shadow-xl transition duration-300">
                        <div class="aspect-[9/16] rounded-xl overflow-hidden relative bg-arvaya-50 mb-4">
                            @if ($tpl->thumbnail)
                                <img src="{{ asset('storage/' . $tpl->thumbnail) }}" alt="{{ $tpl->name }}"
                                    class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-arvaya-300">
                                    <i class="fa-solid fa-image text-3xl"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-md bg-white/90 backdrop-blur text-arvaya-900 uppercase tracking-wider">
                                    {{ $tpl->tier }}
                                </span>
                            </div>

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 backdrop-blur-[1px]">
                                <a href="{{ route('invitation.show', $tpl->slug) }}"
                                    class="w-10 h-10 rounded-full bg-white text-arvaya-900 flex items-center justify-center hover:bg-arvaya-500 hover:text-white transition shadow-lg" title="Preview">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.create') }}"
                                    class="w-10 h-10 rounded-full bg-arvaya-900 text-white flex items-center justify-center hover:bg-arvaya-800 transition shadow-lg" title="Gunakan">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                            </div>
                        </div>
                        <div class="px-1">
                            <h3 class="font-serif font-bold text-arvaya-900 truncate">{{ $tpl->name }}</h3>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-arvaya-500 uppercase tracking-wide">{{ $tpl->category ?? 'Wedding' }}</p>
                                <p class="text-sm font-bold text-arvaya-800">Rp {{ number_format($tpl->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-arvaya-500 bg-white rounded-2xl border border-dashed border-arvaya-200">
                        Tidak ada template ditemukan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PRICING SECTION (Clean Cards) -->
    <section id="pricing" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4 text-arvaya-900">Investasi Sekali, <br>Aktif Selamanya</h2>
                <p class="text-arvaya-600">Pilih paket yang sesuai dengan kebutuhan acara Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Basic -->
                <div class="p-8 rounded-3xl border border-arvaya-100 bg-white hover:border-arvaya-300 transition duration-300" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-bold text-arvaya-900 text-lg mb-2">Paket Love</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-900 mb-6">Rp 150k</div>
                    <p class="text-sm text-arvaya-600 mb-8 pb-8 border-b border-arvaya-100">
                        Cukup untuk acara sederhana dengan fitur essential yang lengkap.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-800 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Masa Aktif 6 Bulan</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Unlimited Tamu</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Musik Latar</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> RSVP & Ucapan</li>
                    </ul>
                    <a href="{{ route('dashboard.index') }}" class="block w-full py-3 rounded-xl border border-arvaya-200 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">
                        Pilih Paket
                    </a>
                </div>

                <!-- Premium (Highlighted) -->
                <div class="p-8 rounded-3xl bg-arvaya-900 text-white shadow-2xl relative transform md:-translate-y-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 right-0 bg-arvaya-500 text-white text-[10px] font-bold px-4 py-1.5 rounded-bl-xl rounded-tr-2xl uppercase tracking-wider">
                        Most Popular
                    </div>
                    <h3 class="font-bold text-arvaya-100 text-lg mb-2">Paket Eternal</h3>
                    <div class="text-4xl font-serif font-bold text-white mb-6">Rp 350k</div>
                    <p class="text-sm text-arvaya-300 mb-8 pb-8 border-b border-white/10">
                        Fitur terlengkap untuk pengalaman undangan digital yang sempurna.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-100 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> <b>Aktif Selamanya</b></li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Semua Tema Premium</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> AI Writer Unlimited</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Prioritas Support</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-arvaya-400 mt-0.5"></i> Galeri Foto & Video HD</li>
                    </ul>
                    <a href="{{ route('dashboard.index') }}" class="block w-full py-3 rounded-xl bg-arvaya-500 text-white font-bold text-center hover:bg-arvaya-400 transition shadow-lg shadow-arvaya-500/20">
                        Mulai Sekarang
                    </a>
                </div>

                <!-- Custom -->
                <div class="p-8 rounded-3xl border border-arvaya-100 bg-white hover:border-arvaya-300 transition duration-300" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="font-bold text-arvaya-900 text-lg mb-2">Custom Design</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-900 mb-6">Contact</div>
                    <p class="text-sm text-arvaya-600 mb-8 pb-8 border-b border-arvaya-100">
                        Punya desain impian sendiri? Tim kami siap mewujudkannya.
                    </p>
                    <ul class="space-y-4 text-sm text-arvaya-800 mb-8">
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Request Desain</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Fitur Custom</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Pendampingan Penuh</li>
                        <li class="flex gap-3"><i class="fa-solid fa-check text-green-500 mt-0.5"></i> Input Data oleh Tim</li>
                    </ul>
                    <a href="https://wa.me/6282260894009" target="_blank" class="block w-full py-3 rounded-xl border border-arvaya-200 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS (Clean) -->
    <section id="testimonials" class="py-24 bg-arvaya-50 border-t border-arvaya-100 overflow-hidden">
        <div class="max-w-6xl mx-auto px-6 mb-12 text-center">
            <h2 class="font-serif text-3xl font-bold text-arvaya-900">Cerita Bahagia</h2>
        </div>
        
        <div class="relative w-full overflow-hidden mask-gradient-x">
            <div class="flex animate-marquee gap-8 w-max hover:[animation-play-state:paused]">
                <!-- Loop Items -->
                @foreach([1, 2, 3, 4] as $i)
                <div class="w-[400px] p-8 bg-white rounded-2xl shadow-sm border border-arvaya-100">
                    <div class="flex text-yellow-400 mb-4 text-xs gap-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-arvaya-700 text-sm mb-6 leading-relaxed italic">
                        "Platform undangan digital terbaik yang pernah saya coba. Desainnya elegan, tidak norak, dan fiturnya sangat membantu."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-arvaya-200 flex items-center justify-center text-arvaya-600 font-bold text-xs">
                            {{ substr(['Sarah', 'Raka', 'Andi', 'Bella'][$i-1], 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-arvaya-900">{{ ['Sarah & Dimas', 'Raka & Bella', 'Andi & Citra', 'Dina & Budi'][$i-1] }}</div>
                            <div class="text-xs text-arvaya-500">Jakarta</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FLOATING WHATSAPP (Neomorphism) -->
    <a href="https://wa.me/6282260894009" target="_blank"
        class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-14 h-14 bg-[#25D366] text-white rounded-full transition-transform hover:scale-110 active:scale-95"
        style="box-shadow: 6px 6px 15px rgba(37, 211, 102, 0.4), -6px -6px 15px rgba(255, 255, 255, 0.8);">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
    </a>

</div>
