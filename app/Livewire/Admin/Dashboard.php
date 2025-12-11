<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Guest;
use Livewire\Component;
use App\Models\Invitation;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalInvitations' => Invitation::count(),
            'activeInvitations' => Invitation::where('is_active', true)->count(),
            'totalGuests' => Guest::count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }
}
