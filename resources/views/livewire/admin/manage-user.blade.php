<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Kelola Pengguna</h2>
            <p class="text-[#A0A0A0] text-sm mt-1">Daftar semua user yang terdaftar di platform.</p>
        </div>

        {{-- Search Bar --}}
        <div class="relative w-full md:w-64">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full !pl-10 pr-4 py-2 rounded-full border border-[#333333] bg-[#1a1a1a] text-sm text-[#E0E0E0] focus:border-[#D4AF37] focus:ring-[#D4AF37] placeholder-[#666]"
                placeholder="Cari nama atau email...">
            <div class="absolute left-3 top-2.5 text-[#D4AF37]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>

    {{-- User Table --}}
    <div class="bg-[#1a1a1a] rounded-2xl shadow-lg border border-[#333333] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#252525] text-[#D4AF37] font-bold text-xs uppercase tracking-wider border-b border-[#333333]">
                    <tr>
                        <th class="px-6 py-4">User Info</th>
                        <th class="px-6 py-4">Total Undangan</th>
                        <th class="px-6 py-4">Tanggal Gabung</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#333333]">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#252525] transition group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}"
                                            class="w-10 h-10 rounded-full object-cover border border-[#D4AF37]">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#D4AF37] to-[#B4912F] flex items-center justify-center text-[#121212] font-bold text-lg">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-[#E0E0E0]">{{ $user->name }}</p>
                                        <p class="text-xs text-[#A0A0A0]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#333333] text-[#D4AF37] text-xs font-bold border border-[#444]">
                                    <i class="fa-solid fa-envelope"></i> {{ $user->invitations->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[#A0A0A0]">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="delete({{ $user->id }})"
                                    wire:confirm="Hapus user ini? Semua undangan milik user ini akan ikut terhapus permanen."
                                    class="text-red-500 hover:text-red-400 p-2 rounded-full hover:bg-red-900/20 transition"
                                    title="Hapus User">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-[#666]">
                                Tidak ada data user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#333333]">
            {{ $users->links() }}
        </div>
    </div>
</div>