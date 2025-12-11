<?php

namespace App\Livewire\Frontend;

use App\Models\Guest;
use Livewire\Component;
use App\Models\Invitation;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;


#[Layout('components.layouts.guest')]
class ShowInvitation extends Component
{
    public Invitation $invitation;
    public ?Guest $guest = null; // Bisa null jika tamu umum

    #[Url(as: 'to')]
    public $guestSlug = '';

    public function mount($slug)
    {
        // 1. Ambil Data
        $this->invitation = Invitation::where('slug', $slug)->firstOrFail();

        // 2. LOGIC PROTEKSI (PAYMENT GATEKEEPER)
        // ----------------------------------------
        $user = Auth::user(); // User yang sedang login (bisa null)
        
        // Cek apakah yang akses adalah Pemilik?
        $isOwner = $user && $user->id === $this->invitation->user_id;
        
        // Cek apakah yang akses adalah Admin?
        $isAdmin = $user && $user->role === 'admin';
        
        // Cek apakah sudah lunas?
        $isPaid = $this->invitation->payment_status === 'paid';

        // Jika BELUM LUNAS, dan BUKAN PEMILIK, dan BUKAN ADMIN -> TENDANG!
        if (!$isPaid && !$isOwner && !$isAdmin) {
            // Kita arahkan ke tampilan khusus "Belum Aktif" biar lebih cantik daripada error 403 biasa
            return redirect()->route('invitation.inactive'); 
        }
        // ----------------------------------------

        $this->invitation->increment('visit_count');

        if ($this->guestSlug) {
            $this->guest = $this->invitation->guests()
                ->where('slug', $this->guestSlug)
                ->first();
        }
    }


    public function render()
    {
        // Tentukan nama komponen tema, default ke 'themes.default'
        $themeName = $this->invitation->theme_template ?? 'default';
        $componentName = "themes.{$themeName}";

        return view('livewire.frontend.show-invitation', [
            'componentName' => $componentName
        ]);
    }
}