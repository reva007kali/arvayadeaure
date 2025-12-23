<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Invitation;

class Index extends Component
{
    public $search = '';
    public $editId = null;
    public $editTitle = '';
    public $editSlug = '';
    public $isEditing = false;

    public function render()
    {
        $query = Auth::user()->invitations()->latest();

        if ($this->search !== '') {
            $s = $this->search;
            $query = $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        return view('livewire.dashboard.index', [
            'invitations' => $query->get()
        ]);
    }

    public function startEdit($id)
    {
        $invitation = Auth::user()->invitations()->findOrFail($id);
        $this->editId = $invitation->id;
        $this->editTitle = $invitation->title ?? '';
        $this->editSlug = $invitation->slug ?? '';
        $this->isEditing = true;
    }

    public function generateSlug()
    {
        if (!empty($this->editTitle)) {
            $this->editSlug = Str::slug($this->editTitle);
        }
    }

    public function saveEdit()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editSlug' => 'required|alpha_dash|unique:invitations,slug,' . $this->editId,
        ]);

        $invitation = Auth::user()->invitations()->findOrFail($this->editId);
        $invitation->update([
            'title' => $this->editTitle,
            'slug' => $this->editSlug,
        ]);

        $this->isEditing = false;
        session()->flash('status', 'Judul dan slug undangan berhasil diperbarui.');
        $this->render();
    }

    public function cancelEdit()
    {
        $this->reset(['editId', 'editTitle', 'editSlug', 'isEditing']);
    }

    // Fitur Hapus Undangan
    public function delete($id)
    {
        $invitation = Auth::user()->invitations()->find($id);

        if ($invitation) {
            $invitation->delete();
            session()->flash('status', 'Undangan berhasil dihapus.');
        }
    }

    // Admin: Duplicate Invitation
    public function duplicate($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $original = Invitation::findOrFail($id);

        // Generate unique slug
        $baseSlug = Str::slug($original->slug . '-copy');
        $slug = $baseSlug;
        $i = 2;
        while (Invitation::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        $copy = Invitation::create([
            'user_id' => Auth::id(),
            'title' => ($original->title ?? 'Undangan') . ' (Copy)',
            'slug' => $slug,
            'theme_template' => $original->theme_template,
            'package_type' => $original->package_type,
            'amount' => 0,
            'payment_status' => 'paid',
            'payment_action' => null,
            'due_amount' => 0,
            'refund_amount' => 0,
            'is_active' => false,
            'visit_count' => 0,
            'couple_data' => $original->couple_data,
            'event_data' => $original->event_data,
            'theme_config' => $original->theme_config,
            'gallery_data' => $original->gallery_data,
            'gifts_data' => $original->gifts_data,
        ]);

        session()->flash('status', 'Undangan berhasil diduplikasi.');

        // Refresh list
        $this->render();
    }
}
