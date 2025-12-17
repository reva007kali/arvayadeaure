<div class="">

    <!-- HERO SECTION -->
    <header class="relative min-h-svh flex items-center justify-center pt-24 overflow-hidden">
        <!-- Abstract Background Blobs (Optimized) -->
        <div
            class="absolute top-0 -left-20 w-[500px] h-[500px] bg-arvaya-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob">
        </div>
        <div
            class="absolute top-0 -right-20 w-[500px] h-[500px] bg-yellow-100 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-[500px] h-[500px] bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000">
        </div>

        <div class="container max-w-7xl mx-auto px-6 relative z-10 grid md:grid-cols-2 gap-12 items-center">
            <!-- Left: Content -->
            <div data-aos="fade-right" data-aos-duration="1000">
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-arvaya-200 text-arvaya-600 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 shadow-sm hover:shadow-md transition cursor-default">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Undangan Digital Next-Gen
                </div>

                <h1 class="font-serif text-5xl md:text-7xl font-bold leading-[1.1] mb-6 text-arvaya-900">
                    Sampaikan Kabar <br>
                    <span class="italic font-light text-arvaya-500">Bahagia</span> dengan <br>
                    Estetika Tinggi.
                </h1>

                <p class="text-lg text-gray-600 mb-10 max-w-lg leading-relaxed">
                    Platform undangan digital premium dengan fitur <i>AI Writer</i>, manajemen tamu pintar, dan desain
                    <i>timeless</i>. Elegan, sopan, & tanpa ribet.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="group px-8 py-4 bg-arvaya-900 text-white rounded-full font-medium hover:bg-arvaya-800 transition shadow-xl hover:shadow-2xl text-center flex items-center justify-center gap-2">
                            Buat Undangan
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('register') }}"
                            class="group px-8 py-4 bg-arvaya-900 text-white rounded-full font-medium hover:bg-arvaya-800 transition shadow-xl hover:shadow-2xl text-center flex items-center justify-center gap-2">
                            Daftar & Buat Undangan
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition"></i>
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 bg-white/50 backdrop-blur-sm border border-arvaya-200 text-arvaya-800 rounded-full font-medium hover:bg-white transition shadow-sm text-center flex items-center justify-center gap-3">
                            Masuk
                        </a>
                    @endguest
                    <a href="#themes"
                        class="px-8 py-4 bg-white/50 backdrop-blur-sm border border-arvaya-200 text-arvaya-800 rounded-full font-medium hover:bg-white transition shadow-sm text-center flex items-center justify-center gap-3 group">
                        <span
                            class="w-8 h-8 rounded-full bg-arvaya-100 flex items-center justify-center group-hover:bg-arvaya-500 group-hover:text-white transition">
                            <i class="fa-solid fa-play text-[10px]"></i>
                        </span>
                        Lihat Demo
                    </a>
                </div>

                <!-- Social Proof -->
                <div
                    class="mt-12 flex items-center gap-4 text-sm text-gray-500 border-t border-arvaya-200/50 pt-6 max-w-sm">
                    <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                            src="https://i.pravatar.cc/100?img=1" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                            src="https://i.pravatar.cc/100?img=5" alt="User">
                        <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                            src="https://i.pravatar.cc/100?img=9" alt="User">
                        <div
                            class="w-10 h-10 rounded-full border-2 border-white bg-arvaya-100 flex items-center justify-center text-xs font-bold text-arvaya-800">
                            +2k</div>
                    </div>
                    <div>
                        <div class="flex text-yellow-500 text-[10px] mb-0.5">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-xs">Dipercaya oleh <span class="font-bold text-arvaya-900">2,000+ Pasangan</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Mockup 3D Tilt Effect -->
            <div class="relative hidden md:block perspective-1000" data-aos="fade-left" data-aos-duration="1200">
                <!-- Decorative Circle -->
                <div
                    class="absolute inset-0 bg-gradient-to-tr from-arvaya-100 to-transparent rounded-full opacity-50 blur-2xl transform scale-90">
                </div>

                <div class="relative z-10 animate-float">
                    <img src="img/hero.png" alt="Mockup Undangan"
                        class="rounded-[2.5rem] w-80 mx-auto shadow-[0_25px_60px_-15px_rgba(0,0,0,0.2)] border-[8px] border-white/80 backdrop-blur-sm transform rotate-[-3deg] hover:rotate-0 transition duration-700 ease-out object-cover">
                </div>

                <!-- Floating Card: AI Feature -->
                <div
                    class="absolute top-20 right-10 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl animate-bounce z-20 max-w-[220px] border border-white/50">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-1.5 rounded-lg bg-indigo-100 text-indigo-600"><i
                                class="fa-solid fa-wand-magic-sparkles text-xs"></i></div>
                        <span class="text-xs font-bold text-gray-800">AI Generator</span>
                    </div>
                    <p class="text-[10px] text-gray-500 font-medium">"Buatkan ucapan doa restu yang islami dan menyentuh
                        hati..."</p>
                </div>

                <!-- Floating Card: Music -->
                <div
                    class="absolute bottom-20 left-0 bg-white/90 backdrop-blur-md p-3 rounded-full shadow-xl z-20 flex items-center gap-3 pr-6 animate-[bounce_3s_infinite] animation-delay-1000 border border-white/50">
                    <div
                        class="w-10 h-10 rounded-full bg-arvaya-900 flex items-center justify-center text-white animate-spin-slow">
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-800">Backsound Auto-play</p>
                        <p class="text-[8px] text-gray-500">Beautiful in White.mp3</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- FEATURES SECTION -->
    <section id="features" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="font-serif text-4xl md:text-5xl font-bold mb-4 text-arvaya-900">Fitur Canggih, <br> <span
                        class="italic text-arvaya-500 font-light">Experience</span> Mewah.</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Teknologi yang memudahkan, bukan membingungkan. Kami rancang khusus untuk kebutuhan pernikahan
                    modern.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-gray-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition duration-500 hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition duration-300">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-gray-900">AI Assistant Writer</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Tidak perlu pusing merangkai kata. AI kami siap membuatkan deskripsi, quote, hingga doa dalam
                        berbagai tone (Formal, Islami, Casual).
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-gray-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition duration-500 hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="w-16 h-16 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center text-2xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition duration-300">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-gray-900">Auto-Kirim WhatsApp</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Import kontak tamu, generate nama spesifik di cover undangan, dan kirim masal via WhatsApp hanya
                        dengan satu klik.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="group p-10 rounded-[2.5rem] bg-white border border-gray-100 shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] transition duration-500 hover:-translate-y-2"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="w-16 h-16 rounded-2xl bg-arvaya-50 text-arvaya-600 flex items-center justify-center text-2xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition duration-300">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="font-serif text-2xl font-bold mb-4 text-gray-900">Amplop Digital & QR</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        Terima hadiah cashless dengan elegan. Support QRIS, Bank Transfer, dan konfirmasi otomatis ke
                        dashboard Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- LIVEWIRE TEMPLATE SLIDER SECTION (removed as requested) -->

    <!-- TEMPLATE GRID WITH SEARCH -->
    <section id="themes" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
                <div>
                    <h2 class="font-serif text-4xl font-bold text-arvaya-900">Jelajahi Tema</h2>
                    <p class="text-gray-600">Cari tema sesuai vibe dan lihat fitur per tier.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div
                        class="flex items-center gap-3 rounded-xl bg-[#F9F7F2] border border-[#E6D9B8] px-3 py-2 focus-within:border-[#B89760] focus-within:ring-1 focus-within:ring-[#B89760]">
                        <i class="fa-solid fa-magnifying-glass text-[#B89760]"></i>
                        <input type="text" wire:model.live="search" placeholder="Cari nama/slug/kategori..."
                            class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-sm text-[#5E4926]">
                        <span wire:loading wire:target="search" class="text-[#B89760]">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                        </span>
                    </div>
                    <select wire:model.live="tier"
                        class="rounded-xl border-[#E6D9B8] text-sm focus:border-[#B89760] focus:ring-[#B89760]">
                        <option value="all">Semua Tier</option>
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="exclusive">Exclusive</option>
                    </select>
                </div>
            </div>

            @php $basicFeatures = $tiers['basic']['features'] ?? []; @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @forelse ($templates as $tpl)
                    @php
                        $tierMeta = $tiers[$tpl->tier] ?? ['features' => []];
                        $upgrades = array_values(array_diff($tierMeta['features'], $basicFeatures));
                    @endphp
                    <div class="group cursor-pointer">
                        <div
                            class="aspect-[9/16] rounded-3xl overflow-hidden relative border-2 border-[#E6D9B8] bg-white transition-all hover:border-[#B89760] hover:shadow-xl">
                            @if ($tpl->thumbnail)
                                <img src="{{ asset('storage/' . $tpl->thumbnail) }}" alt="{{ $tpl->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-[#F2ECDC] flex items-center justify-center text-[#C6AC80]">
                                    <i class="fa-solid fa-image text-3xl mb-2"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span
                                    class="px-2 py-0.5 text-xs rounded-full bg-arvaya-500 text-white uppercase">{{ $tpl->tier }}</span>
                                @if (count($upgrades))
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-indigo-500 text-white">Upgrades</span>
                                @endif
                            </div>
                            @if (count($upgrades))
                                <div
                                    class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/60 to-transparent text-white opacity-0 group-hover:opacity-100 transition">
                                    <div class="text-xs">Fitur tambahan:</div>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach ($upgrades as $f)
                                            <span
                                                class="px-2 py-0.5 text-[10px] rounded-full bg-white/20 backdrop-blur">{{ str_replace('_', ' ', $f) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                <a href="{{ route('invitation.show', $tpl->slug) }}"
                                    class="px-4 py-2 bg-white text-arvaya-900 rounded-full text-sm font-bold shadow hover:bg-arvaya-400 hover:text-white transition">
                                    <i class="fa-solid fa-eye mr-1"></i> Preview
                                </a>
                                <a href="{{ route('dashboard.create') }}"
                                    class="px-4 py-2 border border-white text-white rounded-full text-sm font-bold hover:bg-white hover:text-arvaya-900 transition">
                                    Pilih Tema
                                </a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="font-serif font-bold text-[#2B1D0E]">{{ $tpl->name }}</div>
                            <div class="text-sm text-[#7C6339]">{{ $tpl->category ?? 'Wedding' }}</div>
                            <div class="text-xs text-[#9A7D4C]">Rp {{ number_format($tpl->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">Tidak ada template ditemukan.</div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- PRICING SECTION (New Addition for "The Best" feel) -->
    <section id="pricing" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="font-serif text-4xl font-bold mb-4 text-arvaya-900">Investasi Terbaik</h2>
                <p class="text-gray-500">Harga transparan, tanpa biaya tersembunyi. Aktif selamanya.</p>
            </div>

            <div class="flex flex-col md:flex-row justify-center gap-8 max-w-5xl mx-auto">
                <!-- Basic Plan -->
                <div class="flex-1 p-8 rounded-[2rem] bg-white border border-gray-200 hover:border-arvaya-200 transition relative group"
                    data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Paket Love</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-900 mb-6">Rp 150.000</div>
                    <ul class="space-y-4 text-gray-600 text-sm mb-8">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Masa
                            Aktif 6 Bulan</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Unlimited
                            Tamu Undangan</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Berbagai
                            Pilihan
                            Tema Basic</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Backsound
                            Musik</li>

                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Fitur
                            Reservasi</li>
                    </ul>
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="block w-full py-3 rounded-full border border-arvaya-900 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">Mulai
                            di Dashboard</a>
                    @endauth
                    @guest
                        <div class="flex gap-3">
                            <a href="{{ route('register') }}"
                                class="flex-1 py-3 rounded-full bg-arvaya-900 text-white font-bold text-center hover:bg-arvaya-800 transition">Daftar</a>
                            <a href="{{ route('login') }}"
                                class="flex-1 py-3 rounded-full border border-arvaya-900 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">Masuk</a>
                        </div>
                    @endguest
                </div>

                <!-- Pro Plan (Highlight) -->
                <div class="flex-1 p-8 rounded-[2rem] bg-arvaya-900 text-white shadow-2xl relative transform md:-translate-y-4"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute top-0 right-0 bg-arvaya-500 text-white text-xs font-bold px-4 py-1 rounded-bl-xl rounded-tr-[2rem]">
                        BEST SELLER</div>
                    <h3 class="font-bold text-arvaya-200 text-lg mb-2">Paket Eternal</h3>
                    <div class="text-4xl font-serif font-bold text-white mb-6">Rp 350.000</div>
                    <ul class="space-y-4 text-arvaya-100 text-sm mb-8">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-arvaya-400"></i> <b>Masa
                                Aktif Selamanya</b></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-arvaya-400"></i>
                            <b>Unlimited</b> Tamu Undangan
                        </li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-arvaya-400"></i> <b>Semua
                                Tema Premium</b></li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-arvaya-400"></i>
                            Prioritas Support WhatsApp</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-arvaya-400"></i> Custom
                            Domain (Optional)</li>
                    </ul>
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="block w-full py-3 rounded-full bg-arvaya-500 text-white font-bold text-center hover:bg-arvaya-400 transition shadow-lg shadow-arvaya-500/30">Mulai
                            di Dashboard</a>
                    @endauth
                    @guest
                        <div class="flex gap-3">
                            <a href="{{ route('register') }}"
                                class="flex-1 py-3 rounded-full bg-arvaya-500 text-white font-bold text-center hover:bg-arvaya-400 transition">Daftar</a>
                            <a href="{{ route('login') }}"
                                class="flex-1 py-3 rounded-full bg-white text-arvaya-900 border border-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">Masuk</a>
                        </div>
                    @endguest
                </div>

                <!-- Custom Plan -->
                <div class="flex-1 p-8 rounded-[2rem] bg-white border border-gray-200 hover:border-arvaya-200 transition"
                    data-aos="fade-up" data-aos-delay="300">
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Custom Design</h3>
                    <div class="text-4xl font-serif font-bold text-arvaya-900 mb-6">Call Us</div>
                    <ul class="space-y-4 text-gray-600 text-sm mb-8">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Desain
                            Request Sendiri</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i> Fitur
                            Custom (RSVP Khusus)</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-green-500"></i>
                            Pendampingan Input Data</li>
                    </ul>
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="block w-full py-3 rounded-full border border-arvaya-900 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">Mulai
                            di Dashboard</a>
                    @endauth
                    @guest
                        <div class="flex gap-3">
                            <a href="{{ route('register') }}"
                                class="flex-1 py-3 rounded-full bg-arvaya-900 text-white font-bold text-center hover:bg-arvaya-800 transition">Daftar</a>
                            <a href="{{ route('login') }}"
                                class="flex-1 py-3 rounded-full border border-arvaya-900 text-arvaya-900 font-bold text-center hover:bg-arvaya-50 transition">Masuk</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>
    <!-- TESTIMONIALS (Marquee) -->
    <section id="testimonials" class="py-24 bg-arvaya-50 overflow-hidden border-t border-arvaya-100">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="font-serif text-3xl font-bold text-arvaya-900">Kata Mereka</h2>
        </div>
        <div class="relative w-full overflow-hidden mask-gradient-x">
            <div class="flex animate-marquee gap-6 w-max hover:[animation-play-state:paused]">
                <!-- Item 1 -->
                <div class="w-96 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex text-yellow-400 mb-4 text-xs gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed italic">"Gila sih, fiturnya lengkap banget!
                        Tamu pada muji undangannya estetik parah. Fitur kirim WA-nya ngebantu banget manage tamu VIP."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=32" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <div class="text-sm font-bold text-arvaya-900">Sarah & Dimas</div>
                            <div class="text-xs text-gray-400">Jakarta</div>
                        </div>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="w-96 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex text-yellow-400 mb-4 text-xs gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed italic">"Simpel banget dashboardnya. Aku ga
                        ngerti IT tapi bisa bikin undangan yang sebagus ini cuma 10 menit."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=12" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <div class="text-sm font-bold text-arvaya-900">Raka & Bella</div>
                            <div class="text-xs text-gray-400">Bandung</div>
                        </div>
                    </div>
                </div>
                <!-- Item 3 -->
                <div class="w-96 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex text-yellow-400 mb-4 text-xs gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed italic">"Worth every penny. Customer
                        servicenya ramah banget pas aku nanya cara ganti musik."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=53" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <div class="text-sm font-bold text-arvaya-900">Andi & Citra</div>
                            <div class="text-xs text-gray-400">Surabaya</div>
                        </div>
                    </div>
                </div>
                <!-- Clone for Loop -->
                <div class="w-96 p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex text-yellow-400 mb-4 text-xs gap-1"><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed italic">"Gila sih, fiturnya lengkap banget!
                        Tamu pada muji undangannya estetik parah."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=32" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <div class="text-sm font-bold text-arvaya-900">Sarah & Dimas</div>
                            <div class="text-xs text-gray-400">Jakarta</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CONTACT SECTION -->
    <section id="contact" class="py-24 bg-white border-t border-arvaya-100">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-10">
                <h2 class="font-serif text-3xl font-bold text-arvaya-900">Hubungi Kami</h2>
                <p class="text-gray-600">Tim kami siap membantu kapan pun dibutuhkan.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-white border border-arvaya-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-2"><i
                            class="fa-solid fa-envelope text-arvaya-500"></i><span class="font-bold">Email</span>
                    </div>
                    <a href="mailto:admin@arvayadeaure.com" class="text-sm text-arvaya-900">admin@arvayadeaure.com</a>
                </div>
                <div class="p-6 bg-white border border-arvaya-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-2"><i class="fa-solid fa-phone text-arvaya-500"></i><span
                            class="font-bold">Telepon</span></div>
                    <a href="https://wa.me/6282260894009" target="_blank"
                        class="text-sm text-arvaya-900">082260894009</a>
                </div>
                <div class="p-6 bg-white border border-arvaya-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-2"><i
                            class="fa-solid fa-location-dot text-arvaya-500"></i><span class="font-bold">Alamat</span>
                    </div>
                    <p class="text-sm text-arvaya-900">Perum Dyah Residence I no D6, Tonjong, Kab. Bogor, Bogor</p>
                </div>
                <div class="p-6 bg-white border border-arvaya-100 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-2"><i
                            class="fa-brands fa-instagram text-arvaya-500"></i><span
                            class="font-bold">Instagram</span></div>
                    <a href="https://instagram.com/arvaya.id" target="_blank"
                        class="text-sm text-arvaya-900">@arvaya.id</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FLOATING WHATSAPP BUTTON -->
    <a href="https://wa.me/6282260894009" target="_blank"
        class="fixed bottom-6 right-6 z-50 bg-green-500 text-white px-4 py-3 rounded-full shadow-xl border-2 border-white flex items-center gap-2 hover:bg-green-600 transition">
        <i class="fa-brands fa-whatsapp text-xl"></i>
        Chat Admin
    </a>
</div>
