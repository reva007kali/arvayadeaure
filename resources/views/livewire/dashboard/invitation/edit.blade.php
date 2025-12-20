<div class=" animate-fade-in-up min-h-screen dashboard-ui">

    {{-- CSS Khusus untuk Scrollbar Modal agar rapi --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #333;
            border-radius: 8px;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    {{-- HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <div class="flex items-center gap-2 text-[#888] text-[10px] font-bold uppercase tracking-widest mb-1">
                    <a href="{{ route('dashboard.index') }}"
                        class="hover:text-[#D4AF37] transition flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left"></i> Dashboard
                    </a>
                    <span>/</span> <span>Editor</span>
                </div>
                <h2 class="font-serif font-bold text-2xl text-[#E0E0E0]">Studio Undangan</h2>
                <p class="text-[#A0A0A0] text-xs mt-1 flex items-center gap-2">
                    <span class="font-serif italic text-[#D4AF37]">{{ $invitation->title }}</span>
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                    class="px-4 py-2 bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] rounded-xl hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300 font-bold text-[10px] uppercase tracking-wide flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-eye"></i> Preview
                </a>
                <a href="{{ route('dashboard.guests.index', $invitation->id) }}" wire:navigate
                    class="px-4 py-2 text-center bg-[#1a1a1a] border border-[#333333] text-[#E0E0E0] rounded-xl hover:border-[#D4AF37] hover:text-[#D4AF37] transition-all duration-300 font-bold text-[10px] uppercase tracking-wide flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-user-group"></i> Kelola Tamu
                </a>
            </div>
        </div>

        {{-- ALERT --}}
        @if (session('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-[-10px]"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-[-10px]"
                class="fixed top-3 right-3 z-[9999] bg-[#1a1a1a] border-l-4 border-[#D4AF37] text-[#E0E0E0] px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 max-w-md">
                <div class="w-8 h-8 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-xs text-[#A0A0A0] mt-0.5">{{ session('message') }}</p>
                </div>
                <button @click="show = false" class="text-[#888] hover:text-[#E0E0E0] transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- MAIN CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- MENU NAVIGATION (Full Width on Mobile, Grid on Desktop) --}}
            <div class="lg:col-span-12">
                <div>
                    <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-5">
                        @php
                            $coupleLabel = match ($category) {
                                'Birthday' => 'Profil',
                                'Aqiqah', 'Khitan' => 'Data Anak',
                                'Engagement' => 'Pasangan',
                                'Event' => 'Detail Acara',
                                default => 'Mempelai'
                            };

                            $quoteLabel = match ($category) {
                                'Aqiqah', 'Khitan' => 'Doa & Harapan',
                                'Event' => 'Deskripsi Acara',
                                default => 'Kata Pengantar'
                            };

                            $menus = [
                                ['id' => 'couple_bio', 'icon' => 'fa-user-group', 'label' => $coupleLabel],
                                ['id' => 'couple_quote', 'icon' => 'fa-quote-left', 'label' => $quoteLabel],
                                ['id' => 'events', 'icon' => 'fa-calendar-days', 'label' => 'Acara'],
                                ['id' => 'gallery', 'icon' => 'fa-images', 'label' => 'Galeri'],
                                ['id' => 'gifts', 'icon' => 'fa-gift', 'label' => 'Kado'],
                                ['id' => 'theme', 'icon' => 'fa-palette', 'label' => 'Tema'],
                                ['id' => 'music', 'icon' => 'fa-music', 'label' => 'Musik'],
                                ['id' => 'dress_code', 'icon' => 'fa-shirt', 'label' => 'Dress Code'],
                            ];
                        @endphp

                        @foreach ($menus as $menu)
                                            <button wire:click="openModal('{{ $menu['id'] }}')"
                                                class="flex flex-col items-center justify-center gap-3 p-4 rounded-2xl transition-all duration-300 border border-[#1a1a1a]
                                                                                                                                                    {{ $activeTab === $menu['id']
                            ? 'bg-[#1a1a1a] text-arvaya-400 shadow-[inset_5px_5px_10px_#0d0d0d,inset_-5px_-5px_10px_#272727]'
                            : 'bg-[#1a1a1a] text-arvaya-400 shadow-[5px_5px_10px_#0d0d0d,-5px_-5px_10px_#272727] hover:text-[#D4AF37] hover:shadow-[inset_5px_5px_10px_#0d0d0d,inset_-5px_-5px_10px_#272727] hover:translate-y-0.5' }}">
                                                <div class="text-xl transition-all duration-300 transform group-hover:scale-110">
                                                    <i class="fa-solid {{ $menu['icon'] }}"></i>
                                                </div>
                                                <span class="text-[10px] font-bold uppercase tracking-wider">{{ $menu['label'] }}</span>
                                            </button>
                        @endforeach

                        <a href="{{ route('dashboard.guests.index', $invitation->id) }}" wire:navigate
                            class="flex flex-col items-center justify-center text-center gap-3 p-4 rounded-2xl transition-all duration-300 border border-[#1a1a1a] bg-[#1a1a1a] text-arvaya-400 shadow-[5px_5px_10px_#0d0d0d,-5px_-5px_10px_#272727] hover:text-[#D4AF37] hover:shadow-[inset_5px_5px_10px_#0d0d0d,inset_-5px_-5px_10px_#272727] hover:translate-y-0.5">
                            <div class="text-xl transition-all duration-300">
                                <i class="fa-solid fa-user-group"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Kelola Tamu</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL AREA --}}
        <div wire:loading.delay wire:target="openModal"
            class="fixed inset-0 z-[9999] bg-black/50 backdrop-blur-sm flex items-center justify-center">
            <div class="bg-[#1a1a1a] border border-[#333333] rounded-2xl px-6 py-5 shadow-xl text-center">
                <div class="mb-3 text-[#D4AF37]">
                    <i class="fa-solid fa-circle-notch fa-spin text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-[#E0E0E0]">Membuka editor...</p>
                <p class="text-[10px] text-[#A0A0A0] mt-1">Mohon tunggu sebentar</p>
            </div>
        </div>
        @if ($modalOpen)
            {{--
            FIX: Z-Index 9999 memastikan modal di atas segalanya.
            FIX: position fixed inset-0 memastikan full screen.
            --}}
            <div class="fixed inset-0 z-[9999] w-full h-full flex items-center justify-center" x-data
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                {{-- Modal Container --}}
                <div
                    class="relative w-full h-full flex flex-col overflow-hidden rounded-none">

                    {{-- Modal Header (Sticky) --}}
                    @if ($activeTab !== 'couple_quote')
                        <div
                            class="px-6 lg:px-20 py-4 bg-arvaya-bg flex justify-between items-center shrink-0 z-10 shadow-sm">
                            <div class="flex items-center gap-3">
                                @php
                                    $modalLabel = 'Edit';
                                    $modalIcon = 'fa-window-restore';
                                    // Logic label sama seperti sebelumnya, hanya styling yang berubah
                                    foreach ($menus as $m) {
                                        if ($activeTab === $m['id']) {
                                            $modalLabel = $m['label'];
                                            $modalIcon = $m['icon'];
                                            break;
                                        }
                                    }
                                @endphp
                                <div
                                    class="w-10 h-10 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37]">
                                    <i class="fa-solid {{ $modalIcon }}"></i>
                                </div>
                                <div>
                                    <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $modalLabel }}</h3>
                                    <p class="text-[10px] text-[#A0A0A0] uppercase tracking-wider font-bold">Edit Detail
                                        Undangan</p>
                                </div>
                            </div>
                            <button wire:click="closeModal"
                                class="w-10 h-10 rounded-full bg-[#252525] text-[#888] hover:bg-red-900/20 hover:text-red-500 hover:rotate-90 transition-all duration-300 flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Modal Content (Scrollable) --}}
                    <div class="flex-1 overflow-y-auto p-4 custom-scrollbar bg-[#121212]">

                        {{-- TAB: COUPLE BIO --}}
                        @if ($activeTab === 'couple_bio')
                            @include('livewire.dashboard.invitation.partials.tabs.bio')
                        @endif

                        {{-- TAB: COUPLE QUOTE --}}
                        @if ($activeTab === 'couple_quote')
                            @include('livewire.dashboard.invitation.partials.tabs.quote')
                        @endif

                        {{-- TAB: EVENTS --}}
                        @if ($activeTab === 'events')
                            @include('livewire.dashboard.invitation.partials.tabs.events')
                        @endif

                        {{-- TAB: GALLERY --}}
                        @if ($activeTab === 'gallery')
                            @include('livewire.dashboard.invitation.partials.tabs.gallery')
                        @endif

                        {{-- TAB: THEME --}}
                        @if ($activeTab === 'theme')
                            @include('livewire.dashboard.invitation.partials.tabs.theme')
                        @endif

                        {{-- TAB: MUSIC --}}
                        @if ($activeTab === 'music')
                            @include('livewire.dashboard.invitation.partials.tabs.music')
                        @endif

                        {{-- TAB: GIFTS --}}
                        @if ($activeTab === 'gifts')
                            @include('livewire.dashboard.invitation.partials.tabs.gifts')
                        @endif

                        {{-- TAB: DRESS CODE --}}
                        @if ($activeTab === 'dress_code')
                            @include('livewire.dashboard.invitation.partials.tabs.dress-code')
                        @endif

                    </div>

                    {{-- Modal Footer (Sticky) --}}
                    <div class="px-4 lg:px-20 py-4 backdrop-blur-md bg-arvaya-bg flex justify-center gap-3 z-10">
                        <button wire:click="closeModal"
                            class="px-6 py-3 bg-[#252525] border border-[#333333] text-[#A0A0A0] rounded-xl font-bold hover:bg-[#2d2d2d] transition text-sm">
                            Batal
                        </button>
                        <button wire:click="save"
                            class="px-8 py-3 bg-[#D4AF37] text-[#121212] rounded-xl hover:bg-[#B4912F] shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all font-bold text-sm uppercase tracking-wide flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save"><i class="fa-solid fa-circle-notch fa-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>