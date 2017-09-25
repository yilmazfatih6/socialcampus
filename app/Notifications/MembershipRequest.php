<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MembershipRequest extends Notification
{
    use Queueable;

    protected $sender;
    protected $club;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $club)
    {
        $this->sender = $sender;
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
            'title' =>  $this->sender->getName().', yöneticisi olduğun '.$this->club->name.' için katılım isteği gönderdi.',
            'sender' => $this->sender,
            'club' => $this->club,
            'link' => '/club/'.$this->club->abbreviation,
        ];
    }
}
