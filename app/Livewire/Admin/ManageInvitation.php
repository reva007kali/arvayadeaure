<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Invitation;
use Livewire\WithPagination;

class ManageInvitation extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $invitations = Invitation::with('user') // Eager load user
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('slug', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-invitation', ['invitations' => $invitations]);
    }

    public function delete($id)
    {
        Invitation::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Undangan dihapus.', type: 'info');
    }
}
