<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * Ini PENTING untuk kolom JSON di SQLite.
     */
    protected $casts = [
        'theme_config' => 'array',
        'couple_data' => 'array',
        'event_data' => 'array', // Akan jadi array of objects
        'gallery_data' => 'array',
        'gifts_data' => 'array',
        'is_active' => 'boolean',
        'amount' => 'integer',
        'due_amount' => 'integer',
        'refund_amount' => 'integer',
    ];

    // // Definisi Paket (Bisa ditaruh di Config, tapi di sini biar cepat)
    // Definisi Paket Harga (Sesuai Gambar)
    const PACKAGES = [
        'basic' => [
            'name' => 'Undangan Digital Regular',
            'price' => 49000,
            'original_price' => 150000, // Harga coret
            'is_best_seller' => true,
            // Fitur visual untuk ditampilkan di Card (UI)
            'benefits' => [
                'Pengerjaan 1 hari',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event', // <-- Added
                'Fitur RSVP',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
                "Fitur kirim do'a & ucapan"
            ],
            // Fitur yang DIBATASI secara sistem (Logic Backend)
            // Regular di gambar punya Musik & Galeri, jadi kita hapus dari limitations.
            // Kita batasi 'love_story' karena itu ada di Custom.
            'limitations' => ['love_story', 'custom_css']
        ],
        'premium' => [
            'name' => 'Undangan Digital Custom',
            'price' => 150000,
            'original_price' => 500000, // Harga coret
            'is_best_seller' => true,
            'benefits' => [
                'Pengerjaan 1-2 hari',
                'Bebas custom',
                'Revisi Maksimal 3 Kali',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event', // <-- Added
                'Fitur RSVP',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
                // 'Filter Instagram', // <-- Removed
                'Custom love story',
                "Fitur kirim do'a & ucapan"
            ],
            'limitations' => [] // Full Access
        ],
    ];

    // --- Relationships ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relasi ke Template (PENTING: Kita hubungkan lewat slug)
    public function template()
    {
        return $this->belongsTo(Template::class, 'theme_template', 'slug');
    }

    // --- Helpers / Accessors ---
    public function getGroomNicknameAttribute()
    {
        return $this->couple_data['groom']['nickname'] ?? 'Groom';
    }

    // Cara pakai: $invitation->bride_nickname
    public function getBrideNicknameAttribute()
    {
        return $this->couple_data['bride']['nickname'] ?? 'Bride';
    }

    public function hasFeature($feature)
    {
        // 1. Ambil template yang dipakai
        $template = Template::where('slug', $this->theme_template)->first();

        // 2. Jika template tidak ditemukan (misal dihapus), fallback ke basic
        $tier = $template ? $template->tier : 'basic';

        // 3. Cek definisi tier di Model Template
        $limitations = Template::TIERS[$tier]['limitations'] ?? [];

        // 4. Return true jika fitur TIDAK ada di limitations
        return !in_array($feature, $limitations);
    }

    /**
     * Helper untuk mendapatkan Info Tier saat ini
     */
    public function getCurrentTierInfo()
    {
        $template = Template::where('slug', $this->theme_template)->first();
        $tier = $template ? $template->tier : 'basic';
        return Template::TIERS[$tier];
    }
}
