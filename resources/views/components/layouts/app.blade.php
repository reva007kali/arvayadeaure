<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arvaya De Aure') }} - Dashboard</title>

    {{-- PWA & SEO Meta Tags --}}
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Arvaya De Aure - Undangan Pernikahan Digital Premium dengan AI Assistant">
    <meta name="keywords" content="undangan digital, wedding invitation, arvaya, ai wedding, pwa">
    <meta property="og:title" content="Arvaya De Aure | Dashboard">
    <meta property="og:description" content="Kelola undangan pernikahan digital Anda dengan mudah.">
    <meta property="og:image" content="/logo.png">
    <meta property="og:type" content="website">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/logo.png">
    <link rel="apple-touch-icon" href="/logo.png">

    <!-- Fonts (Sama seperti Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans h-screen flex antialiased bg-[#121212] text-[#E0E0E0]" x-data="{ sidebarOpen: false }" x-cloak>

    <!-- MOBILE OVERLAY BACKDROP -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden backdrop-blur-sm">
    </div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-[55] w-72 bg-[#1a1a1a] border-r border-[#333333] transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:inset-auto shrink-0 flex flex-col shadow-xl lg:shadow-none">

        <!-- Decoration Blobs (Hiasan) -->
        <div
            class="absolute -top-10 -left-10 w-40 h-40 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-3xl opacity-10 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 -right-10 w-56 h-56 bg-[#D4AF37] rounded-full mix-blend-overlay filter blur-3xl opacity-5 pointer-events-none">
        </div>
        <!-- Decoration Blobs (Hiasan) -->


        <!-- LOGO HEADER -->
        <div
            class="flex items-center justify-center h-20 border-b border-[#333333] relative z-10 shrink-0 bg-[#1a1a1a]">
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 group px-4">
                <div
                    class="w-10 h-10 rounded-full border border-[#D4AF37] flex items-center justify-center text-[#D4AF37] group-hover:bg-[#D4AF37] group-hover:text-[#121212] transition duration-500 shadow-sm">
                    <span class="font-display font-bold text-lg">A</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="font-serif font-bold text-xl tracking-widest leading-none text-[#D4AF37]">ARVAYA</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#888888]">de aure</span>
                </div>
            </a>
        </div>

        <!-- NAVIGATION MENU (Scrollable area) -->
        <nav class="flex-1 overflow-y-auto p-5 space-y-2 relative z-10 custom-scrollbar">

            {{-- ================= MENU ADMIN ================= --}}
            @if (auth()->user()->role === 'admin')

                {{-- Dashboard --}}
                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                                                   {{ request()->routeIs('dashboard.index') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-house"></i></div>
                    <span class="font-medium text-sm tracking-wide">Dashboard</span>
                </a>

                {{-- Overview --}}
                <a href="{{ route('admin.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                                                   {{ request()->routeIs('admin.index') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-chart-line"></i></div>
                    <span class="font-medium text-sm tracking-wide">Overview</span>
                </a>

                {{-- Group Admin --}}
                <div x-data="{ open: {{ request()->routeIs('admin.*') && !request()->routeIs('admin.index') ? 'true' : 'false' }} }"
                    class="space-y-1">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl transition-all duration-300 group text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]">
                        <div class="flex items-center gap-3">
                            <div class="w-6 text-center"><i class="fa-solid fa-user-shield"></i></div>
                            <span class="font-medium text-sm tracking-wide">Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="open" x-collapse class="pl-4 space-y-1">
                        <a href="{{ route('admin.users') }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 group
                                                           {{ request()->routeIs('admin.users') ? 'text-[#D4AF37] bg-[#252525]/50' : 'text-[#888] hover:text-[#D4AF37]' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users') ? 'bg-[#D4AF37]' : 'bg-[#666] group-hover:bg-[#D4AF37]' }}"></span>
                            <span class="font-medium text-xs tracking-wide">Kelola User</span>
                        </a>

                        <a href="{{ route('admin.invitations') }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 group
                                                           {{ request()->routeIs('admin.invitations') ? 'text-[#D4AF37] bg-[#252525]/50' : 'text-[#888] hover:text-[#D4AF37]' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.invitations') ? 'bg-[#D4AF37]' : 'bg-[#666] group-hover:bg-[#D4AF37]' }}"></span>
                            <span class="font-medium text-xs tracking-wide">Semua Undangan</span>
                        </a>

                        <a href="{{ route('admin.templates') }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 group
                                                           {{ request()->routeIs('admin.templates') ? 'text-[#D4AF37] bg-[#252525]/50' : 'text-[#888] hover:text-[#D4AF37]' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.templates') ? 'bg-[#D4AF37]' : 'bg-[#666] group-hover:bg-[#D4AF37]' }}"></span>
                            <span class="font-medium text-xs tracking-wide">Kelola Template</span>
                        </a>

                        <a href="{{ route('admin.transactions') }}" wire:navigate
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 group
                                                           {{ request()->routeIs('admin.transactions') ? 'text-[#D4AF37] bg-[#252525]/50' : 'text-[#888] hover:text-[#D4AF37]' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.transactions') ? 'bg-[#D4AF37]' : 'bg-[#666] group-hover:bg-[#D4AF37]' }}"></span>
                            <span class="font-medium text-xs tracking-wide">Transaksi</span>

                            @if (\App\Models\Invitation::where('payment_status', 'pending')->count() > 0)
                                <span class="ml-auto bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                                    {{ \App\Models\Invitation::where('payment_status', 'pending')->count() }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                @if (request()->route('invitation'))
                    <div class="my-4 border-t border-[#333333]"></div>
                    <p class="px-4 text-[10px] font-bold text-[#666] uppercase tracking-widest mb-2">Manage Undangan</p>

                    <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.invitation.edit') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-pen-to-square"></i></div>
                        <span class="font-medium text-sm tracking-wide">Edit Informasi</span>
                    </a>

                    <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.guests.*') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-users"></i></div>
                        <span class="font-medium text-sm tracking-wide">Data Tamu</span>
                    </a>

                    <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.messages.*') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <span class="font-medium text-sm tracking-wide">Ucapan & Doa</span>
                    </a>
                @else
                    <a href="{{ route('dashboard.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-[#252525] hover:text-[#D4AF37] text-[#A0A0A0]">
                        <div class="w-6 text-center"><i class="fa-solid fa-plus text-[#666] group-hover:text-[#D4AF37]"></i>
                        </div>
                        <span class="font-medium text-sm tracking-wide">Buat Undangan Baru</span>
                    </a>
                @endif

                {{-- ================= MENU USER BIASA ================= --}}
            @else
                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                                                                                       {{ request()->routeIs('dashboard.index') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-house"></i></div>
                    <span class="font-medium text-sm tracking-wide">Dashboard</span>
                </a>

                <div class="pt-6 pb-2">
                    <p class="px-4 text-[10px] font-bold text-[#666] uppercase tracking-widest">Project Space</p>
                </div>

                @if (request()->route('invitation'))
                    {{-- Menu Edit Undangan (Sama seperti kode sebelumnya) --}}
                    <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.invitation.edit') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-pen-to-square"></i></div>
                        <span class="font-medium text-sm tracking-wide">Edit Informasi</span>
                    </a>

                    <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.guests.*') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-users"></i></div>
                        <span class="font-medium text-sm tracking-wide">Data Tamu</span>
                    </a>

                    <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.messages.*') ? 'bg-[#252525] shadow-sm border border-[#D4AF37]/30 text-[#D4AF37]' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#D4AF37]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <span class="font-medium text-sm tracking-wide">Ucapan & Doa</span>
                    </a>
                @else
                    <a href="{{ route('dashboard.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-[#252525] hover:text-[#D4AF37] text-[#A0A0A0]">
                        <div class="w-6 text-center"><i class="fa-solid fa-plus text-[#666] group-hover:text-[#D4AF37]"></i>
                        </div>
                        <span class="font-medium text-sm tracking-wide">Buat Undangan Baru</span>
                    </a>
                @endif

            @endif

        </nav>

        <!-- USER PROFILE FOOTER -->
        <div class="border-t border-[#333333] p-5 bg-[#1a1a1a] relative z-10 shrink-0">
            <div class="flex items-center gap-3">
                @if (auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full object-cover border border-[#D4AF37] shadow-sm shrink-0">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] font-serif font-bold text-lg shadow-sm shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="overflow-hidden min-w-0">
                    <p class="text-sm font-bold text-[#E0E0E0] truncate">{{ explode(' ', auth()->user()->name)[0] }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-xs text-[#888] hover:text-[#D4AF37] transition flex items-center gap-1">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <!--
         flex-1: Mengambil sisa ruang (kanan).
         flex-col: Mengatur header dan konten secara vertikal.
         overflow-hidden: Agar scroll hanya terjadi di dalam area konten (bukan seluruh window).
    -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-hidden h-svh bg-arvaya-bg">

        <!-- TOP HEADER -->
        <header
            class="py-4 flex items-center justify-between lg:justify-end px-6 lg:px-10 bg-arvaya-bg border-b border-[#333333] sticky top-0 z-20 shrink-0">
            <div class="flex items-center gap-4">
                @if (auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full object-cover border border-[#D4AF37] shadow-sm shrink-0">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] font-serif font-bold text-lg shadow-sm shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <!-- Page Title -->
                <h2 class="font-sans lg:text-xl text-xl text-white tracking-tight">
                    Hello, <span class="text-arvaya-300">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    <span class="text-sm text-[#888] block">{{ auth()->user()->email }}</span>
                </h2>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="sidebarOpen = true"
                    class="lg:hidden text-[#888] hover:text-[#D4AF37] focus:outline-none transition p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="1" y="1" width="10" height="10" rx="3" fill="white" />
                        <rect x="13" y="1" width="10" height="10" rx="3" fill="white" />
                        <rect x="1" y="13" width="10" height="10" rx="3" fill="white" />
                        <rect x="13" y="13" width="10" height="10" rx="3" fill="white" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-10 pb-24 lg:pb-10 relative custom-scrollbar">
            <!-- Toast Notifications -->
            <x-notification-toast />

            <!-- Livewire Content -->
            <div class="animate-fade-in-up">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- MOBILE BOTTOM NAVBAR (FIXED) -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 h-[80px]">
        {{-- Background with Cutout --}}
        <div class="absolute inset-0 bg-[#1a1a1a] shadow-[0_-5px_20px_rgba(0,0,0,0.5)] border-t border-[#333333]"
            style="-webkit-mask-image: radial-gradient(circle 38px at top center, transparent 36px, black 37px); mask-image: radial-gradient(circle 38px at top center, transparent 36px, black 37px);">
        </div>

        {{-- Nav Items Container --}}
        <div class="relative h-full flex justify-between items-center px-10 pb-2">

            {{-- Left Group --}}
            <div class="flex  gap-12">
                <a href="{{ route('dashboard.create') }}" wire:navigate
                    class="flex flex-col items-center gap-1 text-arvaya-400 hover:text-arvaya-300 transition">
                    <i class="fa-solid fa-circle-plus text-xl"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wider">Add</span>
                </a>
                <a href="{{ route('dashboard.notifications') }}" wire:navigate
                    class="flex flex-col items-center gap-1 text-arvaya-400 hover:text-arvaya-300 transition relative">
                    <i class="fa-solid fa-bell text-xl"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wider">Notif</span>

                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span
                            class="absolute top-0 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-[#1a1a1a]"></span>
                    @endif
                </a>
            </div>

            {{-- Center Floating Button (Home) --}}
            <div class="absolute -top-6 left-1/2 -translate-x-1/2">
                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="w-14 h-14 rounded-full bg-gradient-to-br from-arvaya-400 to-arvaya-500 flex items-center justify-center text-[#121212] shadow-[0_0_15px_rgba(212,175,55,0.4)] border-4 border-[#121212] transform transition active:scale-95">
                    <i class="fa-solid fa-house text-xl"></i>
                </a>
            </div>

            {{-- Right Group --}}
            <div class="flex gap-12">
                <a href="{{ route('dashboard.tips') }}" wire:navigate
                    class="flex flex-col items-center gap-1 text-arvaya-400 hover:text-arvaya-300 transition">
                    <i class="fa-solid fa-heart text-xl"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wider">Tips</span>
                </a>
                <a href="{{ route('dashboard.profile') }}" wire:navigate
                    class="flex flex-col items-center gap-1 text-arvaya-400 hover:text-arvaya-300 transition">
                    <i class="fa-solid fa-user text-xl"></i>
                    <span class="text-[9px] font-bold uppercase tracking-wider">Profile</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Sortable JS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(reg => console.log('SW registered!', reg.scope))
                    .catch(err => console.error('SW registration failed:', err));
            });
        }
    </script>
</body>

</html>