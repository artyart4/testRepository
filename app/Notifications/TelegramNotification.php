<?php

namespace App\Notifications;

use App\сontracts\NotificationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramFile;

class TelegramNotification extends Notification implements NotificationInterface
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $file_path;
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram()
    {

        return TelegramFile::create()->content('Awesome *bold* text and [inline URL](http://www.example.com/)')
            ->document(public_path('/storage/'.$this->file_path), 'simple.pdf'); // local photo
    }

}
