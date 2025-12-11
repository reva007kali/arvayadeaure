<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageUser extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $users = User::where('role', '!=', 'admin') // Jangan tampilkan admin sendiri
            ->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-user', ['users' => $users]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        // Hapus user (Undangan & data lain otomatis terhapus jika cascade di-set di migration)
        $user->delete(); 
        $this->dispatch('notify', message: 'User berhasil dihapus.', type: 'info');
    }
}
