<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Admin Overview</h2>
        <p class="text-[#A0A0A0] text-sm mt-1">Ringkasan statistik platform Arvaya De Aure.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card 1 --}}
        <div
            class="bg-[#1a1a1a] p-6 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Total User</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $totalUsers }}</h3>
            </div>
        </div>

        {{-- Card 2 --}}
        <div
            class="bg-[#1a1a1a] p-6 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Total Undangan</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $totalInvitations }}</h3>
            </div>
        </div>

        {{-- Card 3 --}}
        <div
            class="bg-[#1a1a1a] p-6 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-green-500/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-green-900/20 flex items-center justify-center text-green-500 text-xl border border-green-900/30 group-hover:border-green-500 transition-colors">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Undangan Aktif</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $activeInvitations }}</h3>
            </div>
        </div>

        {{-- Card 4 --}}
        <div
            class="bg-[#1a1a1a] p-6 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-blue-500/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-blue-900/20 flex items-center justify-center text-blue-500 text-xl border border-blue-900/30 group-hover:border-blue-500 transition-colors">
                <i class="fa-solid fa-users-viewfinder"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Total Tamu Diundang</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $totalGuests }}</h3>
            </div>
        </div>
    </div>

    {{-- Recent Users Table --}}
    <div class="bg-[#1a1a1a] rounded-2xl shadow-lg border border-[#333333] overflow-hidden">
        <div class="p-6 border-b border-[#333333]">
            <h3 class="font-serif font-bold text-lg text-[#E0E0E0]">User Registrasi Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#252525] text-[#D4AF37] font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#333333]">
                    @foreach ($recentUsers as $user)
                        <tr class="hover:bg-[#252525] transition">
                            <td class="px-6 py-4 font-bold text-[#E0E0E0]">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-[#A0A0A0]">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-[#888] text-xs">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>