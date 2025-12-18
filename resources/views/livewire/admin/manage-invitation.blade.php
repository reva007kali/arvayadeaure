<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Semua Undangan</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Monitoring seluruh project undangan user.</p>
        </div>

        <div class="relative w-full md:w-64">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full !pl-10 pr-4 py-2 rounded-full border border-[#333333] bg-[#1a1a1a] text-sm text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37] placeholder-[#666]"
                placeholder="Cari judul undangan...">
            <div class="absolute left-3 top-2.5 text-[#D4AF37]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>

    {{-- Invitations Grid/List --}}
    <div class="bg-[#1a1a1a] rounded-2xl shadow-lg border border-[#333333] overflow-hidden">

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#252525] text-[#D4AF37] font-bold text-xs uppercase tracking-wider border-b border-[#333333]">
                    <tr>
                        <th class="px-6 py-4">Judul Project</th>
                        <th class="px-6 py-4">Pemilik (User)</th>
                        <th class="px-6 py-4">Statistik</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                        <th class="px-6 py-4 text-right">Payment Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#333333]">
                    @forelse($invitations as $invitation)
                        <tr class="hover:bg-[#252525] transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-[#E0E0E0]">{{ $invitation->title }}</p>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-xs text-[#D4AF37] hover:underline font-mono mt-1 inline-block">
                                    /{{ $invitation->slug }} <i
                                        class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[#E0E0E0] font-medium">{{ $invitation->user->name }}</div>
                                <div class="text-xs text-[#A0A0A0]">{{ $invitation->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3 text-xs text-[#A0A0A0]">
                                    <span title="Views"><i class="fa-solid fa-eye mr-1 text-[#D4AF37]"></i>
                                        {{ $invitation->visit_count }}</span>
                                    <span title="Guests"><i class="fa-solid fa-users mr-1 text-[#D4AF37]"></i>
                                        {{ $invitation->guests->count() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-[10px] font-bold border 
                                            {{ $invitation->is_active ? 'bg-green-900/20 text-green-500 border-green-900/30' : 'bg-gray-800 text-gray-400 border-gray-700' }}">
                                    {{ $invitation->is_active ? 'ACTIVE' : 'DRAFT' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.invitations.show', $invitation->id) }}"
                                        class="text-[#D4AF37] hover:bg-[#333] p-2 rounded-lg transition"
                                        title="Inspect Detail">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <button wire:click="delete({{ $invitation->id }})"
                                        wire:confirm="Yakin hapus undangan ini secara paksa?"
                                        class="text-red-500 hover:bg-red-900/20 p-2 rounded-lg transition"
                                        title="Hapus Paksa">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                            {{-- Di dalam Tabel --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex flex-col gap-1 items-end">
                                    {{-- Status Aktif Web --}}
                                    <span
                                        class="w-fit px-2 py-0.5 rounded text-[10px] font-bold border 
                            {{ $invitation->is_active ? 'bg-green-900/20 text-green-500 border-green-900/30' : 'bg-gray-800 text-gray-400 border-gray-700' }}">
                                        WEB: {{ $invitation->is_active ? 'ON' : 'OFF' }}
                                    </span>

                                    {{-- Status Bayar --}}
                                    @if ($invitation->payment_status == 'paid')
                                        <span class="text-[10px] text-green-500 font-bold"><i class="fa-solid fa-check"></i>
                                            Paid</span>
                                    @elseif($invitation->payment_status == 'pending')
                                        <a href="{{ route('admin.transactions', ['statusFilter' => 'pending']) }}"
                                            class="text-[10px] text-yellow-500 font-bold hover:underline cursor-pointer">
                                            <i class="fa-solid fa-clock"></i> Verifikasi!
                                        </a>
                                    @elseif($invitation->payment_status == 'rejected')
                                        <span class="text-[10px] text-red-500 font-bold"><i class="fa-solid fa-ban"></i>
                                            Rejected</span>
                                    @else
                                        <span class="text-[10px] text-gray-500">Unpaid</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#666]">
                                Belum ada undangan di platform ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List (Accordion Style) --}}
        <div class="md:hidden">
            @forelse($invitations as $invitation)
                <div x-data="{ expanded: false }" class="border-b border-[#333333] last:border-0">
                    {{-- Card Header --}}
                    <div @click="expanded = !expanded"
                        class="p-4 flex items-center justify-between bg-[#1a1a1a] cursor-pointer active:bg-[#252525] transition">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div
                                class="w-10 h-10 rounded-full bg-[#252525] border border-[#333333] flex items-center justify-center text-[#D4AF37] shrink-0">
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-[#E0E0E0] text-sm truncate">{{ $invitation->title }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span
                                        class="px-1.5 py-0.5 rounded text-[9px] font-bold border 
                                            {{ $invitation->is_active ? 'bg-green-900/20 text-green-500 border-green-900/30' : 'bg-gray-800 text-gray-400 border-gray-700' }}">
                                        {{ $invitation->is_active ? 'ACTIVE' : 'DRAFT' }}
                                    </span>
                                    <span class="text-[10px] text-[#666] font-mono truncate">/{{ $invitation->slug }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-[#666] transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>
                    </div>

                    {{-- Card Body (Expanded) --}}
                    <div x-show="expanded" x-collapse
                        class="bg-[#202020] px-4 pb-4 border-t border-[#333333] border-dashed">
                        <div class="pt-4 space-y-4">
                            {{-- User Info --}}
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-bold text-[#A0A0A0] uppercase">Pemilik</span>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-[#E0E0E0]">{{ $invitation->user->name }}</p>
                                    <p class="text-[10px] text-[#666]">{{ $invitation->user->email }}</p>
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-[#252525] p-2 rounded border border-[#333333] text-center">
                                    <p class="text-[9px] text-[#A0A0A0] uppercase">Views</p>
                                    <p class="text-sm font-bold text-[#D4AF37]">{{ $invitation->visit_count }}</p>
                                </div>
                                <div class="bg-[#252525] p-2 rounded border border-[#333333] text-center">
                                    <p class="text-[9px] text-[#A0A0A0] uppercase">Guests</p>
                                    <p class="text-sm font-bold text-[#D4AF37]">{{ $invitation->guests->count() }}</p>
                                </div>
                            </div>

                            {{-- Payment & Web Status --}}
                            <div class="flex justify-between items-center bg-[#151515] p-2 rounded border border-[#333333]">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-[#A0A0A0] uppercase">Web Status</span>
                                    <span
                                        class="text-xs font-bold {{ $invitation->is_active ? 'text-green-500' : 'text-gray-500' }}">
                                        {{ $invitation->is_active ? 'ONLINE' : 'OFFLINE' }}
                                    </span>
                                </div>
                                <div class="h-6 w-px bg-[#333333]"></div>
                                <div class="flex flex-col items-end">
                                    <span class="text-[9px] text-[#A0A0A0] uppercase">Pembayaran</span>
                                    @if ($invitation->payment_status == 'paid')
                                        <span class="text-xs text-green-500 font-bold">PAID <i
                                                class="fa-solid fa-check ml-1"></i></span>
                                    @elseif($invitation->payment_status == 'pending')
                                        <a href="{{ route('admin.transactions', ['statusFilter' => 'pending']) }}"
                                            class="text-xs text-yellow-500 font-bold hover:underline">
                                            VERIFIKASI <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </a>
                                    @elseif($invitation->payment_status == 'rejected')
                                        <span class="text-xs text-red-500 font-bold">REJECTED</span>
                                    @else
                                        <span class="text-xs text-gray-500">UNPAID</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2 pt-2">
                                <a href="{{ route('admin.invitations.show', $invitation->id) }}"
                                    class="flex-1 py-2 bg-[#333333] text-[#D4AF37] rounded-lg text-xs font-bold uppercase text-center hover:bg-[#444] transition">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Detail
                                </a>
                                <button wire:click="delete({{ $invitation->id }})"
                                    wire:confirm="Yakin hapus undangan ini secara paksa?"
                                    class="flex-1 py-2 bg-red-900/20 text-red-500 border border-red-900/30 rounded-lg text-xs font-bold uppercase hover:bg-red-900/40 transition">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-[#666] text-sm italic">
                    Belum ada undangan di platform ini.
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-[#333333]">
            {{ $invitations->links() }}
        </div>
    </div>
</div>