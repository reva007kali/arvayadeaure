<?php

namespace App\Livewire\Dashboard\Invitation;

// 1. IMPORTS
// Kita memanggil class-class yang dibutuhkan oleh component ini
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Library Manipulasi Gambar
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
// Models
use App\Models\Invitation;
use App\Models\Template;
// Service AI
use App\Services\OpenAIService;

class Edit extends Component
{
    // Mengaktifkan fitur upload file di Livewire
    use WithFileUploads;

    // --- PROPERTI UTAMA ---
    public Invitation $invitation;
    public $activeTab = null; // Tidak ada tab aktif saat halaman dimuat
    public $category = 'Wedding'; // Kategori Template (Wedding, Birthday, dll)

    // Query String untuk Tab
    protected $queryString = ['activeTab'];

    // --- PROPERTI DATA (MODEL BINDING) ---
    // Variabel ini terhubung langsung dengan input form di view (wire:model)
    public $theme_template; // Slug template yang dipilih (misal: 'rustic')

    // Data JSON yang di-decode jadi Array
    public $couple = [];
    public $events = [];
    public $theme = [];
    public $gifts = [];

    // --- PROPERTI GALERI & UPLOAD ---
    // Struktur data galeri baru (Associative Array)
    public $gallery = [
        'cover' => null,
        'groom' => null,
        'bride' => null,
        'moments' => [],
        'enabled' => true,
    ];

    // --- PROPERTI DRESS CODE ---
    public $dressCode = [
        'enabled' => true,
        'description' => '',
        'colors' => [],
        'palette_image' => null,
        'note' => ''
    ];
    public $newPaletteImage; // Temp upload


    // Penampung file sementara (sebelum di-save)
    public $newCover;
    public $newGroom;
    public $newBride;
    public $newMoments = [];

    // --- PROPERTI AI ---
    public $isGeneratingAi = false; // Loading state
    public $aiTone = 'islami';      // Pilihan gaya bahasa
    public $aiLanguage = 'id';
    public $aiContentMode = 'quote';
    public $useAiQuote = false;
    public $quranPreset = '';

    // Chat Logic
    public $chatMessages = [];
    public $chatInput = '';
    public $isChatting = false;

    // --- PROPERTI LOGIC TEMPLATE & HARGA ---
    public $availableTemplates = [];   // List semua template dari DB
    public $currentTemplatePrice = 0;  // Harga template yang sedang dipilih
    public $currentTierName = '';      // Nama Tier (Basic/Premium)
    public $currentTierFeatures = [];  // List fitur yang didapat
    public $modalOpen = false;
    public $search = '';
    public $templatePage = 1;
    public $perPage = 18;
    public $hasMoreTemplates = true;

    public function openModal($tab)
    {
        $this->activeTab = $tab;
        $this->modalOpen = true;

        // Reset Wizard saat buka tab quote
        if ($tab === 'couple_quote') {
            // Default: Show Preview first. If empty, maybe show chat? 
            // Let's just default to useAiQuote=false (Preview Mode)
            // But if chat is empty, we can initialize it.
            $this->useAiQuote = false;

            if (empty($this->chatMessages)) {
                $this->chatMessages[] = [
                    'role' => 'assistant',
                    'content' => "Halo! 👋 Saya Arvaya, asisten penulis undangan Anda.\nBingung mau tulis kata sambutan apa? Ceritakan saja keinginan Anda! \nContoh: \"Buatkan kata-kata Islami tentang jodoh\" atau \"Pantun lucu buat undangan\"."
                ];
            }
        }
    }

