<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Broadcast;

class RepliedToThread extends Notification
{
    use Queueable;
    public $thread;
    public $data;
    public $sender;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender,$data)
    {
        $this->sender=$sender;
        $this->data=$data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [/*'mail',*/'database','broadcast'];
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
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        //dd($notifiable);
        return [
            //
            /*'thread'=>$this->thread,*/
            'repliedTime'=>Carbon::now(),
            'user'=>$notifiable,
            'sender'=>$this->sender,
            'content'=>$this->data
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        //dd($notifiable);
        return new BroadcastMessage([
            'repliedTime'=>Carbon::now(),
            'user'=>$notifiable,
            'sender'=>$this->sender,
            'content'=>$this->data
        ]);
//        return [
//            //
//            /*'thread'=>$this->thread,*/
//            'repliedTime'=>Carbon::now(),
//            'user'=>$notifiable,
//            'sender'=>$this->sender,
//            'content'=>$this->data
//        ];
    }
}
