<?php

namespace App\Livewire;

use App\Models\Template;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class TemplateShowcase extends Component
{
    public function render()
    {
        $templates = Cache::remember('template_showcase_active', 1800, function () {
            return Template::query()
                ->select(['id', 'name', 'slug', 'thumbnail', 'tier', 'price', 'category'])
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        });

        return view('livewire.template-showcase', [
            'templates' => $templates
        ]);
    }
}
