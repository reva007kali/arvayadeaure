<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invitation;
use App\Models\Message;
use App\Models\Guest;
use App\Notifications\NewMessageNotification;

class GuestBook extends Component
{
    // Remove WithPagination trait as we are implementing custom load more logic
    // use WithPagination;

    public Invitation $invitation;
    public ?Guest $guest = null;

    // Form
    public $sender_name = '';
    public $content = '';

    // Load More Config
    public $perPage = 5;
    public $hasMoreMessages = true;

    public function loadMore()
    {
        $this->perPage += 5;
    }

    // Config (Removed paginationView as it's no longer needed)
    // protected function paginationView()
    // {
    //    return 'livewire.guestbook-pagination';
    // }

    public function mount($invitation, $guest = null)
    {
        $this->invitation = $invitation;
        $this->guest = $guest;

        if ($guest) {
            $this->sender_name = $guest->name;
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'sender_name' => 'required|string|max:50',
            'content' => 'required|string|max:500',
        ]);

        $msg = Message::create([
            'invitation_id' => $this->invitation->id,
            'guest_id' => $this->guest?->id,
            'sender_name' => $this->sender_name,
            'content' => $this->content,
        ]);

        // --- DISPATCH NOTIFICATION ---
        if ($this->invitation->user) {
            $this->invitation->user->notify(new NewMessageNotification(
                $this->sender_name,
                $this->content,
                $this->invitation->title,
                $this->invitation->id
            ));
        }

        $this->content = ''; // Reset pesan

        session()->flash('msg_status', 'Ucapan berhasil dikirim!');
    }

    public function render()
    {
        // Get total count first to determine if there are more messages
        $totalMessages = $this->invitation->messages()
            ->whereNull('parent_id')
            ->count();

        $this->hasMoreMessages = $totalMessages > $this->perPage;

        // Ambil pesan utama (bukan reply), urutkan terbaru
        $messages = $this->invitation->messages()
            ->whereNull('parent_id')
            ->with('replies') // Eager load reply dari mempelai
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.frontend.guest-book', [
            'messages' => $messages,
            'total_messages' => $totalMessages
        ]);
    }
}