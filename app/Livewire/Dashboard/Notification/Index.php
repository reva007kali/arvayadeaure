<?php

namespace App\Livewire\Dashboard\Notification;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        return view('livewire.dashboard.notification.index', [
            'notifications' => auth()->user()->notifications()->paginate(10)
        ]);
    }
}
