<?php

namespace App\Livewire\Dashboard\Guest;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public Invitation $invitation;

    // Form Inputs
    public $name = '';
    public $phone = '';
    public $category = 'Keluarga'; // Default

    // Search
    public $search = '';

    public function mount(Invitation $invitation)
    {
        if ($invitation->user_id !== auth()->id())
            abort(403);
        $this->invitation = $invitation;
    }

    public function render()
    {
        $guests = $this->invitation->guests()
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.guest.index', [
            'guests' => $guests
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
        ]);

        // Generate Slug Unik (bapak-budi, bapak-budi-1, dst)
        $baseSlug = Str::slug($this->name);
        $slug = $baseSlug;
        $count = 1;

        while ($this->invitation->guests()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        // Format No HP ke 62 (Hapus 0 di depan)
        $cleanPhone = $this->phone;
        if (Str::startsWith($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $this->invitation->guests()->create([
            'name' => $this->name,
            'slug' => $slug,
            'phone' => $cleanPhone,
            'category' => $this->category,
        ]);

        $this->reset(['name', 'phone']);
        $this->dispatch('notify', message: 'Tamu berhasil ditambahkan!', type: 'success');
    }

    public function delete($id)
    {
        $this->invitation->guests()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Tamu dihapus.', type: 'info');
    }

    public function importContacts(array $entries = [])
    {
        $imported = 0;
        foreach ($entries as $entry) {
            $name = trim($entry['name'] ?? '');
            $tel = trim($entry['phone'] ?? ($entry['tel'] ?? ''));
            if ($name === '' || $tel === '')
                continue;
            $digits = preg_replace('/\D+/', '', $tel);
            if ($digits === '')
                continue;
            if (Str::startsWith($digits, '0')) {
                $digits = '62' . substr($digits, 1);
            } elseif (Str::startsWith($digits, '620')) {
                $digits = '62' . substr($digits, 3);
            } elseif (Str::startsWith($digits, '62')) {
            } elseif (Str::startsWith($digits, '62')) {
            } else {
                $digits = $digits;
            }
            if ($this->invitation->guests()->where('phone', $digits)->exists())
                continue;
            $baseSlug = Str::slug($name);
            $slug = $baseSlug ?: Str::random(8);
            $count = 1;
            while ($this->invitation->guests()->where('slug', $slug)->exists()) {
                $slug = ($baseSlug ?: 'guest') . '-' . $count++;
            }
            $this->invitation->guests()->create([
                'name' => $name,
                'slug' => $slug,
                'phone' => $digits,
                'category' => $this->category,
            ]);
            $imported++;
            if ($imported >= 200)
                break;
        }
        $this->dispatch('notify', message: "Import kontak: {$imported}", type: 'success');
    }
}
