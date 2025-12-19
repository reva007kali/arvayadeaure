<?php

namespace App\Livewire\Dashboard\Invitation;

use Livewire\Component;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    // Step Control
    public $step = 1;

    // Template Selection
    public $selectedTemplateSlug = '';
    public $selectedTemplateName = '';
    public $selectedCategory = '';
    public $selectedFilter = 'All'; // Filter Kategori (All, Wedding, Birthday, etc.)

    // Properti Form Common
    public $title = '';
    public $slug = '';
    public $event_date = '';

    // Properti Form Dynamic
    public $groom_name = ''; // Wedding/Engagement
    public $bride_name = ''; // Wedding/Engagement
    public $name = '';       // Birthday/Generic
    public $age = '';        // Birthday
    public $child_name = ''; // Aqiqah/Khitan
    public $organizer = '';  // Event

    public function render()
    {
        $templates = Template::where('is_active', true);

        if ($this->selectedFilter !== 'All') {
            $templates->where('category', $this->selectedFilter);
        }

        return view('livewire.dashboard.invitation.create', [
            'templates' => $templates->get()
        ]);
    }

    public function setFilter($category)
    {
        $this->selectedFilter = $category;
    }

    public function selectTemplate($slug)
    {
        $template = Template::where('slug', $slug)->firstOrFail();

        $this->selectedTemplateSlug = $template->slug;
        $this->selectedTemplateName = $template->name;
        $this->selectedCategory = $template->category ?? 'Wedding';

        $this->step = 2;
    }

    public function backToStep1()
    {
        $this->step = 1;
        // Reset form fields but keep selected template info just in case? 
        // Better to clear selected template to avoid confusion if they pick a different one next time
        // But for "Back" button usually we want to keep state. Let's keep it simple.
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    protected function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|alpha_dash|unique:invitations,slug|max:255',
            'event_date' => 'required|date',
        ];

        if (in_array($this->selectedCategory, ['Wedding', 'Engagement'])) {
            $rules['groom_name'] = 'required|string|max:100';
            $rules['bride_name'] = 'required|string|max:100';
        } elseif ($this->selectedCategory === 'Birthday') {
            $rules['name'] = 'required|string|max:100';
            $rules['age'] = 'required|string|max:20';
        } elseif (in_array($this->selectedCategory, ['Aqiqah', 'Khitan'])) {
            $rules['child_name'] = 'required|string|max:100';
        } elseif ($this->selectedCategory === 'Event') {
            $rules['title'] = 'required|string|max:255'; // Title is already required
            $rules['organizer'] = 'required|string|max:100';
        } else {
            // Generic
            $rules['name'] = 'nullable|string|max:100';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        // 1. Prepare Data Structures based on Category
        $coupleData = [];
        $eventData = [];
        $defaultQuote = '';

        // -- COUPLE DATA --
        if (in_array($this->selectedCategory, ['Wedding', 'Engagement'])) {
            $coupleData = [
                'groom' => ['nickname' => $this->groom_name, 'fullname' => $this->groom_name, 'father' => '', 'mother' => '', 'instagram' => ''],
                'bride' => ['nickname' => $this->bride_name, 'fullname' => $this->bride_name, 'father' => '', 'mother' => '', 'instagram' => ''],
                'quote' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri...'
            ];
            $defaultEventTitle = $this->selectedCategory === 'Wedding' ? 'Akad Nikah' : 'Tunangan';
        } elseif ($this->selectedCategory === 'Birthday') {
            $coupleData = [
                'name' => $this->name,
                'fullname' => $this->name,
                'age' => $this->age,
                'birth_date' => '',
                'father' => '',
                'mother' => '',
                'instagram' => '',
                'quote' => 'Semoga panjang umur dan sehat selalu!'
            ];
            $defaultEventTitle = 'Pesta Ulang Tahun';
        } elseif (in_array($this->selectedCategory, ['Aqiqah', 'Khitan'])) {
            $coupleData = [
                'child_name' => $this->child_name,
                'child_fullname' => $this->child_name,
                'birth_date' => '',
                'father' => '',
                'mother' => '',
                'quote' => 'Semoga menjadi anak yang sholeh/sholehah.'
            ];
            $defaultEventTitle = $this->selectedCategory === 'Aqiqah' ? 'Tasyakuran Aqiqah' : 'Walimatul Khitan';
        } elseif ($this->selectedCategory === 'Event') {
            $coupleData = [
                'title' => $this->title,
                'organizer' => $this->organizer,
                'description' => '',
                'quote' => ''
            ];
            $defaultEventTitle = 'Main Event';
        } else {
            // Generic
            $coupleData = [
                'name' => $this->name,
                'fullname' => $this->name,
                'description' => '',
                'quote' => ''
            ];
            $defaultEventTitle = 'Acara Utama';
        }

        // -- EVENT DATA --
        $eventData[] = [
            'title' => $defaultEventTitle,
            'date' => $this->event_date . ' 09:00',
            'location' => '',
            'address' => '',
            'map_link' => ''
        ];

        // -- THEME CONFIG --
        $template = Template::where('slug', $this->selectedTemplateSlug)->first();
        $defaultThemeConfig = [
            'primary_color' => '#d4af37',
            'font' => 'sans-serif',
            'music_url' => ''
        ];

        // 2. Create Invitation
        $invitation = Invitation::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'slug' => Str::slug($this->slug),
            'couple_data' => $coupleData,
            'event_data' => $eventData,
            'theme_config' => $defaultThemeConfig,
            'gallery_data' => [],
            'gifts_data' => [],
            'theme_template' => $this->selectedTemplateSlug,
            'is_active' => true,

            // Set Pricing Info from Template
            // Jika Admin, Gratis dan Langsung Paid
            'package_type' => $template->tier ?? 'basic',
            'amount' => Auth::user()->isAdmin() ? 0 : ($template->price ?? 0),
            'payment_status' => Auth::user()->isAdmin() ? 'paid' : (($template->price ?? 0) > 0 ? 'unpaid' : 'paid'),
        ]);

        session()->flash('status', 'Undangan berhasil dibuat! Silakan lengkapi detailnya.');
        return redirect()->route('dashboard.invitation.edit', $invitation->id);
    }
}