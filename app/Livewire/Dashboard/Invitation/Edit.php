<?php

namespace App\Livewire\Dashboard\Invitation;

// Import class dasar Livewire untuk membuat component
use Livewire\Component;
// Import trait untuk menangani upload file
use Livewire\WithFileUploads;
// Import attribute untuk menentukan layout blade
use Livewire\Attributes\Layout;
// Import class ImageManager untuk manipulasi gambar (Intervention Image)
use Intervention\Image\ImageManager;
// Import Driver GD (bawaan PHP) untuk pemrosesan gambar
use Intervention\Image\Drivers\Gd\Driver;
// Import Facades Storage untuk menyimpan file ke disk
use Illuminate\Support\Facades\Storage;
// Import Helper String untuk generate nama file acak
use Illuminate\Support\Str;
// Import Model Invitation dan Template
use App\Models\Invitation;
use App\Models\Template;
// Import Service custom kita untuk AI
use App\Services\OpenAIService;

class Edit extends Component
{
    // Menggunakan trait ini agar Livewire bisa menangani input type="file"
    use WithFileUploads;

    // Properti utama untuk menyimpan data undangan yang sedang diedit
    public Invitation $invitation;

    // Properti untuk mengontrol tab mana yang sedang aktif di view (default: gallery)
    public $activeTab = 'couple';

    // --- PROPERTI DATA (Binding ke Form) ---

    // Menyimpan slug template yang dipilih
    public $theme_template;

    // Array untuk menampung list template yang tersedia dari DB
    public $availableTemplates = [];

    // Array data JSON dari database yang di-decode agar bisa diedit di form
    public $couple = []; // Data pengantin
    public $events = []; // Data acara
    public $theme = [];  // Konfigurasi warna/musik
    public $gifts = [];  // Data rekening/bank

    // --- PROPERTI GALERI (Struktur Baru) ---

    // Array utama untuk menyimpan path foto yang SUDAH tersimpan di DB
    public $gallery = [
        'cover' => null,   // Path foto sampul
        'groom' => null,   // Path foto mempelai pria
        'bride' => null,   // Path foto mempelai wanita
        'moments' => [],   // Array berisi banyak foto galeri umum
    ];

    // Properti Temporary (Sementara) untuk file yang BARU dipilih user (belum disave)
    public $newCover;      // File objek untuk cover baru
    public $newGroom;      // File objek untuk foto pria baru
    public $newBride;      // File objek untuk foto wanita baru
    public $newMoments = []; // Array file objek untuk momen baru

    // --- PROPERTI AI ---

    // Status loading saat request ke OpenAI (true/false)
    public $isGeneratingAi = false;
    // Pilihan nada bicara AI (islami, modern, dll)
    public $aiTone = 'islami';

    // Method untuk menentukan aturan validasi input
    protected function rules()
    {
        return [
            'theme_template' => 'required|string', // Template wajib dipilih
            'couple.groom.nickname' => 'required', // Nama panggilan pria wajib
            'couple.bride.nickname' => 'required', // Nama panggilan wanita wajib
            'events.*.title' => 'required',        // Judul setiap acara wajib
            'events.*.date' => 'required',         // Tanggal acara wajib
            'gifts.*.bank_name' => 'required',     // Nama bank wajib (jika ada input gift)
            'gifts.*.account_number' => 'required|numeric', // No rek wajib angka
        ];
    }

