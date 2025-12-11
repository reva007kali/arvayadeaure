<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invitation;

class Transaction extends Component
{
    use WithPagination;

    public $statusFilter = 'pending';
    
    // State Modal
    public $rejectId = null;
    public $rejectReason = '';
    public $showRejectModal = false;
    public $proofUrl = null;
    public $showProofModal = false;
    
    // State Detail Modal
    public $showDetailModal = false;
    public $detailTransaction = null;

    public function render()
    {
        // 1. Hitung Statistik (Query Terpisah agar cepat)
        $stats = [
            'total_revenue' => Invitation::where('payment_status', 'paid')->sum('amount'),
            'count_pending' => Invitation::where('payment_status', 'pending')->count(),
            'count_paid'    => Invitation::where('payment_status', 'paid')->count(),
            'count_rejected'=> Invitation::where('payment_status', 'rejected')->count(),
        ];

        // 2. Data Transaksi
        $transactions = Invitation::with('user')
            ->where('payment_status', '!=', 'unpaid')
            ->when($this->statusFilter, function($q) {
                if($this->statusFilter !== 'all') {
                    $q->where('payment_status', $this->statusFilter);
                }
            })
            ->latest('updated_at')
            ->paginate(10);

        return view('livewire.admin.transaction', [
            'transactions' => $transactions,
            'stats' => $stats // Kirim statistik ke view
        ]);
    }

    // --- ACTIONS ---

    public function showDetail($id)
    {
        $this->detailTransaction = Invitation::with(['user', 'guests'])->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->detailTransaction = null;
    }

    public function viewProof($url)
    {
        $this->proofUrl = $url;
        $this->showProofModal = true;
    }

    public function approve($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->update([
            'payment_status' => 'paid',
            'is_active' => true,
            'rejection_reason' => null
        ]);
        $this->dispatch('notify', message: 'Pembayaran disetujui.', type: 'success');
        $this->closeDetail(); // Tutup detail jika dibuka dari modal
    }

    public function openRejectModal($id)
    {
        $this->rejectId = $id;
        $this->rejectReason = '';
        $this->showRejectModal = true;
        $this->closeDetail(); // Tutup detail agar tidak tumpang tindih
    }

    public function reject()
    {
        $this->validate(['rejectReason' => 'required|string|min:5']);
        $invitation = Invitation::findOrFail($this->rejectId);
        $invitation->update([
            'payment_status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $this->rejectReason
        ]);
        $this->showRejectModal = false;
        $this->dispatch('notify', message: 'Pembayaran ditolak.', type: 'error');
    }
}