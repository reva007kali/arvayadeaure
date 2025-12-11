<div class="py-2 animate-fade-in-up">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Kelola Pengguna</h2>
            <p class="text-[#9A7D4C] text-sm mt-1">Daftar semua user yang terdaftar di platform.</p>
        </div>

        {{-- Search Bar --}}
        <div class="relative w-full md:w-64">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full !pl-10 pr-4 py-2 rounded-full border border-[#E6D9B8] bg-white text-sm text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760]"
                placeholder="Cari nama atau email...">
            <div class="absolute left-3 top-2.5 text-[#C6AC80]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>

    {{-- User Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#E6D9B8] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#F9F7F2] text-[#7C6339] font-bold text-xs uppercase tracking-wider border-b border-[#E6D9B8]">
                    <tr>
                        <th class="px-6 py-4">User Info</th>
                        <th class="px-6 py-4">Total Undangan</th>
                        <th class="px-6 py-4">Tanggal Gabung</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F2ECDC]">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#F9F7F2]/50 transition group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#E6D9B8] flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#5E4926]">{{ $user->name }}</p>
                                        <p class="text-xs text-[#9A7D4C]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#F2ECDC] text-[#7C6339] text-xs font-bold">
                                    <i class="fa-solid fa-envelope"></i> {{ $user->invitations->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-[#7C6339]">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="delete({{ $user->id }})"
                                    wire:confirm="Hapus user ini? Semua undangan milik user ini akan ikut terhapus permanen."
                                    class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition"
                                    title="Hapus User">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-[#9A7D4C]">
                                Tidak ada data user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#F2ECDC]">
            {{ $users->links() }}
        </div>
    </div>
</div>
