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
    public $name, $slug, $description, $type = 'basic';
    public $thumbnail, $preview_video;
    public $templateId = null;
    
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
        $this->reset(['name', 'slug', 'description', 'type', 'thumbnail', 'preview_video', 'templateId']);
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
        $this->type = $t->type;
        // Thumbnail & Video tidak di-load ke input file, hanya preview
        
        $this->isOpen = true;
        $this->isEdit = true;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:templates,slug,' . $this->templateId,
            'type' => 'required',
        ];

        if (!$this->isEdit) {
            $rules['thumbnail'] = 'required|image|max:2048'; // 2MB
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug, // PENTING: Ini harus sama dengan nama file blade di folder themes/
            'description' => $this->description,
            'type' => $this->type,
        ];

        // Handle Image Upload
        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('templates/thumbnails', 'public');
        }

        // Handle Video Upload
        if ($this->preview_video) {
            $data['preview_video'] = $this->preview_video->store('templates/videos', 'public');
        }

        if ($this->isEdit) {
            $t = Template::findOrFail($this->templateId);
            // Hapus file lama jika ada upload baru (Opsional)
            if ($this->thumbnail && $t->thumbnail) Storage::disk('public')->delete($t->thumbnail);
            
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

        if ($t->thumbnail) Storage::disk('public')->delete($t->thumbnail);
        if ($t->preview_video) Storage::disk('public')->delete($t->preview_video);
        
        $t->delete();
        $this->dispatch('notify', message: 'Template dihapus.', type: 'success');
    }
}