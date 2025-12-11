<div class="py-2 animate-fade-in-up">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="font-serif font-bold text-3xl text-[#5E4926]">Transaksi & Pendapatan</h2>
        <p class="text-[#9A7D4C] text-sm mt-1">Pantau arus kas dan verifikasi pembayaran.</p>
    </div>

    {{-- STATISTIC CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Card 1: Revenue --}}
        <div
            class="bg-white p-5 rounded-2xl border border-[#E6D9B8] shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-[#B89760]/10 rounded-bl-full -mr-4 -mt-4"></div>
            <div
                class="w-12 h-12 rounded-full bg-[#E6D9B8] flex items-center justify-center text-[#5E4926] text-xl z-10">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div class="z-10">
                <p class="text-[10px] text-[#9A7D4C] font-bold uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">Rp
                    {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Card 2: Pending --}}
        <div class="bg-white p-5 rounded-2xl border border-yellow-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-[10px] text-yellow-600 font-bold uppercase tracking-wider">Perlu Verifikasi</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $stats['count_pending'] }}</h3>
            </div>
        </div>

        {{-- Card 3: Paid --}}
        <div class="bg-white p-5 rounded-2xl border border-green-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <p class="text-[10px] text-green-600 font-bold uppercase tracking-wider">Berhasil (Paid)</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $stats['count_paid'] }}</h3>
            </div>
        </div>

        {{-- Card 4: Rejected --}}
        <div class="bg-white p-5 rounded-2xl border border-red-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-500 text-xl">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <p class="text-[10px] text-red-500 font-bold uppercase tracking-wider">Dibatalkan</p>
                <h3 class="font-serif font-bold text-2xl text-[#5E4926]">{{ $stats['count_rejected'] }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & List Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <h3 class="font-bold text-[#5E4926] text-lg">Riwayat Transaksi</h3>

        <div class="flex bg-white rounded-lg p-1 border border-[#E6D9B8] shadow-sm">
            @foreach (['pending' => 'Menunggu', 'paid' => 'Lunas', 'rejected' => 'Gagal', 'all' => 'Semua'] as $key => $label)
                <button wire:click="$set('statusFilter', '{{ $key }}')"
                    class="px-4 py-1.5 rounded-md text-xs font-bold transition {{ $statusFilter === $key ? 'bg-[#B89760] text-white shadow-md' : 'text-[#7C6339] hover:bg-[#F9F7F2]' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Transaction List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#E6D9B8] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#F9F7F2] text-[#7C6339] font-bold text-xs uppercase tracking-wider border-b border-[#E6D9B8]">
                    <tr>
                        <th class="px-6 py-4">Project Info</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Bukti</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F2ECDC]">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-[#F9F7F2]/50 transition group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#E6D9B8] flex items-center justify-center text-[#5E4926] font-bold text-xs">
                                        {{ substr($trx->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#5E4926] text-sm">{{ $trx->title }}</p>
                                        <p class="text-[10px] text-[#9A7D4C]">{{ $trx->user->name }} •
                                            {{ $trx->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-mono font-bold text-[#5E4926]">Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                <span
                                    class="text-[10px] text-[#9A7D4C] uppercase tracking-wider">{{ $trx->package_type }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($trx->payment_proof)
                                    <button wire:click="viewProof('{{ asset($trx->payment_proof) }}')"
                                        class="flex items-center gap-2 px-3 py-1 bg-white border border-[#E6D9B8] rounded text-[#7C6339] text-[10px] font-bold uppercase hover:bg-[#E6D9B8] hover:text-[#5E4926] transition shadow-sm">
                                        <i class="fa-solid fa-eye"></i> Cek Foto
                                    </button>
                                @else
                                    <span class="text-red-400 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($trx->payment_status == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-50 text-yellow-700 rounded text-[10px] font-bold border border-yellow-200 uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($trx->payment_status == 'paid')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 rounded text-[10px] font-bold border border-green-200 uppercase">
                                        <i class="fa-solid fa-check"></i> Paid
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 text-red-700 rounded text-[10px] font-bold border border-red-200 uppercase">
                                        <i class="fa-solid fa-xmark"></i> Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="showDetail({{ $trx->id }})"
                                        class="p-2 text-[#B89760] hover:bg-[#F9F7F2] rounded-lg transition"
                                        title="Detail Info">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>

                                    @if ($trx->payment_status == 'pending')
                                        <div class="h-4 w-px bg-[#E6D9B8]"></div>
                                        <button wire:click="openRejectModal({{ $trx->id }})"
                                            class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition"
                                            title="Tolak">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <button wire:click="approve({{ $trx->id }})"
                                            wire:confirm="Setujui pembayaran ini?"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                            title="Approve">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#9A7D4C]">Tidak ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#F2ECDC]">{{ $transactions->links() }}</div>
    </div>

    {{-- ================= MODALS ================= --}}

    {{-- 1. MODAL DETAIL TRANSAKSI --}}
    @if ($showDetailModal && $detailTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#2D2418]/60 backdrop-blur-sm p-4"
            x-transition>
            <div
                class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden border border-[#E6D9B8] flex flex-col max-h-[90vh]">

                {{-- Header --}}
                <div class="p-6 bg-[#F9F7F2] border-b border-[#E6D9B8] flex justify-between items-center">
                    <div>
                        <h3 class="font-serif font-bold text-xl text-[#5E4926]">Detail Transaksi
                            #{{ $detailTransaction->id }}</h3>
                        <p class="text-xs text-[#9A7D4C] uppercase tracking-wider">
                            {{ $detailTransaction->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <button wire:click="closeDetail"
                        class="w-8 h-8 rounded-full bg-white border border-[#E6D9B8] text-[#7C6339] hover:bg-[#B89760] hover:text-white transition flex items-center justify-center">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                {{-- Body (Scrollable) --}}
                <div class="p-6 overflow-y-auto flex-1 space-y-6">
                    {{-- Info User & Paket --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-[#E6D9B8] bg-white">
                            <label class="text-[10px] font-bold text-[#9A7D4C] uppercase block mb-1">User Info</label>
                            <p class="font-bold text-[#5E4926]">{{ $detailTransaction->user->name }}</p>
                            <p class="text-xs text-[#7C6339]">{{ $detailTransaction->user->email }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-[#E6D9B8] bg-white">
                            <label class="text-[10px] font-bold text-[#9A7D4C] uppercase block mb-1">Paket
                                Pembelian</label>
                            <p class="font-bold text-[#B89760] uppercase">{{ $detailTransaction->package_type }}</p>
                            <p class="text-sm font-mono text-[#5E4926]">Rp
                                {{ number_format($detailTransaction->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Bukti Transfer Preview --}}
                    <div>
                        <label class="text-[10px] font-bold text-[#9A7D4C] uppercase block mb-2">Bukti Transfer</label>
                        @if ($detailTransaction->payment_proof)
                            <div class="rounded-xl overflow-hidden border border-[#E6D9B8] relative group cursor-pointer"
                                wire:click="viewProof('{{ asset($detailTransaction->payment_proof) }}')">
                                <img src="{{ asset($detailTransaction->payment_proof) }}"
                                    class="w-full h-48 object-cover object-top opacity-90 group-hover:opacity-100 transition">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/20 opacity-0 group-hover:opacity-100 transition">
                                    <span class="bg-white px-3 py-1 rounded-full text-xs font-bold text-[#5E4926]">Klik
                                        Perbesar</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-center text-gray-400 text-xs italic">
                                Belum upload bukti.
                            </div>
                        @endif
                    </div>

                    {{-- Status History --}}
                    @if ($detailTransaction->payment_status == 'rejected')
                        <div class="p-4 bg-red-50 border border-red-100 rounded-xl">
                            <label class="text-[10px] font-bold text-red-500 uppercase block mb-1">Alasan
                                Penolakan</label>
                            <p class="text-sm text-red-700 italic">"{{ $detailTransaction->rejection_reason }}"</p>
                        </div>
                    @endif
                </div>

                {{-- Footer Actions --}}
                @if ($detailTransaction->payment_status == 'pending')
                    <div class="p-6 border-t border-[#E6D9B8] bg-[#F9F7F2] flex justify-end gap-3">
                        <button wire:click="openRejectModal({{ $detailTransaction->id }})"
                            class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition">
                            Tolak
                        </button>
                        <button wire:click="approve({{ $detailTransaction->id }})" wire:confirm="Yakin setujui?"
                            class="px-6 py-2 bg-[#B89760] text-white rounded-lg text-sm font-bold hover:bg-[#9A7D4C] shadow-lg transition">
                            Setujui Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- 2. MODAL LIGHTBOX BUKTI --}}
    @if ($showProofModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-md p-4"
            x-transition>
            <div class="relative max-w-4xl w-full h-full flex flex-col justify-center">
                <button wire:click="$set('showProofModal', false)"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 z-50">
                    <i class="fa-solid fa-times text-3xl"></i>
                </button>
                <img src="{{ $proofUrl }}" class="w-full h-full object-contain rounded-lg">
            </div>
        </div>
    @endif

    {{-- 3. MODAL REJECT (Sama seperti sebelumnya) --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-[#2D2418]/50 backdrop-blur-sm px-4">
            <div
                class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-[#E6D9B8] animate-fade-in-up">
                <h3 class="font-serif font-bold text-xl text-[#5E4926] mb-2">Tolak Pembayaran</h3>
                <textarea wire:model="rejectReason" rows="3"
                    class="w-full rounded-xl bg-[#F9F7F2] border-[#E6D9B8] text-[#5E4926] text-sm mb-2"
                    placeholder="Alasan penolakan..."></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="$set('showRejectModal', false)"
                        class="px-4 py-2 text-xs font-bold text-[#7C6339] hover:bg-[#F9F7F2] rounded-lg">Batal</button>
                    <button wire:click="reject"
                        class="px-4 py-2 bg-red-500 text-white text-xs font-bold rounded-lg hover:bg-red-600 shadow-md">Kirim</button>
                </div>
            </div>
        </div>
    @endif

</div>