    public function sendChatMessage()
    {
        $this->validate(['chatInput' => 'required|string|max:500']);

        $userMsg = $this->chatInput;
        $this->chatMessages[] = ['role' => 'user', 'content' => $userMsg];
        $this->chatInput = '';
        $this->isChatting = true;

        // Prepare history for API
        $history = [];
        foreach ($this->chatMessages as $msg) {
            // Only send user and assistant messages to API context
            if (in_array($msg['role'], ['user', 'assistant'])) {
                $history[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }
        }

        $response = OpenAIService::chatQuoteGenerator($userMsg, $history);

        $this->chatMessages[] = ['role' => 'assistant', 'content' => $response];
        $this->isChatting = false;
    }

    public function applyQuoteFromChat($index)
    {
        $msg = $this->chatMessages[$index]['content'] ?? '';

        // Extract JSON block
        if (preg_match('/\|\|\|(.*?)\|\|\|/s', $msg, $matches)) {
            $jsonStr = $matches[1];
            $data = json_decode($jsonStr, true);
            if ($data) {
                // Map to couple['quote_structured']
                $this->couple['quote_structured'] = [
                    'type' => $data['type'] ?? 'quote',
                    'quote_text' => $data['quote_text'] ?? ($data['display_text'] ?? ''),
                    'arabic' => $data['arabic'] ?? '',
                    'translation' => $data['translation'] ?? '',
                    'source' => $data['source'] ?? '',
                ];
                // Set plain text fallback
                if (($data['type'] ?? '') === 'quran') {
                    $this->couple['quote'] = "{$data['source']}: {$data['translation']}";
                } else {
                    $this->couple['quote'] = $data['quote_text'] ?? '';
                }
            }
        } else {
            // Fallback: Use the whole message as a simple quote (strip out the "Sure, here is..." parts manually by user later)
            // Or better, just take it as 'quote_text'
            $cleanMsg = strip_tags($msg);
            $this->couple['quote_structured'] = [
                'type' => 'quote',
                'quote_text' => $cleanMsg,
                'source' => 'AI Generated',
            ];
            $this->couple['quote'] = $cleanMsg;
        }

        $this->dispatch('notify', message: 'Kata-kata diterapkan! Silakan cek preview.', type: 'success');
        $this->useAiQuote = false; // Show preview

        // Dispatch event for smooth scrolling to result
        $this->dispatch('scroll-to-result');
    }



    public function closeModal()
    {
        $this->modalOpen = false;
    }

    // --- RULES VALIDASI ---
    protected function rules()
    {
        $rules = [
            'theme_template' => 'required|string',
            'events.*.title' => 'required',
            'events.*.date' => 'required',
            'gifts.*.bank_name' => 'required_with:gifts.*.account_number',
            'gifts.*.account_number' => 'numeric|nullable',
            'dressCode.description' => 'nullable|string|max:500',
            'dressCode.note' => 'nullable|string|max:255',
            'newPaletteImage' => 'nullable|image|max:5120', // Max 5MB
            'theme.video_url' => 'nullable|string|url|max:255',
        ];

        if ($this->category === 'Wedding' || $this->category === 'Engagement') {
            $rules['couple.groom.nickname'] = 'required';
            $rules['couple.bride.nickname'] = 'required';
        } elseif ($this->category === 'Birthday') {
            $rules['couple.name'] = 'required';
            $rules['couple.age'] = 'nullable';
        } elseif ($this->category === 'Aqiqah' || $this->category === 'Khitan') {
            $rules['couple.child_name'] = 'required';
        } elseif ($this->category === 'Event') {
            $rules['couple.title'] = 'required';
            $rules['couple.organizer'] = 'required';
        } else {
            // Generic validation for other categories
            $rules['couple.name'] = 'nullable';
        }

        return $rules;
    }

    // --- LIFECYCLE: MOUNT (Saat Halaman Pertama Kali Dibuka) ---
    public function mount(Invitation $invitation)
    {
        // 1. Security Check: Pastikan user adalah pemilik undangan
        if ($invitation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $this->invitation = $invitation;

        // 2. Load Templates awal (hanya yang aktif) dengan paging ringan
        $this->loadTemplates(reset: true);

        // 3. Set Template Awal & Kategori
        $this->theme_template = $invitation->theme_template ?? 'default';

        // Ambil kategori dari template yang dipakai
        $currentTemplate = Template::where('slug', $this->theme_template)->first();
        $this->category = $currentTemplate ? ($currentTemplate->category ?? 'Wedding') : 'Wedding';

        // 4. Load Data JSON & Merge dengan Default
        // Tujuannya agar tidak error "Undefined index" jika data di DB masih kosong/null
        $this->loadInvitationData();

        // 5. Hitung Info Harga Berdasarkan Template Awal
        $this->updateTemplateInfo();
    }

    // --- LOGIC: UPDATE HARGA REALTIME ---
    // Method ini otomatis jalan ketika user mengubah radio button 'theme_template'
    public function updatedThemeTemplate($value)
    {
        $this->updateTemplateInfo();
    }

    // Hitung harga & fitur berdasarkan template yang dipilih
    public function updateTemplateInfo()
    {
        // Cari template di collection local (tidak perlu query DB lagi)
        $template = $this->availableTemplates->where('slug', $this->theme_template)->first();

        if ($template) {
            $this->currentTemplatePrice = $template->price;
            $this->currentTierName = ucfirst($template->tier); // Misal: "Premium"

            // Ambil fitur dari konstanta model Template
            // Pastikan const TIERS ada di App\Models\Template
            $this->currentTierFeatures = Template::TIERS[$template->tier]['features'] ?? [];
        }
    }

    // --- TEMPLATE LIST (SEARCH + INFINITE LOAD) ---
    private function templateBaseQuery()
    {
        $q = Template::query()
            ->select(['id', 'name', 'slug', 'thumbnail', 'tier', 'price', 'is_active'])
            ->where('is_active', true)
            ->where('category', $this->category);
        if (!empty($this->search)) {
            $term = trim($this->search);
            $q->where(function ($qq) use ($term) {
                $qq->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%");
            });
        }
        return $q->orderBy('tier')->orderBy('name');
    }

    public function loadTemplates(bool $reset = false)
    {
        if ($reset) {
            $this->templatePage = 1;
            $this->availableTemplates = collect();
            $this->hasMoreTemplates = true;
        }

        $results = $this->templateBaseQuery()
            ->skip(($this->templatePage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        if ($reset) {
            $this->availableTemplates = $results;
        } else {
            $this->availableTemplates = $this->availableTemplates->concat($results);
        }

        $this->hasMoreTemplates = $results->count() === $this->perPage;
    }

    public function loadMoreTemplates()
    {
        if (!$this->hasMoreTemplates)
            return;
        $this->templatePage++;
        $this->loadTemplates();
    }

    public function updatedSearch()
    {
        $this->loadTemplates(reset: true);
    }

    public function selectTemplate(string $slug)
    {
        $this->theme_template = $slug;
        $this->updateTemplateInfo();
    }

    // --- HELPER: LOAD DATA ---
    private function loadInvitationData()
    {
        // Default Couple (Dynamic based on Category)
        $defaultCouple = [];

        if ($this->category === 'Wedding' || $this->category === 'Engagement') {
            $defaultCouple = [
                'groom' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
                'bride' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
                'quote' => ''
            ];
        } elseif ($this->category === 'Birthday') {
            $defaultCouple = [
                'name' => '',
                'fullname' => '',
                'age' => '',
                'birth_date' => '',
                'father' => '',
                'mother' => '',
                'instagram' => '',
                'quote' => ''
            ];
        } elseif ($this->category === 'Aqiqah' || $this->category === 'Khitan') {
            $defaultCouple = [
                'child_name' => '',
                'child_fullname' => '',
                'birth_date' => '',
                'father' => '',
                'mother' => '',
                'quote' => ''
            ];
        } elseif ($this->category === 'Event') {
            $defaultCouple = [
                'title' => '',
                'organizer' => '',
                'description' => '',
                'quote' => ''
            ];
        } else {
            // Generic Fallback
            $defaultCouple = [
                'name' => '',
                'fullname' => '',
                'description' => '',
                'quote' => ''
            ];
        }

        // array_replace_recursive: Data DB menimpa Default, tapi key yang hilang di DB akan diisi Default
        $this->couple = array_replace_recursive($defaultCouple, $this->invitation->couple_data ?? []);

        // Default Events
        $this->events = $this->invitation->event_data ?? [];
        if (empty($this->events)) {
            $this->events[] = ['title' => 'Akad Nikah', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
        }

        // Default Theme Config
        $this->theme = array_replace_recursive(
            [
                'primary_color' => '#B89760',
                'music_url' => '',
                'events_enabled' => true,
                'gifts_enabled' => true,
                'video_enabled' => true,
                'video_url' => '',
            ],
            $this->invitation->theme_config ?? []
        );

        // Default Gifts
        $this->gifts = $this->invitation->gifts_data ?? [];

        // Default Gallery
        $defaultGallery = ['cover' => null, 'groom' => null, 'bride' => null, 'moments' => [], 'enabled' => true];
        $dbGallery = $this->invitation->gallery_data ?? [];

        // Migrasi Data Lama (Jika gallery masih array biasa [0,1,2])
        if (isset($dbGallery[0])) {
            $this->gallery = array_merge($defaultGallery, ['moments' => $dbGallery]);
        } else {
            $this->gallery = array_replace_recursive($defaultGallery, $dbGallery);
        }

        // Default Dress Code
        $defaultDressCode = [
            'enabled' => true,
            'description' => '',
            'colors' => ['#000000', '#FFFFFF'], // Default colors
            'palette_image' => null,
            'note' => ''
        ];
        $this->dressCode = array_replace_recursive($defaultDressCode, $this->invitation->dress_code_data ?? []);
    }

    // --- FITUR: AI WRITER ---
    // (Deprecated Wizard methods removed)

    public function composeManualQuote()
    {
        $qs = $this->couple['quote_structured'] ?? [];
        $mode = $this->aiContentMode;
        $lang = $this->aiLanguage;

        if ($mode === 'quran') {
            $arabic = $qs['arabic'] ?? '';
            $translation = $qs['translation'] ?? '';
            $source = $qs['source'] ?? '';
            $display = $lang === 'en'
                ? "Quran {$source}: {$translation}"
                : "QS {$source}: {$translation}";
            $this->couple['quote_structured'] = [
                'type' => 'quran',
                'arabic' => $arabic,
                'translation' => $translation,
                'source' => $source,
                'display_text' => $display,
            ];
            $this->couple['quote'] = $display;
        } elseif ($mode === 'bible') {
            $verse = $qs['verse_text'] ?? '';
            $translation = $qs['translation'] ?? '';
            $source = $qs['source'] ?? '';
            $finalText = $translation ?: $verse;
            $display = "{$source}: {$finalText}";
            $this->couple['quote_structured'] = [
                'type' => 'bible',
                'verse_text' => $verse,
                'translation' => $translation,
                'source' => $source,
                'display_text' => $display,
            ];
            $this->couple['quote'] = $display;
        } else {
            $text = $qs['quote_text'] ?? '';
            $source = $qs['source'] ?? '';
            $display = $source ? "{$text} — {$source}" : $text;
            $this->couple['quote_structured'] = [
                'type' => 'quote',
                'quote_text' => $text,
                'source' => $source,
                'display_text' => $display,
            ];
            $this->couple['quote'] = $display;
        }

        $this->dispatch('notify', message: 'Kata-kata manual tersusun.', type: 'success');
    }

    private function mapQuranPresetLabel(string $key): string
    {
        return match ($key) {
            'ar_rum_21' => 'QS Ar-Rum 21',
            'an_nur_32' => 'QS An-Nur 32',
            'an_nisa_1' => 'QS An-Nisa 1',
            'al_furqan_74' => 'QS Al-Furqan 74',
            default => 'QS Ar-Rum 21',
        };
    }

    public function updatedQuranPreset($value)
    {
        // Do not compose immediately; let Generate use the selected verse
        $this->couple['quote_structured'] = null;
        $this->couple['quote'] = '';
    }

    // --- HELPER: IMAGE PROCESSING ---
    private function processImage($file, $width = 1600)
    {
        // Increase memory limit to handle large files (up to 20MB)
        ini_set('memory_limit', '512M');

        $manager = new ImageManager(new Driver());
        $filename = Str::random(40) . '.webp';
        $folder = 'invitations/' . $this->invitation->id;
        $path = $folder . '/' . $filename;

        try {
            // 1. Baca Gambar
            $image = $manager->read($file->getRealPath());

            // 2. Resize (Scale Down) agar tidak terlalu besar
            $image->scaleDown(width: $width);

            // 3. Convert ke WebP (Quality 80%)
            $encoded = $image->toWebp(quality: 80);

            // 4. Simpan ke Public Storage
            Storage::disk('public')->put($path, (string) $encoded);

            return 'storage/' . $path;

        } catch (\Exception $e) {
            // Fallback jika error (misal GD library tidak support WebP)
            return 'storage/' . $file->store($folder, 'public');
        }
    }

    // --- ACTIONS DRESS CODE ---
    public function addDressCodeColor()
    {
        $this->dressCode['colors'][] = '#000000';
    }

    public function removeDressCodeColor($index)
    {
        unset($this->dressCode['colors'][$index]);
        $this->dressCode['colors'] = array_values($this->dressCode['colors']);
    }

    // --- CRUD ACTIONS (Event, Gift, Gallery) ---

    public function addEvent()
    {
        $this->events[] = ['title' => 'Acara Baru', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
    }

    public function removeEvent($index)
    {
        unset($this->events[$index]);
        $this->events = array_values($this->events);
    }

    public function addGift()
    {
        $this->gifts[] = ['bank_name' => '', 'account_name' => '', 'account_number' => ''];
    }

    public function removeGift($index)
    {
        unset($this->gifts[$index]);
        $this->gifts = array_values($this->gifts);
    }

    public function removeSpecific($key)
    {
        $this->gallery[$key] = null; // Hapus cover/groom/bride
    }

    public function removeMoment($index)
    {
        unset($this->gallery['moments'][$index]);
        $this->gallery['moments'] = array_values($this->gallery['moments']);
        $this->invitation->update(['gallery_data' => $this->gallery]);
    }

    public function reorderMoments(array $order)
    {
        $current = $this->gallery['moments'] ?? [];
        $new = [];
        foreach ($order as $i) {
            if (isset($current[$i])) {
                $new[] = $current[$i];
            }
        }
        if (count($new) === count($current) && !empty($new)) {
            $this->gallery['moments'] = $new;
            $this->invitation->update(['gallery_data' => $this->gallery]);
            $this->dispatch('notify', message: 'Urutan galeri diperbarui.', type: 'success');
        }
    }

    public function moveMomentUp($index)
    {
        $moments = $this->gallery['moments'] ?? [];
        if ($index > 0 && isset($moments[$index])) {
            [$moments[$index - 1], $moments[$index]] = [$moments[$index], $moments[$index - 1]];
            $this->gallery['moments'] = array_values($moments);
            $this->invitation->update(['gallery_data' => $this->gallery]);
            $this->dispatch('notify', message: 'Foto dipindah ke atas.', type: 'success');
        }
    }

    public function moveMomentDown($index)
    {
        $moments = $this->gallery['moments'] ?? [];
        if ($index < count($moments) - 1 && isset($moments[$index])) {
            [$moments[$index + 1], $moments[$index]] = [$moments[$index], $moments[$index + 1]];
            $this->gallery['moments'] = array_values($moments);
            $this->invitation->update(['gallery_data' => $this->gallery]);
            $this->dispatch('notify', message: 'Foto dipindah ke bawah.', type: 'success');
        }
    }

    // --- VALIDATION MESSAGES ---
    protected function messages()
    {
        return [
            'newCover.max' => 'Ukuran file terlalu besar (>10MB).',
            'newGroom.max' => 'Ukuran file terlalu besar (>10MB).',
            'newBride.max' => 'Ukuran file terlalu besar (>10MB).',
            'newMoments.*.max' => 'Ukuran file terlalu besar (>10MB).',
        ];
    }

    // --- HELPER: CHECK FILE SIZE STRICT ---
    private function checkFileSizeStrict($file, $propertyName)
    {
        // 10MB = 10 * 1024 * 1024 = 10485760 bytes
        if ($file && $file->getSize() > 10485760) {
            // Reset property
            $this->reset($propertyName);

            // Dispatch Error Modal
            $this->dispatch('show-upload-error-modal');
            return false;
        }
        return true;
    }

    // --- REALTIME VALIDATION FOR SINGLE FILES ---
    public function updatedNewCover()
    {
        if ($this->checkFileSizeStrict($this->newCover, 'newCover')) {
            $this->validate(['newCover' => 'image|max:10240']);
        }
    }

    public function updatedNewGroom()
    {
        if ($this->checkFileSizeStrict($this->newGroom, 'newGroom')) {
            $this->validate(['newGroom' => 'image|max:10240']);
        }
    }

    public function updatedNewBride()
    {
        if ($this->checkFileSizeStrict($this->newBride, 'newBride')) {
            $this->validate(['newBride' => 'image|max:10240']);
        }
    }

    public function updatedNewMoments()
    {
        // Filter out large files
        $validPhotos = [];
        $hasError = false;

        foreach ($this->newMoments as $photo) {
            if ($photo->getSize() > 10485760) {
                $hasError = true;
            } else {
                $validPhotos[] = $photo;
            }
        }

        if ($hasError) {
            $this->newMoments = $validPhotos; // Keep only valid ones
            $this->dispatch('show-upload-error-modal');
        }

        $this->validate([
            'newMoments.*' => 'image|max:10240', // 10MB max
        ]);

        foreach ($this->newMoments as $photo) {
            $this->gallery['moments'][] = $this->processImage($photo, 1000);
        }

        // Update Database Immediately
        $this->invitation->update(['gallery_data' => $this->gallery]);

        // Reset
        $this->reset('newMoments');

        // Notify
        $this->dispatch('notify', message: 'Foto berhasil disimpan otomatis!', type: 'success');
    }

    // --- MAIN ACTION: SAVE ---
    public function save()
    {
        $this->validate();

        // 1. PROSES UPLOAD GAMBAR
        if ($this->newCover)
            $this->gallery['cover'] = $this->processImage($this->newCover, 1080);
        if ($this->newGroom)
            $this->gallery['groom'] = $this->processImage($this->newGroom, 800);
        if ($this->newBride)
            $this->gallery['bride'] = $this->processImage($this->newBride, 800);

        // Note: newMoments processed automatically in updatedNewMoments
        // But keep fallback just in case
        if (!empty($this->newMoments)) {
            foreach ($this->newMoments as $photo) {
                $this->gallery['moments'][] = $this->processImage($photo, 1080);
            }
        }

        // Proses Upload Dress Code Palette
        if ($this->newPaletteImage) {
            $this->dressCode['palette_image'] = $this->processImage($this->newPaletteImage);
        }

        // 2. TENTUKAN PAKET & HARGA (CORE LOGIC)
        // Cari template yang dipilih di database
        $selectedTemplate = Template::where('slug', $this->theme_template)->first();

        // Fallback jika template tidak ditemukan (sangat jarang terjadi)
        $packageType = $selectedTemplate ? $selectedTemplate->tier : 'basic';

        if (Auth::user()->isAdmin()) {
            // ADMIN: Selalu Gratis & Paid
            $amount = 0;
            $paymentAction = null;
            $dueAmount = 0;
            $refundAmount = 0;

            // Pastikan status selalu paid dan aktif
            $this->invitation->payment_status = 'paid';
            $this->invitation->is_active = true;
        } else {
            // USER BIASA: Hitung Harga
            $amount = $selectedTemplate ? $selectedTemplate->price : 0;

            // 2.a HANDLE UPGRADE/DOWNGRADE
            $paymentAction = null;
            $dueAmount = 0;
            $refundAmount = 0;

            $previousAmount = (int) ($this->invitation->amount ?? 0);
            $previousStatus = $this->invitation->payment_status ?? 'unpaid';

            // Jika sebelumnya sudah paid dan memilih template lebih mahal -> unpaid lagi, bayar selisih
            if ($previousStatus === 'paid' && $amount > $previousAmount) {
                $paymentAction = 'upgraded';
                $dueAmount = $amount - $previousAmount;
                // Set unpaid agar user diarahkan ke pembayaran
                $this->invitation->payment_status = 'unpaid';
                $this->invitation->is_active = false;
                // Amount merepresentasikan selisih yang harus dibayar
                $amount = $dueAmount;
            }
            // Jika sebelumnya paid dan template lebih murah -> tandai downgraded dan hitung refund
            if ($previousStatus === 'paid' && $amount < $previousAmount) {
                $paymentAction = 'downgraded';
                $refundAmount = $previousAmount - $amount;
                // Tetap paid (admin bisa proses refund manual), undangan tetap aktif
            }
        }

        // 3. UPDATE DATABASE
        $this->invitation->update([
            'theme_template' => $this->theme_template,

            // Update Info Keuangan & Paket
            'package_type' => $packageType,
            'amount' => $amount,
            'payment_action' => $paymentAction,
            'due_amount' => $dueAmount,
            'refund_amount' => $refundAmount,
            'payment_status' => $this->invitation->payment_status,
            'is_active' => $this->invitation->is_active,

            // Update Data JSON
            'couple_data' => $this->couple,
            'event_data' => $this->events,
            'theme_config' => $this->theme,
            'gallery_data' => $this->gallery,
            'gifts_data' => $this->gifts,
            'dress_code_data' => $this->dressCode,
        ]);

        // 4. BERSIHKAN
        $this->reset(['newCover', 'newGroom', 'newBride', 'newMoments', 'newPaletteImage']);

        session()->flash('message', 'Perubahan disimpan!');
        $this->modalOpen = false;
    }

    public $deleteConfirmation = '';

    public function deleteInvitation()
    {
        if ($this->deleteConfirmation !== 'delete') {
            $this->addError('deleteConfirmation', 'Konfirmasi salah. Ketik "delete" untuk menghapus.');
            return;
        }

        if ($this->invitation) {
            $this->invitation->delete();
            session()->flash('message', 'Undangan berhasil dihapus.');
            return redirect()->route('dashboard.index');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.invitation.edit');
    }
}
