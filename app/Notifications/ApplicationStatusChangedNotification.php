<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Notification;

class ApplicationStatusChangedNotification extends Notification
{
    public function __construct(public readonly Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isAccepted = $this->application->status === 'accepted';

        return [
            'title' => $isAccepted ? __('Application accepted') : __('Application rejected'),
            'body' => $isAccepted
                ? __('Your application for ":commission" has been accepted.', ['commission' => $this->application->commission->title])
                : __('Your application for ":commission" has been rejected.', ['commission' => $this->application->commission->title]),
            'link' => route('commissions.show', $this->application->commission_id),
        ];
    }
}
