<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FollowRequest extends Notification
{
    use Queueable;

    protected $sender;
    protected $page;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $page)
    {
        $this->sender = $sender;
        $this->page = $page;
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
            'title' =>  $this->sender->getName().', yöneticisi olduğun '.$this->page->name.' sayfasını takip etmeye başladı.',
            'sender' => $this->sender,
            'page' => $this->page,
            'link' => '/page/'.$this->page->abbr,
        ];
    }
}
