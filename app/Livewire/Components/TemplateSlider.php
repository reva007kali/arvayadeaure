<?php

namespace App\Livewire\Components;

use App\Models\Template;
use Livewire\Component;

class TemplateSlider extends Component
{
    public $tier = 'all';

    public function render()
    {
        $query = Template::where('is_active', true);

        return view('livewire.components.template-slider', [
            'templates' => $query->latest()->take(20)->get()
        ]);
    }
}
