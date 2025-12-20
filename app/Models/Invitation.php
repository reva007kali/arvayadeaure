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
        'dress_code_data' => 'array',
        'is_active' => 'boolean',
        'amount' => 'integer',
        'due_amount' => 'integer',
        'refund_amount' => 'integer',
        'expires_at' => 'datetime',
    ];

    // // Definisi Paket (Bisa ditaruh di Config, tapi di sini biar cepat)
    // Definisi Paket Harga (Sesuai Gambar)
    const PACKAGES = [
        'basic' => [
            'name' => 'Undangan Digital Regular',
            'price' => 49000,
            'original_price' => 150000, // Harga coret
            'is_best_seller' => true,
            'duration_months' => 3, // Aktif 3 bulan
            // Fitur visual untuk ditampilkan di Card (UI)
            'benefits' => [
                'Pengerjaan 1 hari',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
            ],
            // Fitur yang DIBATASI secara sistem (Logic Backend)
            'limitations' => ['love_story', 'custom_css', 'dress_code', 'rsvp', 'guest_book']
        ],
        'premium' => [
            'name' => 'Undangan Digital Custom',
            'price' => 150000,
            'original_price' => 500000, // Harga coret
            'is_best_seller' => true,
            'duration_months' => 6, // Aktif 6 bulan
            'benefits' => [
                'Pengerjaan 1-2 hari',
                'Bebas custom',
                'Revisi Maksimal 3 Kali',
                'Subdomain nama kamu',
                'Tema undangan aesthetic',
                'Sebar undangan tanpa batas',
                'Request Backsound',
                'Google maps lokasi acara',
                'Countdown Event',
                'Fitur RSVP',
                'Angpao Digital',
                'Unlimited Galeri',
                'Wedding gift',
                'Fitur kirim do\'a & ucapan',
                'Dress Code Guide',
            ],
            'limitations' => [] // Full Access (kecuali exclusive features jika ada)
        ],
        'exclusive' => [
            'name' => 'Undangan Digital Exclusive',
            'price' => 250000,
            'original_price' => 750000,
            'is_best_seller' => false,
            'duration_months' => null, // Aktif Selamanya (Forever)
            'benefits' => [
                'Aktif Selamanya',
                'Prioritas Pengerjaan',
                'Semua Fitur Premium',
                'Custom Domain (.com)',
                'Dedicated Support',
            ],
            'limitations' => []
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
        // 1. Ambil package_type dari Invitation (Fallback ke Basic jika null)
        $package = $this->package_type ?? 'basic';

        // 2. Ambil limitations dari konstanta PACKAGES
        $limitations = self::PACKAGES[$package]['limitations'] ?? [];

        // 3. Return true jika fitur TIDAK ada di limitations
        return !in_array($feature, $limitations);
    }

    /**
     * Helper untuk mendapatkan Info Tier saat ini
     */
    public function getCurrentTierInfo()
    {
        $package = $this->package_type ?? 'basic';
        return self::PACKAGES[$package] ?? self::PACKAGES['basic'];
    }
}
