<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Template;

#[Layout('components.layouts.public')]

class LandingPage extends Component
{
    public string $search = '';
    public string $tier = 'all';

    public function render()
    {
        $templates = Template::query()
            ->select(['id', 'name', 'slug', 'thumbnail', 'tier', 'price', 'category'])
            ->where('is_active', true)
            ->when($this->search !== '', function ($q) {
                $term = trim($this->search);
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', "%{$term}%")
                        ->orWhere('slug', 'like', "%{$term}%")
                        ->orWhere('category', 'like', "%{$term}%");
                });
            })
            ->when($this->tier !== 'all', fn($q) => $q->where('tier', $this->tier))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $tiers = Template::TIERS;

        return view('livewire.landing-page', compact('templates', 'tiers'));
    }
}
