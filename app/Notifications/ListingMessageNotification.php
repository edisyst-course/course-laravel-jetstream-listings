<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingMessageNotification extends Notification
{
    use Queueable;

    public $name;
    public $email;
    public $listingTitle;
    public $messageText;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->name = $message['name'];
        $this->email = $message['email'];
        $this->listingTitle = $message['listingTitle'];
        $this->messageText = $message['messageText'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Un utente ha chiesto informazioni su un tuo prodotto')
            ->line('**Utente**: ' . $this->name)
            ->line('**Prodotto**: ' . $this->listingTitle)
            ->line('**Messaggio**: ' . $this->messageText)
            ->line('*Grazie per aver utilizzato il nostro servizio!*');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
