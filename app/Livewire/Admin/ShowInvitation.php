<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use App\Models\Template;

class ShowInvitation extends Component
{
    use WithPagination;

    public Invitation $invitation;

    // Properties untuk Edit Raw Data (Binding ke Textarea)
    public $jsonCouple;
    public $jsonEvents;
    public $jsonGifts;
    public $jsonTheme;

    // Filter Pencarian Tamu
    public $searchGuest = '';

    public function mount(Invitation $invitation)
    {
        $this->invitation = $invitation;

        // Load data array dari DB dan ubah menjadi string JSON yang rapi (Pretty Print)
        // Agar mudah dibaca dan diedit oleh Admin di text area
        $this->jsonCouple = json_encode($invitation->couple_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->jsonEvents = json_encode($invitation->event_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->jsonGifts = json_encode($invitation->gifts_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->jsonTheme = json_encode($invitation->theme_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // --- ACTION: TOGGLE STATUS WEBSITE (ON/OFF) ---
    public function toggleStatus()
    {
        $this->invitation->update([
            'is_active' => !$this->invitation->is_active
        ]);

        $status = $this->invitation->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('notify', message: "Website undangan berhasil $status.", type: 'success');
    }

    // --- ACTION: UPDATE STATUS PEMBAYARAN ---
    public function updatePaymentStatus($status)
    {
        // Validasi input status agar sesuai enum/pilihan
        if (!in_array($status, ['paid', 'pending', 'unpaid', 'rejected'])) {
            return;
        }

        $this->invitation->update([
            'payment_status' => $status
        ]);

        $this->dispatch('notify', message: 'Status pembayaran diubah ke ' . ucfirst($status), type: 'info');
    }

    // --- ACTION: SAVE RAW JSON DATA (GOD MODE) ---
    public function saveJsonData()
    {
        // 1. Coba decode string JSON kembali ke Array
        $couple = json_decode($this->jsonCouple, true);
        $events = json_decode($this->jsonEvents, true);
        $gifts = json_decode($this->jsonGifts, true);
        $theme = json_decode($this->jsonTheme, true);

        // 2. Cek apakah ada error syntax pada JSON yang diedit admin
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->dispatch('notify', message: 'Format JSON Error! Cek tanda kutip/koma.', type: 'error');
            return;
        }

        // 3. Update Database jika valid
        $this->invitation->update([
            'couple_data' => $couple,
            'event_data' => $events,
            'gifts_data' => $gifts,
            'theme_config' => $theme,
        ]);

        $this->dispatch('notify', message: 'Data Raw berhasil disimpan paksa!', type: 'success');
    }

    // --- RENDER VIEW ---
    #[Layout('layouts.app')]
    public function render()
    {
        // Query Tamu dengan Pencarian
        $guests = $this->invitation->guests()
            ->where('name', 'like', '%' . $this->searchGuest . '%')
            ->latest()
            ->paginate(10);

        // Ambil info template yang dipakai undangan ini
        $templateInfo = Template::where('slug', $this->invitation->theme_template)->first();

        return view('livewire.admin.show-invitation', [
            'guests' => $guests,
            'templateInfo' => $templateInfo
        ]);
    }
}