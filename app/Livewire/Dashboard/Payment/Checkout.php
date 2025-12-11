<?php

namespace App\Livewire\Dashboard\Payment;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Invitation;

class Checkout extends Component
{
    use WithFileUploads;

    public Invitation $invitation;
    public $selectedPackage = 'basic';
    public $proofImage;

    public function mount(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) abort(403);
        $this->invitation = $invitation;
        
        // Default ke paket yang sudah tersimpan atau basic
        $this->selectedPackage = $invitation->package_type;
    }

    public function updatedSelectedPackage()
    {
        // Update harga saat ganti paket
        $this->invitation->package_type = $this->selectedPackage;
        $this->invitation->amount = Invitation::PACKAGES[$this->selectedPackage]['price'];
        $this->invitation->save();
    }

    public function save()
    {
        $this->validate([
            'proofImage' => 'required|image|max:2048', // Max 2MB
        ]);

        $path = $this->proofImage->store('payment_proofs', 'public');

        $this->invitation->update([
            'payment_proof' => 'storage/' . $path,
            'payment_status' => 'pending', // Menunggu Admin
        ]);

        session()->flash('message', 'Bukti pembayaran dikirim! Mohon tunggu verifikasi admin.');
        return redirect()->route('dashboard.index');
    }

    public function render()
    {
        return view('livewire.dashboard.payment.checkout', [
            'packages' => Invitation::PACKAGES
        ]);
    }
}