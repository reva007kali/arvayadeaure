<?php

use App\Livewire\LandingPage;
use Laravel\Fortify\Features;
use App\Livewire\Admin\ManageUser;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManageInvitation;
use App\Livewire\Frontend\ShowInvitation;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Dashboard\Guest\Index as GuestManager;
use App\Livewire\Dashboard\Message\Index as MessageManager;
use App\Livewire\Admin\ShowInvitation as AdminShowInvitation;
use App\Livewire\Dashboard\Invitation\Edit as InvitationEdit;
use App\Livewire\Dashboard\Invitation\Create as InvitationCreate;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. LANDING PAGE UTAMA (Halaman depan aplikasi SaaS kamu)
// Route::get('/', LandingPage::class)->name('home');
Route::get('/', function () {
    return view('welcome');
})->name('home');



// 3. DASHBOARD USER (Area Tertutup / Protected)
Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {

    // Halaman Utama Dashboard: Menampilkan List Undangan Saya
    Route::get('/', DashboardIndex::class)->name('index');

    // Buat Undangan Baru
    Route::get('/create', InvitationCreate::class)->name('create');

    // Grouping berdasarkan ID Undangan (Route Model Binding)
    // URL: /dashboard/1/edit, /dashboard/1/guests
    Route::prefix('{invitation}')->group(function () {
        
        // Edit Detail Undangan (Pengantin, Acara, Tema, Foto)
        // Kita bisa buat satu halaman panjang atau tabulasi di dalam component ini
        Route::get('/edit', InvitationEdit::class)->name('invitation.edit');

        // Manajemen Tamu (List, Tambah, Hapus, Kirim WA)
        Route::get('/guests', GuestManager::class)->name('guests.index');

        // Manajemen Pesan / Ucapan (Lihat, Reply, Hapus)
        Route::get('/messages', MessageManager::class)->name('messages.index');
        
    });

});

// routes admin

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin (Statistik)
    Route::get('/', AdminDashboard::class)->name('index');
    
    // Manajemen User
    Route::get('/users', ManageUser::class)->name('users');
    
    // Manajemen Undangan (Semua User)
    Route::get('/invitations', ManageInvitation::class)->name('invitations');

    Route::get('/invitations/{invitation}', AdminShowInvitation::class)->name('invitations.show');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// URL: domain.com/reza-adinda
// Parameter tamu (?to=bapak-budi) ditangani via Query String, bukan route parameter,
// jadi tidak perlu didefinisikan di sini.
Route::get('/{slug}', ShowInvitation::class)
    ->where('slug', '[a-zA-Z0-9\-]+') 
    ->name('invitation.show');
