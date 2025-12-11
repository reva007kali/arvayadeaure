<div class="py-2 animate-fade-in-up">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Semua Undangan</h2>
            <p class="text-[#9A7D4C] text-sm mt-1">Monitoring seluruh project undangan user.</p>
        </div>

        <div class="relative w-full md:w-64">
            <input type="text" wire:model.live.debounce.300ms="search"
                class="w-full !pl-10 pr-4 py-2 rounded-full border border-[#E6D9B8] bg-white text-sm text-[#5E4926] focus:border-[#B89760] focus:ring-[#B89760]"
                placeholder="Cari judul undangan...">
            <div class="absolute left-3 top-2.5 text-[#C6AC80]">
                <i class="fa-solid fa-search"></i>
            </div>
        </div>
    </div>

    {{-- Invitations Grid/List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#E6D9B8] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#F9F7F2] text-[#7C6339] font-bold text-xs uppercase tracking-wider border-b border-[#E6D9B8]">
                    <tr>
                        <th class="px-6 py-4">Judul Project</th>
                        <th class="px-6 py-4">Pemilik (User)</th>
                        <th class="px-6 py-4">Statistik</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F2ECDC]">
                    @forelse($invitations as $invitation)
                        <tr class="hover:bg-[#F9F7F2]/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-[#5E4926]">{{ $invitation->title }}</p>
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank"
                                    class="text-xs text-[#B89760] hover:underline font-mono mt-1 inline-block">
                                    /{{ $invitation->slug }} <i
                                        class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-[#5E4926] font-medium">{{ $invitation->user->name }}</div>
                                <div class="text-xs text-[#9A7D4C]">{{ $invitation->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3 text-xs text-[#7C6339]">
                                    <span title="Views"><i class="fa-solid fa-eye mr-1"></i>
                                        {{ $invitation->visit_count }}</span>
                                    <span title="Guests"><i class="fa-solid fa-users mr-1"></i>
                                        {{ $invitation->guests->count() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded text-[10px] font-bold border 
                                    {{ $invitation->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                    {{ $invitation->is_active ? 'ACTIVE' : 'DRAFT' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.invitations.show', $invitation->id) }}"
                                        class="text-[#B89760] hover:bg-[#F2ECDC] p-2 rounded-lg transition"
                                        title="Inspect Detail">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <button wire:click="delete({{ $invitation->id }})"
                                        wire:confirm="Yakin hapus undangan ini secara paksa?"
                                        class="text-red-400 hover:bg-red-50 p-2 rounded-lg transition"
                                        title="Hapus Paksa">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#9A7D4C]">
                                Belum ada undangan di platform ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#F2ECDC]">
            {{ $invitations->links() }}
        </div>
    </div>
</div>
