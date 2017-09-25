<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ClubAcceptance extends Notification
{
    use Queueable;

    protected $club;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($club)
    {
        $this->club = $club;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'title' =>  'Açılması talebinde bulunduğun '.$this->club->name.' isimli kulüp site tarafından onaylandı.',
            'link' => '/club/'.$this->club->abbreviation,
        ];
    }
}