    // Method yang dijalankan PERTAMA KALI saat component dimuat
    public function mount(Invitation $invitation)
    {
        // CEK KEAMANAN: Pastikan yang edit adalah pemilik undangan
        if ($invitation->user_id !== auth()->id()) {
            abort(403); // Jika bukan, stop dan tampilkan error 403 Forbidden
        }

        // Masukkan data undangan dari route ke properti component
        $this->invitation = $invitation;

        // --- 1. LOAD DATA TEMPLATE ---
        // Ambil semua template yang statusnya aktif dari database
        $this->availableTemplates = Template::where('is_active', true)->get();
        // Set template yang terpilih saat ini (atau default jika null)
        $this->theme_template = $invitation->theme_template ?? 'default';

        // --- 2. LOAD DATA COUPLE (PENGANTIN) ---
        // Siapkan struktur default agar tidak error jika data di DB kosong
        $defaultCouple = [
            'groom' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'bride' => ['nickname' => '', 'fullname' => '', 'father' => '', 'mother' => '', 'instagram' => ''],
            'quote' => ''
        ];
        // Gabungkan default dengan data dari DB (DB menimpa default)
        $this->couple = array_replace_recursive($defaultCouple, $invitation->couple_data ?? []);

        // --- 3. LOAD DATA EVENTS (ACARA) ---
        $this->events = $invitation->event_data ?? [];
        // Jika belum ada acara sama sekali, buatkan 1 acara kosong sebagai placeholder
        if (empty($this->events)) {
            $this->events[] = ['title' => 'Akad Nikah', 'date' => '', 'location' => '', 'address' => '', 'map_link' => ''];
        }

        // --- 4. LOAD CONFIG TEMA ---
        $defaultTheme = ['primary_color' => '#d4af37', 'font' => 'sans', 'music_url' => ''];
        $this->theme = array_replace_recursive($defaultTheme, $invitation->theme_config ?? []);

        // --- 5. LOAD GIFTS (HADIAH) ---
        $this->gifts = $invitation->gifts_data ?? [];

        // --- 6. LOAD GALLERY (LOGIKA KHUSUS) ---
        // Struktur gallery yang kita inginkan (Associative Array)
        $defaultGallery = [
            'cover' => null,
            'groom' => null,
            'bride' => null,
            'moments' => []
        ];

        // Ambil data mentah dari DB
        $dbGallery = $invitation->gallery_data ?? [];

        // Cek: Apakah data lama (array biasa [0,1,2]) atau data baru (['cover'=>...])?
        // isset($dbGallery[0]) true berarti ini array biasa/indexed (format lama)
        if (isset($dbGallery[0])) {
            // Migrasi data lama: Masukkan semua foto lama ke dalam 'moments'
            $this->gallery = array_merge($defaultGallery, ['moments' => $dbGallery]);
        } else {
            // Data sudah format baru, gabungkan dengan default
            $this->gallery = array_replace_recursive($defaultGallery, $dbGallery);
        }
    }

    // --- FITUR AI GENERATOR ---
    public function generateQuote()
    {
        // Ambil nama panggilan dari properti lokal
        $groom = $this->couple['groom']['nickname'] ?? 'Mempelai Pria';
        $bride = $this->couple['bride']['nickname'] ?? 'Mempelai Wanita';

        // Validasi: Jangan jalankan AI kalau nama kosong
        if (empty($groom) || empty($bride)) {
            $this->dispatch('notify', message: 'Isi nama panggilan dulu ya!', type: 'error');
            return;
        }

        // Set status loading (untuk disable tombol di view)
        $this->isGeneratingAi = true;

        // Panggil Service OpenAI (Request ke API)
        // Parameter: Nama Pria, Nama Wanita, Nada Bicara
        $result = OpenAIService::generateWeddingQuote($groom, $bride, $this->aiTone);

        // Masukkan hasil teks dari AI ke textarea quote
        $this->couple['quote'] = $result;

        // Matikan status loading
        $this->isGeneratingAi = false;
        // Tampilkan notifikasi sukses (Toast)
        $this->dispatch('notify', message: 'Kata-kata berhasil dibuat AI!', type: 'success');
    }

    // --- HELPER FUNCTION: KOMPRESI GAMBAR ---
    // Fungsi ini private, hanya dipanggil di dalam file ini
    // Menerima file foto dan target lebar (width)
    private function processImage($file, $width = 1200)
    {
        // Inisialisasi Intervention Image Manager dengan driver GD
        $manager = new ImageManager(new Driver());

        // Buat nama file acak 40 karakter + ekstensi .webp
        $filename = Str::random(40) . '.webp';

        // Tentukan folder penyimpanan: storage/app/public/invitations/{ID_UNDANGAN}
        $folder = 'invitations/' . $this->invitation->id;
        $path = $folder . '/' . $filename;

        try {
            // 1. Baca file gambar dari memori sementara (temporary)
            $image = $manager->read($file->getRealPath());

            // 2. Resize: Kecilkan lebar gambar sesuai parameter $width
            // Tinggi akan menyesuaikan proporsi (aspect ratio maintained)
            $image->scaleDown(width: $width);

            // 3. Convert & Compress: Ubah ke format WebP dengan kualitas 80%
            // WebP jauh lebih ringan dari JPG/PNG
            $encoded = $image->toWebp(quality: 80);

            // 4. Simpan file hasil kompresi ke disk 'public'
            Storage::disk('public')->put($path, (string) $encoded);

            // Kembalikan path lengkap untuk disimpan di DB
            return 'storage/' . $path;

        } catch (\Exception $e) {
            // Fallback: Jika proses resize/convert gagal (misal server tidak support)
            // Simpan file asli apa adanya tanpa edit
            return 'storage/' . $file->store($folder, 'public');
        }
    }

