<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GuestRsvpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $guestName;
    public $status;
    public $invitationTitle;
    public $invitationId;

    /**
     * Create a new notification instance.
     */
    public function __construct($guestName, $status, $invitationTitle, $invitationId)
    {
        $this->guestName = $guestName;
        $this->status = $status;
        $this->invitationTitle = $invitationTitle;
        $this->invitationId = $invitationId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = match ($this->status) {
            1 => 'Hadir',
            2 => 'Tidak Hadir',
            default => 'Pending'
        };

        return (new MailMessage)
            ->subject('RSVP Baru: ' . $this->guestName)
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Tamu Anda telah melakukan konfirmasi kehadiran.')
            ->line('**Nama:** ' . $this->guestName)
            ->line('**Status:** ' . $statusText)
            ->line('**Undangan:** ' . $this->invitationTitle)
            ->action('Lihat Daftar Tamu', route('dashboard.guests.index', $this->invitationId))
            ->line('Terima kasih telah menggunakan Arvaya!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = match ($this->status) {
            1 => 'Hadir',
            2 => 'Tidak Hadir',
            default => 'Pending'
        };

        return [
            'title' => 'RSVP Baru',
            'message' => "{$this->guestName} akan {$statusText} di undangan {$this->invitationTitle}",
            'action_url' => route('dashboard.guests.index', $this->invitationId),
            'type' => 'rsvp',
            'invitation_id' => $this->invitationId
        ];
    }
}
