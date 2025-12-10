<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Arvaya De Aure') }} - Dashboard</title>

    <!-- Fonts (Sama seperti Landing Page) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
    
    <style>
        [x-cloak] { display: none !important; }
        .font-display { font-family: 'Cinzel Decorative', cursive; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Glass Effect */
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(230, 217, 184, 0.6);
        }
    </style>
</head>
<body class="font-sans h-screen flex antialiased bg-[#F9F7F2] text-[#5E4926] overflow-hidden" x-data="{ sidebarOpen: false }" x-cloak>

    <!-- MOBILE OVERLAY BACKDROP -->
    <!-- Muncul hanya di mobile saat menu dibuka -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-[#2D2418]/60 lg:hidden backdrop-blur-sm">
    </div>

    <!-- SIDEBAR -->
    <!-- 
         Mobile: Fixed position, z-50 (paling atas).
         Desktop (lg): Static position (ikut aliran flex), z-auto.
         shrink-0: Agar lebar sidebar tidak mengecil.
    -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-[#F9F7F2] glass-sidebar transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:inset-auto shrink-0 flex flex-col shadow-xl lg:shadow-none">
        
        <!-- Decoration Blobs (Hiasan) -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#E6D9B8] rounded-full mix-blend-multiply filter blur-3xl opacity-30 pointer-events-none"></div>
        <div class="absolute bottom-0 -right-10 w-56 h-56 bg-[#B89760] rounded-full mix-blend-multiply filter blur-3xl opacity-10 pointer-events-none"></div>

        <!-- LOGO HEADER -->
        <div class="flex items-center justify-center h-20 border-b border-[#E6D9B8]/50 relative z-10 shrink-0">
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 group px-4">
                <div class="w-10 h-10 rounded-full border border-[#B89760] flex items-center justify-center text-[#B89760] group-hover:bg-[#B89760] group-hover:text-white transition duration-500 shadow-sm">
                    <span class="font-display font-bold text-lg">A</span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="font-serif font-bold text-xl tracking-widest leading-none text-[#5E4926]">ARVAYA</span>
                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#9A7D4C]">de aure</span>
                </div>
            </a>
        </div>

        <!-- NAVIGATION MENU (Scrollable area) -->
        <nav class="flex-1 overflow-y-auto p-5 space-y-2 relative z-10 custom-scrollbar">
            
            <a href="{{ route('dashboard.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
               {{ request()->routeIs('dashboard.index') 
                  ? 'bg-white shadow-sm border border-[#E6D9B8] text-[#9A7D4C]' 
                  : 'text-[#7C6339] hover:bg-white/60 hover:text-[#9A7D4C]' }}">
                <div class="w-6 text-center">
                    <i class="fa-solid fa-house {{ request()->routeIs('dashboard.index') ? 'text-[#B89760]' : 'text-[#C6AC80] group-hover:text-[#B89760]' }}"></i>
                </div>
                <span class="font-medium text-sm tracking-wide">Dashboard</span>
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-[10px] font-bold text-[#C6AC80] uppercase tracking-widest">Project Space</p>
            </div>

            @if(request()->route('invitation'))
                {{-- MENU SAAT EDIT UNDANGAN --}}
                <a href="{{ route('dashboard.invitation.edit', request()->route('invitation')) }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                   {{ request()->routeIs('dashboard.invitation.edit') 
                      ? 'bg-white shadow-sm border border-[#E6D9B8] text-[#9A7D4C]' 
                      : 'text-[#7C6339] hover:bg-white/60 hover:text-[#9A7D4C]' }}">
                    <div class="w-6 text-center">
                        <i class="fa-solid fa-pen-to-square {{ request()->routeIs('dashboard.invitation.edit') ? 'text-[#B89760]' : 'text-[#C6AC80] group-hover:text-[#B89760]' }}"></i>
                    </div>
                    <span class="font-medium text-sm tracking-wide">Edit Informasi</span>
                </a>

                <a href="{{ route('dashboard.guests.index', request()->route('invitation')) }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                   {{ request()->routeIs('dashboard.guests.*') 
                      ? 'bg-white shadow-sm border border-[#E6D9B8] text-[#9A7D4C]' 
                      : 'text-[#7C6339] hover:bg-white/60 hover:text-[#9A7D4C]' }}">
                    <div class="w-6 text-center">
                        <i class="fa-solid fa-users {{ request()->routeIs('dashboard.guests.*') ? 'text-[#B89760]' : 'text-[#C6AC80] group-hover:text-[#B89760]' }}"></i>
                    </div>
                    <span class="font-medium text-sm tracking-wide">Data Tamu</span>
                </a>

                <a href="{{ route('dashboard.messages.index', request()->route('invitation')) }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group
                   {{ request()->routeIs('dashboard.messages.*') 
                      ? 'bg-white shadow-sm border border-[#E6D9B8] text-[#9A7D4C]' 
                      : 'text-[#7C6339] hover:bg-white/60 hover:text-[#9A7D4C]' }}">
                    <div class="w-6 text-center">
                        <i class="fa-solid fa-envelope-open-text {{ request()->routeIs('dashboard.messages.*') ? 'text-[#B89760]' : 'text-[#C6AC80] group-hover:text-[#B89760]' }}"></i>
                    </div>
                    <span class="font-medium text-sm tracking-wide">Ucapan & Doa</span>
                </a>
            @else
                {{-- MENU DEFAULT --}}
                <a href="{{ route('dashboard.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group hover:bg-white/60 hover:text-[#9A7D4C] text-[#7C6339]">
                    <div class="w-6 text-center">
                        <i class="fa-solid fa-plus text-[#C6AC80] group-hover:text-[#B89760]"></i>
                    </div>
                    <span class="font-medium text-sm tracking-wide">Buat Undangan Baru</span>
                </a>
            @endif
        </nav>
        
        <!-- USER PROFILE FOOTER -->
        <div class="border-t border-[#E6D9B8]/50 p-5 bg-[#F2ECDC]/30 relative z-10 shrink-0">
             <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#E6D9B8] to-[#C6AC80] flex items-center justify-center text-white font-serif font-bold text-lg shadow-sm shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden min-w-0">
                    <p class="text-sm font-bold text-[#5E4926] truncate">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-[#9A7D4C] hover:text-[#B89760] transition flex items-center gap-1">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-y-scroll h-screen bg-[#F9F7F2]">
        
        <!-- TOP HEADER -->
        <header class="h-20 flex items-center justify-between px-6 lg:px-10 bg-[#F9F7F2]/80 backdrop-blur-md sticky top-0 z-20 border-b border-[#E6D9B8]/30 shrink-0">
            <div class="flex items-center gap-4">
                <!-- Hamburger Button (Mobile Only) -->
                <button @click="sidebarOpen = true" class="lg:hidden text-[#9A7D4C] hover:text-[#B89760] focus:outline-none transition p-1">
                    <i class="fa-solid fa-bars-staggered text-2xl"></i>
                </button>
                
                <!-- Page Title -->
                <h2 class="font-serif font-bold text-2xl text-[#5E4926] tracking-tight">
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

    @livewireScripts
</body>
</html>