    // --- LOGIKA TOMBOL HAPUS & TAMBAH ---

    // Tambah baris acara baru
    public function addEvent()
    {
        $this->events[] = [
            'title' => 'Acara Baru',
            'date' => '',
            'location' => '',
            'address' => '',
            'map_link' => ''
        ];
    }

    // Hapus acara berdasarkan index array
    public function removeEvent($index)
    {
        unset($this->events[$index]); // Hapus item
        $this->events = array_values($this->events); // Urutkan ulang index array (re-index)
    }

    // Hapus foto spesifik (Cover, Groom, Bride)
    public function removeSpecific($key)
    {
        // Set nilainya jadi null (kosong)
        $this->gallery[$key] = null;
    }

    // Hapus salah satu foto dari galeri moments
    public function removeMoment($index)
    {
        unset($this->gallery['moments'][$index]);
        $this->gallery['moments'] = array_values($this->gallery['moments']); // Re-index array
    }

    // Tambah baris rekening bank
    public function addGift()
    {
        $this->gifts[] = ['bank_name' => '', 'account_name' => '', 'account_number' => ''];
    }

    // Hapus rekening bank
    public function removeGift($index)
    {
        unset($this->gifts[$index]);
        $this->gifts = array_values($this->gifts);
    }

    // --- PROSES SIMPAN UTAMA ---
    public function save()
    {
        // 1. Jalankan validasi sesuai rules() di atas
        $this->validate();

        // 2. PROSES UPLOAD FOTO (Menggunakan Helper processImage)

        // A. Cek apakah ada upload Cover baru?
        if ($this->newCover) {
            // Proses gambar, resize lebar max 1080px
            $this->gallery['cover'] = $this->processImage($this->newCover, 1080);
        }

        // B. Cek foto Groom baru?
        if ($this->newGroom) {
            // Resize lebar max 800px (cukup untuk foto profil)
            $this->gallery['groom'] = $this->processImage($this->newGroom, 800);
        }

        // C. Cek foto Bride baru?
        if ($this->newBride) {
            $this->gallery['bride'] = $this->processImage($this->newBride, 800);
        }

        // D. Cek foto Moments (Bisa banyak sekaligus)
        foreach ($this->newMoments as $photo) {
            // Loop setiap foto, proses, lalu tambahkan ke array moments
            $this->gallery['moments'][] = $this->processImage($photo, 1000);
        }

        // 3. UPDATE DATABASE
        // Method update() eloquent akan menyimpan data ke tabel invitations
        $this->invitation->update([
            'theme_template' => $this->theme_template, // Simpan slug template
            'couple_data' => $this->couple,         // Simpan data pengantin (Array -> JSON)
            'event_data' => $this->events,         // Simpan data acara
            'theme_config' => $this->theme,          // Simpan config tema
            'gallery_data' => $this->gallery,        // Simpan struktur galeri baru
            'gifts_data' => $this->gifts,          // Simpan data bank
        ]);

        // 4. BERSIHKAN INPUT FILE SEMENTARA
        // Agar form upload kembali kosong setelah save
        $this->reset(['newCover', 'newGroom', 'newBride', 'newMoments']);

        // 5. BERI FEEDBACK KE USER
        // Tampilkan pesan sukses (biasanya muncul sebagai toast/alert)
        session()->flash('message', 'Perubahan berhasil disimpan!');
    }

    // Method render wajib untuk Livewire, menunjuk ke file view blade
    public function render()
    {
        return view('livewire.dashboard.invitation.edit');
    }
}