<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = [];

    // Helper untuk cek apakah template ini dipakai
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'theme_template', 'slug');
    }
}
