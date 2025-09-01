<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsMenu extends Component
{
    public $notifications;
    public $unseenCount = 0;

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function mount(): void
    {
        $this->loadNotifications();
    }

    public function loadNotifications(): void
    {
        $this->notifications = Notification::where('assigned_to_user_id', Auth::id())
            ->latest()
            ->take(20)
            ->get();

        $this->unseenCount = Notification::where('assigned_to_user_id', Auth::id())
            ->where('viewed', false)
            ->count();
    }

    public function markAsRead(): void
    {
        Notification::where('assigned_to_user_id', Auth::id())
            ->where('viewed', false)
            ->update([
                'viewed' => true,
                'viewed_at' => now(),
            ]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin.notifications-menu');
    }
}
