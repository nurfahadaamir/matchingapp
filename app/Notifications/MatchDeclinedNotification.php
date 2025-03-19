<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MatchDeclinedNotification extends Notification
{
    use Queueable;

    protected $declinerName;

    public function __construct($declinerName)
    {
        $this->declinerName = $declinerName;
    }

    public function via($notifiable)
    {
        return ['database']; // Stores in the database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your match request was declined by ' . $this->declinerName
        ];
    }
}
