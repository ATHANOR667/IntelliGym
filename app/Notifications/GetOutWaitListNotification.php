<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\HourSlot;
use Illuminate\Notifications\Notification;

class GetOutWaitListNotification extends Notification
{
    use Queueable;

    public $slot ;

    /**
     * Create a new notification instance.
     */
    public function __construct(Hourslot $slot)
    {
        $this->slot = $slot ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the mail representation of the notification.
     */
    /*public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Vous êtes sorti de la liste d\'attente pour la seance du  : ' . $this->slot->d_o_w . ' debutant à ' . $this->slot->debut . ' heures.',
        ];
    }

}
