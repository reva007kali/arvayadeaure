<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Facades\Cache; // <--- WAJIB IMPORT INI

#[Layout('components.layouts.public')]
class LandingPage extends Component
{
    public string $search = '';
    public string $tier = 'all';

    public function render()
    {
        // 1. Buat Key Unik untuk Cache berdasarkan Search & Tier
        // Kalau user cari "gold", cachenya beda dengan user cari "silver"
        $cacheKeyTemplates = 'landing_templates_' . md5($this->search . $this->tier);
        
        // 2. Gunakan Cache::remember
        // Data akan disimpan di RAM selama 60 menit (3600 detik)
        $templates = Cache::remember($cacheKeyTemplates, 3600, function () {
            return Template::query()
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
        });

        // 3. Cache Testimonials (Ini yang paling berat tadi)
        // Karena testimonials tidak tergantung filter search user, kita cache global saja.
        $testimonials = Cache::remember('landing_testimonials', 3600, function () {
            return Invitation::query()
                ->select(['id', 'couple_data', 'gallery_data', 'user_id']) // Pastikan user_id terpilih untuk relasi
                ->with('user:id,role') // Optimasi select relasi
                ->where('is_active', true)
                ->whereHas('user', fn($q) => $q->where('role', 'user'))
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
        });

        $tiers = Template::TIERS;

        return view('livewire.landing-page', compact('templates', 'tiers', 'testimonials'));
    }
}