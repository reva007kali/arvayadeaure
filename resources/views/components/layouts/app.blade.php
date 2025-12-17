<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arvaya De Aure') }} - Dashboard</title>

    {{-- <link rel="icon" href="/favicon.ico" sizes="any"> --}}
    <link rel="icon" href="/logo.png" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/logo.png">

    <!-- Fonts (Sama seperti Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans h-screen flex antialiased bg-white text-[#5E4926]" x-data="{ sidebarOpen: false }" x-cloak>

    <!-- MOBILE OVERLAY BACKDROP -->
    <!-- Muncul hanya di mobile saat menu dibuka -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-[#5E4926]/20 lg:hidden backdrop-blur-sm">
    </div>

    <!-- SIDEBAR -->
    <!--
         Mobile: Fixed position, z-50 (paling atas).
         Desktop (lg): Static position (ikut aliran flex), z-auto.
         shrink-0: Agar lebar sidebar tidak mengecil.
    -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-arvaya-200 border-r border-[#E6D9B8] transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:inset-auto shrink-0 flex flex-col shadow-xl lg:shadow-none">

        <!-- Decoration Blobs (Hiasan) -->
        <div
            class="absolute -top-10 -left-10 w-40 h-40 bg-[#E6D9B8] rounded-full mix-blend-multiply filter blur-3xl opacity-30 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 -right-10 w-56 h-56 bg-[#B89760] rounded-full mix-blend-multiply filter blur-3xl opacity-10 pointer-events-none">
        </div>

        <!-- LOGO HEADER -->
        <div class="flex items-center justify-center h-20 border-b border-[#E6D9B8]/50 relative z-10 shrink-0 bg-white">
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 group px-4">
                <div
                    class="w-10 h-10 rounded-full border border-[#B89760] flex items-center justify-center text-[#B89760] group-hover:bg-[#B89760] group-hover:text-white transition duration-500 shadow-sm">
                    <span class="font-display font-bold text-lg">A</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="font-serif font-bold text-xl tracking-widest leading-none text-[#5E4926]">ARVAYA</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#C6AC80]">de aure</span>
                </div>
            </a>
        </div>

        <!-- NAVIGATION MENU (Scrollable area) -->
        <nav class="flex-1 overflow-y-auto p-5 space-y-2 relative z-10 custom-scrollbar">

            {{-- ================= MENU ADMIN ================= --}}
            @if (auth()->user()->role === 'admin')

                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
           {{ request()->routeIs('dashboard.index') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-house"></i></div>
                    <span class="font-medium text-sm tracking-wide">Dashboard</span>
                </a>

                <p class="px-4 text-[10px] font-bold text-[#C6AC80] uppercase tracking-widest mb-2">Administrator</p>

                <a href="{{ route('admin.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
           {{ request()->routeIs('admin.index') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-chart-line"></i></div>
                    <span class="font-medium text-sm tracking-wide">Overview</span>
                </a>

                <a href="{{ route('admin.users') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
           {{ request()->routeIs('admin.users') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-users-gear"></i></div>
                    <span class="font-medium text-sm tracking-wide">Kelola User</span>
                </a>

                <a href="{{ route('admin.invitations') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
           {{ request()->routeIs('admin.invitations') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-list-check"></i></div>
                    <span class="font-medium text-sm tracking-wide">Semua Undangan</span>
                </a>

                <a href="{{ route('admin.templates') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
   {{ request()->routeIs('admin.templates') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-swatchbook"></i></div>
                    <span class="font-medium text-sm tracking-wide">Kelola Template</span>
                </a>

                <a href="{{ route('admin.transactions') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
   {{ request()->routeIs('admin.transactions') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <span class="font-medium text-sm tracking-wide">Transaksi</span>

                    {{-- Badge Notifikasi jika ada Pending --}}
                    @if (\App\Models\Invitation::where('payment_status', 'pending')->count() > 0)
                        <span wire:poll.5s
                            class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse">
                            {{ \App\Models\Invitation::where('payment_status', 'pending')->count() }}
                        </span>
                    @endif
                </a>

                @if (request()->route('invitation'))
                    {{-- Menu Edit Undangan (Sama seperti kode sebelumnya) --}}
                    <p class="px-4 text-[10px] font-bold text-[#7C6339] uppercase tracking-widest mb-2">Manage Undangan
                    </p>


                    <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.invitation.edit') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-pen-to-square"></i></div>
                        <span class="font-medium text-sm tracking-wide">Edit Informasi</span>
                    </a>

                    <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.guests.*') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-users"></i></div>
                        <span class="font-medium text-sm tracking-wide">Data Tamu</span>
                    </a>

                    <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.messages.*') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <span class="font-medium text-sm tracking-wide">Ucapan & Doa</span>
                    </a>
                @else
                    <a href="{{ route('dashboard.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-[#F9F7F2] hover:text-[#B89760] text-[#5E4926]">
                        <div class="w-6 text-center"><i
                                class="fa-solid fa-plus text-[#C6AC80] group-hover:text-[#B89760]"></i></div>
                        <span class="font-medium text-sm tracking-wide">Buat Undangan Baru</span>
                    </a>
                @endif
                {{-- ================= MENU USER BIASA ================= --}}
            @else
                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
           {{ request()->routeIs('dashboard.index') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                    <div class="w-6 text-center"><i class="fa-solid fa-house"></i></div>
                    <span class="font-medium text-sm tracking-wide">Dashboard</span>
                </a>

                <div class="pt-6 pb-2">
                    <p class="px-4 text-[10px] font-bold text-[#7C6339] uppercase tracking-widest">Project Space</p>
                </div>

                @if (request()->route('invitation'))
                    {{-- Menu Edit Undangan (Sama seperti kode sebelumnya) --}}
                    <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.invitation.edit') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-pen-to-square"></i></div>
                        <span class="font-medium text-sm tracking-wide">Edit Informasi</span>
                    </a>

                    <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.guests.*') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-users"></i></div>
                        <span class="font-medium text-sm tracking-wide">Data Tamu</span>
                    </a>

                    <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard.messages.*') ? 'bg-[#F9F7F2] shadow-sm border border-[#E6D9B8] text-[#B89760]' : 'text-[#5E4926] hover:bg-[#F9F7F2] hover:text-[#B89760]' }}">
                        <div class="w-6 text-center"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <span class="font-medium text-sm tracking-wide">Ucapan & Doa</span>
                    </a>
                @else
                    <a href="{{ route('dashboard.create') }}" wire:navigate
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-[#F9F7F2] hover:text-[#B89760] text-[#5E4926]">
                        <div class="w-6 text-center"><i
                                class="fa-solid fa-plus text-[#C6AC80] group-hover:text-[#B89760]"></i></div>
                        <span class="font-medium text-sm tracking-wide">Buat Undangan Baru</span>
                    </a>
                @endif

            @endif

        </nav>

        <!-- USER PROFILE FOOTER -->
        <div class="border-t border-[#E6D9B8]/50 p-5 bg-[#F9F7F2] relative z-10 shrink-0">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-[#E6D9B8] to-[#C6AC80] flex items-center justify-center text-white font-serif font-bold text-lg shadow-sm shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden min-w-0">
                    <p class="text-sm font-bold text-[#5E4926] truncate">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-xs text-[#C6AC80] hover:text-[#B89760] transition flex items-center gap-1">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-y-hidden h-svh bg-white">

        <!-- TOP HEADER -->
        <header
            class="h-20 flex items-center justify-between px-6 lg:px-10 bg-arvaya-200 sticky top-0 z-20 border-b border-[#F2ECDC] shrink-0">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="sidebarOpen = true"
                    class="lg:hidden text-[#C6AC80] hover:text-[#B89760] focus:outline-none transition p-1">
                    <i class="fa-solid fa-bars-staggered text-2xl"></i>
                </button>

                <!-- Page Title -->
                <h2 class="font-serif font-bold lg:text-4xl text-2xl text-arvaya-700 tracking-tight">
                    {{ $header ?? 'Dashboard' }}
                </h2>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                {{ $actions ?? '' }}
            </div>
        </header>

        <!-- SCROLLABLE CONTENT -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-10 relative custom-scrollbar">
            <!-- Toast Notifications -->
            <x-notification-toast />

            <!-- Livewire Content -->
            <div class="animate-fade-in-up">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
