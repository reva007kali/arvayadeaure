<div class="py-2 animate-fade-in-up">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Admin Overview</h2>
        <p class="text-[#9A7D4C] text-sm mt-1">Ringkasan statistik platform Arvaya De Aure.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl border border-[#E6D9B8] shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#F2ECDC] flex items-center justify-center text-[#B89760] text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs text-[#9A7D4C] font-bold uppercase tracking-wider">Total User</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $totalUsers }}</h3>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl border border-[#E6D9B8] shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#F2ECDC] flex items-center justify-center text-[#B89760] text-xl">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <div>
                <p class="text-xs text-[#9A7D4C] font-bold uppercase tracking-wider">Total Undangan</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $totalInvitations }}</h3>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl border border-[#E6D9B8] shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#F2ECDC] flex items-center justify-center text-green-600 text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-xs text-[#9A7D4C] font-bold uppercase tracking-wider">Undangan Aktif</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $activeInvitations }}</h3>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white p-6 rounded-2xl border border-[#E6D9B8] shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#F2ECDC] flex items-center justify-center text-blue-500 text-xl">
                <i class="fa-solid fa-users-viewfinder"></i>
            </div>
            <div>
                <p class="text-xs text-[#9A7D4C] font-bold uppercase tracking-wider">Total Tamu Diundang</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $totalGuests }}</h3>
            </div>
        </div>
    </div>

    {{-- Recent Users Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#E6D9B8] overflow-hidden">
        <div class="p-6 border-b border-[#F2ECDC]">
            <h3 class="font-serif font-bold text-lg text-[#5E4926]">User Registrasi Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-[#F9F7F2] text-[#7C6339] font-bold text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F2ECDC]">
                    @foreach ($recentUsers as $user)
                        <tr class="hover:bg-[#F9F7F2]/50 transition">
                            <td class="px-6 py-4 font-bold text-[#5E4926]">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-[#7C6339]">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-[#9A7D4C] text-xs">{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
