<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $senderName;
    public $messageContent;
    public $invitationTitle;
    public $invitationId;

    /**
     * Create a new notification instance.
     */
    public function __construct($senderName, $messageContent, $invitationTitle, $invitationId)
    {
        $this->senderName = $senderName;
        $this->messageContent = $messageContent;
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
        return (new MailMessage)
            ->subject('Ucapan Baru dari ' . $this->senderName)
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Anda menerima ucapan/doa baru di undangan Anda.')
            ->line('**Dari:** ' . $this->senderName)
            ->line('**Pesan:** "' . $this->messageContent . '"')
            ->line('**Undangan:** ' . $this->invitationTitle)
            ->action('Balas Pesan', route('dashboard.messages.index', $this->invitationId))
            ->line('Terima kasih telah menggunakan Arvaya!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Ucapan Baru',
            'message' => "{$this->senderName} mengirim ucapan: \"{$this->messageContent}\"",
            'action_url' => route('dashboard.messages.index', $this->invitationId),
            'type' => 'message',
            'invitation_id' => $this->invitationId
        ];
    }
}
