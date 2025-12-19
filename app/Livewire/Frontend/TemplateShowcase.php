<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Template;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

  
#[Layout('components.layouts.public')]
class TemplateShowcase extends Component
{

    use WithPagination;

    public $search = '';
    public $category = 'All';
    public $tier = 'All';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'All'],
        'tier' => ['except' => 'All'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function setCategory($cat)
    {
        $this->category = $cat;
        $this->resetPage();
    }

    public function setTier($tier)
    {
        $this->tier = $tier;
        $this->resetPage();
    }

    public function render()
    {
        $query = Template::where('is_active', true);

        // Search Filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Category Filter
        if ($this->category !== 'All') {
            $query->where('category', $this->category);
        }

        // Tier Filter
        if ($this->tier !== 'All') {
            $query->where('tier', $this->tier);
        }

        return view('livewire.frontend.template-showcase', [
            'templates' => $query->orderBy('tier', 'desc')->latest()->paginate(12)
        ]);
    }
}
