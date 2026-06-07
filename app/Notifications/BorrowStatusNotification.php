<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowStatusNotification extends Notification
{
    use Queueable;

    public $borrow;
    public $status;

    public function __construct($borrow, $status)
    {
        $this->borrow = $borrow;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Borrow Request Update')
            ->line('Your borrow request has been updated.')
            ->line('Reference Number: ' . $this->borrow->reference_number)
            ->line('Status: ' . strtoupper($this->status))
            ->line('Thank you for using Smart LogBook System.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}