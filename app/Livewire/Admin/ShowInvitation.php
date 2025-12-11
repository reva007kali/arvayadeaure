<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Invitation;

class ShowInvitation extends Component
{
   public Invitation $invitation;

    public function mount(Invitation $invitation)
    {
        // Model Binding otomatis mengambil data berdasarkan ID di URL
        $this->invitation = $invitation;
    }

    public function render()
    {
        return view('livewire.admin.show-invitation');
    }
}
