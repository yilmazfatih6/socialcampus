<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AttendanceRequest extends Notification
{
    use Queueable;

    protected $sender;
    protected $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $event)
    {
        $this->sender = $sender;
        $this->event = $event;
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
        if ($this->event->isFree()) {
            return [
                'title' =>  $this->sender->getName().', organizatörü olduğun  '.$this->event->name.' etkinliğine katılıyor.',
                'sender' => $this->sender,
                'event' => $this->event,
                'link' => '/event/'.$this->event->id,
            ];
        }

        return [
            'title' => $this->sender->getName().', organizatörü olduğun '.$this->event->name.' etkinliğine katılım isteği gönderdi.',
            'sender' => $this->sender,
            'event' => $this->event,
            'link' => '/event/'.$this->event->id,
        ];
    }
}
