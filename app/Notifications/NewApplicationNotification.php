<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    public function __construct(public readonly Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('New application received'),
            'body' => __(':name applied for ":commission".', [
                'name' => $this->application->freelancer->name,
                'commission' => $this->application->commission->title,
            ]),
            'link' => route('commissions.show', $this->application->commission_id),
        ];
    }
}
