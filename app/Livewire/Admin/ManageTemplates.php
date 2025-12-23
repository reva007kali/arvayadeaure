<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class ManageTemplates extends Component
{
    use WithFileUploads;

    public $templates;

    // Form Inputs
    public $name, $slug, $description, $tier = 'basic';
    public $price = 0; // Tambahan: Harga Template
    public $thumbnail, $preview_video;
    public $templateId = null;
    public $is_active = true;
    public $category = 'Wedding';

    // Modal State
    public $isOpen = false;
    public $isEdit = false;

    public function render()
    {
        $this->templates = Template::latest()->get();
        return view('livewire.admin.manage-templates');
    }

    public function openModal()
    {
        $this->resetValidation();
        // Reset form inputs termasuk price
        $this->reset(['name', 'slug', 'description', 'tier', 'price', 'thumbnail', 'preview_video', 'templateId', 'is_active', 'category']);
        $this->isOpen = true;
        $this->isEdit = false;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $t = Template::findOrFail($id);
        $this->templateId = $id;
        $this->name = $t->name;
        $this->slug = $t->slug;
        $this->description = $t->description;
        $this->tier = $t->tier;
        $this->price = $t->price; // Load harga
        $this->is_active = (bool) $t->is_active;
        $this->category = $t->category ?: 'Wedding';

        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:templates,slug,' . $this->templateId,
            'tier' => 'required|in:basic,premium,exclusive',
            'price' => 'required|numeric|min:0', // Validasi harga
            'is_active' => 'boolean',
            'category' => 'nullable|string|in:Wedding,Engagement,Birthday,Aqiqah,Khitan,Event,Other',
        ];

        if (!$this->isEdit) {
            $rules['thumbnail'] = 'required|image|max:2048';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'tier' => $this->tier,
            'price' => $this->price, // Simpan harga
            'is_active' => (bool) $this->is_active,
            'category' => $this->category,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('templates/thumbnails', 'public');
        }

        if ($this->preview_video) {
            $data['preview_video'] = $this->preview_video->store('templates/videos', 'public');
        }

        if ($this->isEdit) {
            $t = Template::findOrFail($this->templateId);
            if ($this->thumbnail && $t->thumbnail)
                Storage::disk('public')->delete($t->thumbnail);

            $t->update($data);
            $msg = 'Template diperbarui.';
        } else {
            Template::create($data);
            $msg = 'Template ditambahkan.';
        }

        $this->isOpen = false;
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    public function delete($id)
    {
        $t = Template::withCount('invitations')->findOrFail($id);

        if ($t->invitations_count > 0) {
            $this->dispatch('notify', message: 'Gagal! Template ini sedang dipakai oleh user.', type: 'error');
            return;
        }

        if ($t->thumbnail)
            Storage::disk('public')->delete($t->thumbnail);
        if ($t->preview_video)
            Storage::disk('public')->delete($t->preview_video);

        $t->delete();
        $this->dispatch('notify', message: 'Template dihapus.', type: 'success');
    }

    public function toggleActive($id)
    {
        $t = Template::findOrFail($id);
        $t->is_active = !$t->is_active;
        $t->save();
        $this->dispatch('notify', message: $t->is_active ? 'Template ditampilkan ke user.' : 'Template disembunyikan dari user.', type: 'info');
    }
}
