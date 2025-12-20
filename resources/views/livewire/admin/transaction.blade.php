<div class="py-6 animate-fade-in-up dashboard-ui max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="font-serif font-bold text-3xl text-[#E0E0E0]">Transaksi & Pendapatan</h2>
        <p class="text-[#A0A0A0] text-sm mt-1">Pantau arus kas dan verifikasi pembayaran.</p>
    </div>

    {{-- STATISTIC CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Card 1: Revenue --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 relative overflow-hidden group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="absolute right-0 top-0 w-24 h-24 bg-[#D4AF37]/5 rounded-bl-full -mr-4 -mt-4 transition-all group-hover:bg-[#D4AF37]/10">
            </div>
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl z-10 border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div class="z-10">
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">Rp
                    {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </h3>
            </div>
        </div>

        {{-- Card 2: Pending --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-yellow-500/30 shadow-lg flex items-center gap-4 group hover:border-yellow-500/60 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500 text-xl border border-yellow-500/20 group-hover:border-yellow-500 transition-colors">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-[10px] text-yellow-500 font-bold uppercase tracking-wider">Perlu Verifikasi</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_pending'] }}</h3>
            </div>
        </div>

        {{-- Card 3: Paid --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-green-500/30 shadow-lg flex items-center gap-4 group hover:border-green-500/60 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 text-xl border border-green-500/20 group-hover:border-green-500 transition-colors">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <p class="text-[10px] text-green-500 font-bold uppercase tracking-wider">Berhasil (Paid)</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_paid'] }}</h3>
            </div>
        </div>

        {{-- Card 4: Rejected --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-red-500/30 shadow-lg flex items-center gap-4 group hover:border-red-500/60 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 text-xl border border-red-500/20 group-hover:border-red-500 transition-colors">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <p class="text-[10px] text-red-500 font-bold uppercase tracking-wider">Dibatalkan</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_rejected'] }}</h3>
            </div>
        </div>
        {{-- Card 5: Upgraded --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-arrow-up"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Upgraded</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_upgraded'] }}</h3>
            </div>
        </div>
        {{-- Card 6: Downgraded --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-arrow-down"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Downgraded</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_downgraded'] }}</h3>
            </div>
        </div>
        {{-- Card 7: Refund --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-[#D4AF37]/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-[#D4AF37] text-xl border border-[#333333] group-hover:border-[#D4AF37] transition-colors">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Refund</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_refund'] }}</h3>
            </div>
        </div>
        {{-- Card 8: Cancel --}}
        <div
            class="bg-[#1a1a1a] p-5 rounded-2xl border border-[#333333] shadow-lg flex items-center gap-4 group hover:border-red-500/50 transition-all">
            <div
                class="w-12 h-12 rounded-full bg-[#252525] flex items-center justify-center text-red-500 text-xl border border-[#333333] group-hover:border-red-500 transition-colors">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <p class="text-[10px] text-[#A0A0A0] font-bold uppercase tracking-wider">Cancel</p>
                <h3 class="font-serif font-bold text-2xl text-[#E0E0E0]">{{ $stats['count_cancel'] }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & List Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <h3 class="font-bold text-[#E0E0E0] text-lg">Riwayat Transaksi</h3>

        <div class="flex bg-[#1a1a1a] rounded-lg p-1 border border-[#333333] shadow-sm">
            @foreach (['pending' => 'Menunggu', 'paid' => 'Lunas', 'rejected' => 'Gagal', 'unpaid' => 'Belum Bayar', 'all' => 'Semua'] as $key => $label)
                <button wire:click="$set('statusFilter', '{{ $key }}')"
                    class="px-4 py-1.5 rounded-md text-xs font-bold transition {{ $statusFilter === $key ? 'bg-[#D4AF37] text-[#121212] shadow-md' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#E0E0E0]' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
        <div class="flex bg-[#1a1a1a] rounded-lg p-1 border border-[#333333] shadow-sm">
            @foreach (['all' => 'Semua Tindakan', 'upgraded' => 'Upgraded', 'downgraded' => 'Downgraded', 'refund' => 'Refund', 'cancel' => 'Cancel'] as $key => $label)
                <button wire:click="$set('actionFilter', '{{ $key }}')"
                    class="px-4 py-1.5 rounded-md text-xs font-bold transition {{ $actionFilter === $key ? 'bg-[#D4AF37] text-[#121212] shadow-md' : 'text-[#A0A0A0] hover:bg-[#252525] hover:text-[#E0E0E0]' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Transaction List --}}
    <div class="bg-[#1a1a1a] rounded-2xl shadow-lg border border-[#333333] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead
                    class="bg-[#252525] text-[#D4AF37] font-bold text-xs uppercase tracking-wider border-b border-[#333333]">
                    <tr>
                        <th class="px-6 py-4">Project Info</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Bukti</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#333333]">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-[#252525] transition group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-[#333333] flex items-center justify-center text-[#D4AF37] font-bold text-xs border border-[#444]">
                                        {{ substr($trx->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#E0E0E0] text-sm">{{ $trx->title }}</p>
                                        <p class="text-[10px] text-[#A0A0A0]">{{ $trx->user->name }} •
                                            {{ $trx->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-mono font-bold text-[#E0E0E0]">Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                <span
                                    class="text-[10px] text-[#A0A0A0] uppercase tracking-wider">{{ $trx->package_type }}</span>
                                @if ($trx->payment_action === 'upgraded' && $trx->due_amount > 0)
                                    <div class="text-[10px] text-[#D4AF37] mt-1">Tambah bayar: Rp
                                        {{ number_format($trx->due_amount, 0, ',', '.') }}
                                    </div>
                                @endif
                                @if ($trx->payment_action === 'downgraded' && $trx->refund_amount > 0)
                                    <div class="text-[10px] text-[#A0A0A0] mt-1">Refund disarankan: Rp
                                        {{ number_format($trx->refund_amount, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($trx->payment_proof)
                                    <button wire:click="viewProof('{{ asset($trx->payment_proof) }}')"
                                        class="flex items-center gap-2 px-3 py-1 bg-[#252525] border border-[#333333] rounded text-[#D4AF37] text-[10px] font-bold uppercase hover:bg-[#333] transition shadow-sm">
                                        <i class="fa-solid fa-eye"></i> Cek Foto
                                    </button>
                                @else
                                    <span class="text-red-500 text-xs italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($trx->payment_status == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-500/10 text-yellow-500 rounded text-[10px] font-bold border border-yellow-500/20 uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($trx->payment_status == 'paid')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-green-500/10 text-green-500 rounded text-[10px] font-bold border border-green-500/20 uppercase">
                                        <i class="fa-solid fa-check"></i> Paid
                                    </span>
                                @elseif($trx->payment_status == 'rejected')
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-red-500/10 text-red-500 rounded text-[10px] font-bold border border-red-500/20 uppercase">
                                        <i class="fa-solid fa-xmark"></i> Rejected
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 bg-gray-800 text-gray-400 rounded text-[10px] font-bold border border-gray-700 uppercase">
                                        {{ ucfirst($trx->payment_status) }}
                                    </span>
                                @endif
                                @if ($trx->payment_action)
                                    <div
                                        class="mt-1 inline-flex items-center gap-1 px-2 py-0.5 bg-[#252525] text-[#A0A0A0] rounded text-[10px] font-bold border border-[#333333] uppercase">
                                        <i class="fa-solid fa-info-circle"></i> {{ ucfirst($trx->payment_action) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="showDetail({{ $trx->id }})"
                                        class="p-2 text-[#D4AF37] hover:bg-[#252525] rounded-lg transition"
                                        title="Detail Info">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>

                                    @if ($trx->payment_status == 'pending')
                                        <div class="h-4 w-px bg-[#333333]"></div>
                                        <button wire:click="openRejectModal({{ $trx->id }})"
                                            class="p-2 text-red-500 hover:bg-red-900/20 rounded-lg transition" title="Tolak">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <button wire:click="approve({{ $trx->id }})" wire:confirm="Setujui pembayaran ini?"
                                            class="p-2 text-green-500 hover:bg-green-900/20 rounded-lg transition"
                                            title="Approve">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#666]">Tidak ada data transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-[#333333]">{{ $transactions->links() }}</div>
    </div>

    {{-- ================= MODALS ================= --}}

    {{-- 1. MODAL DETAIL TRANSAKSI --}}
    @if ($showDetailModal && $detailTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" x-transition>
            <div
                class="bg-[#1a1a1a] rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden border border-[#333333] flex flex-col max-h-[90vh]">

                {{-- Header --}}
                <div class="p-6 bg-[#252525] border-b border-[#333333] flex justify-between items-center">
                    <div>
                        <h3 class="font-serif font-bold text-xl text-[#E0E0E0]">Detail Transaksi
                            #{{ $detailTransaction->id }}</h3>
                        <p class="text-xs text-[#A0A0A0] uppercase tracking-wider">
                            {{ $detailTransaction->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <button wire:click="closeDetail"
                        class="w-8 h-8 rounded-full bg-[#1a1a1a] border border-[#333333] text-[#A0A0A0] hover:bg-[#D4AF37] hover:text-[#121212] transition flex items-center justify-center">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                {{-- Body (Scrollable) --}}
                <div class="p-6 overflow-y-auto flex-1 space-y-6">
                    {{-- Info User & Paket --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-[#333333] bg-[#1a1a1a]">
                            <label class="text-[10px] font-bold text-[#A0A0A0] uppercase block mb-1">User Info</label>
                            <p class="font-bold text-[#E0E0E0]">{{ $detailTransaction->user->name }}</p>
                            <p class="text-xs text-[#A0A0A0]">{{ $detailTransaction->user->email }}</p>
                        </div>
                        <div class="p-4 rounded-xl border border-[#333333] bg-[#1a1a1a]">
                            <label class="text-[10px] font-bold text-[#A0A0A0] uppercase block mb-1">Paket
                                Pembelian</label>
                            <p class="font-bold text-[#D4AF37] uppercase">{{ $detailTransaction->package_type }}</p>
                            <p class="text-sm font-mono text-[#E0E0E0]">Rp
                                {{ number_format($detailTransaction->amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Bukti Transfer Preview --}}
                    <div>
                        <label class="text-[10px] font-bold text-[#A0A0A0] uppercase block mb-2">Bukti Transfer</label>
                        @if ($detailTransaction->payment_proof)
                            <div class="rounded-xl overflow-hidden border border-[#333333] relative group cursor-pointer"
                                wire:click="viewProof('{{ asset($detailTransaction->payment_proof) }}')">
                                <img src="{{ asset($detailTransaction->payment_proof) }}"
                                    class="w-full h-48 object-cover object-top opacity-90 group-hover:opacity-100 transition">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition">
                                    <span class="bg-[#D4AF37] px-3 py-1 rounded-full text-xs font-bold text-[#121212]">Klik
                                        Perbesar</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="p-4 bg-[#252525] border border-[#333333] rounded-xl text-center text-[#666] text-xs italic">
                                Belum upload bukti.
                            </div>
                        @endif
                    </div>

                    {{-- Status History --}}
                    @if ($detailTransaction->payment_status == 'rejected')
                        <div class="p-4 bg-red-900/20 border border-red-900/30 rounded-xl">
                            <label class="text-[10px] font-bold text-red-500 uppercase block mb-1">Alasan
                                Penolakan</label>
                            <p class="text-sm text-red-400 italic">"{{ $detailTransaction->rejection_reason }}"</p>
                        </div>
                    @endif
                </div>

                {{-- Footer Actions --}}
                @if ($detailTransaction->payment_status == 'pending')
                    <div class="p-6 border-t border-[#333333] bg-[#252525] flex justify-end gap-3">
                        <button wire:click="openRejectModal({{ $detailTransaction->id }})"
                            class="px-4 py-2 border border-red-500/30 text-red-500 rounded-lg text-sm font-bold hover:bg-red-900/20 transition">
                            Tolak
                        </button>
                        <button wire:click="approve({{ $detailTransaction->id }})" wire:confirm="Yakin setujui?"
                            class="px-6 py-2 bg-[#D4AF37] text-[#121212] rounded-lg text-sm font-bold hover:bg-[#B4912F] shadow-lg transition">
                            Setujui Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- 2. MODAL LIGHTBOX BUKTI --}}
    @if ($showProofModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-md p-4" x-transition>
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
        <div class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm px-4">
            <div class="bg-[#1a1a1a] rounded-2xl p-6 max-w-sm w-full shadow-2xl border border-[#333333] animate-fade-in-up">
                <h3 class="font-serif font-bold text-xl text-[#E0E0E0] mb-2">Tolak Pembayaran</h3>
                <textarea wire:model="rejectReason" rows="3"
                    class="w-full rounded-xl bg-[#252525] border-[#333333] text-[#E0E0E0] text-sm mb-2 focus:border-[#D4AF37] focus:ring-[#D4AF37]"
                    placeholder="Alasan penolakan..."></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="$set('showRejectModal', false)"
                        class="px-4 py-2 text-xs font-bold text-[#A0A0A0] hover:text-[#E0E0E0] rounded-lg">Batal</button>
                    <button wire:click="reject"
                        class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 shadow-md">Kirim</button>
                </div>
            </div>
        </div>
    @endif

</div>