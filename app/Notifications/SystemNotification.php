<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected $message;

    protected $link;

    public function __construct($message, $link = null)
    {
        $this->message = $message;

        $this->link = $link;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [

            'message' => $this->message,

            'link' => $this->link

        ];
    }
}