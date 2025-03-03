<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class cancledNotifcation extends Notification
{
    use Queueable;
  
    private $messages;
  
    public function __construct($messages)
    {
        $this->messages = $messages;
    }
  
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Annulation automatique de réservation')
                    ->greeting('Bonjour,')
                    ->line('Votre réservation a été automatiquement annulée.')
                    ->line($this->messages)
                    ->line('Si vous avez des questions, n\'hésitez pas à nous contacter.')
                    ->salutation('Cordialement,');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->messages
        ];
    }
}
