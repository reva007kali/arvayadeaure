<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'theme_template',
        'theme_config',
        'couple_data',
        'event_data',
        'gallery_data',
        'gifts_data',
        'ai_wishes_summary',
        'is_active',
        'visit_count',
        'package_type',
        'amount',
        'payment_status',
        'payment_proof',
        'active_until',
    ];

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
    ];

    // // Definisi Paket (Bisa ditaruh di Config, tapi di sini biar cepat)
    const PACKAGES = [
        'basic' => [
            'name' => 'Arvaya Basic',
            'price' => 49000,
            'features' => ['rsvp', 'guest_book'], // Fitur yang didapat
            'limitations' => ['music', 'gallery'] // Fitur yang DIKUNCI
        ],
        'premium' => [
            'name' => 'Arvaya Premium',
            'price' => 99000,
            'features' => ['rsvp', 'guest_book', 'gallery', 'music'],
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

    // Helper Cek Fitur
    public function hasFeature($featureName)
    {
        // Jika paketnya basic, cek apakah fitur ini ada di limitations
        $package = self::PACKAGES[$this->package_type] ?? self::PACKAGES['basic'];

        if (in_array($featureName, $package['limitations'])) {
            return false;
        }
        return true;
    }
}
