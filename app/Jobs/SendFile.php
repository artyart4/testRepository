<?php

namespace App\Jobs;

use App\Notifications\TelegramNotification;
use App\сontracts\NotificationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $file_path;
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Execute the job.
     *
     * @param NotificationInterface $notification
     * @return void
     */
    public function handle(NotificationInterface $notification)
    {
        \Illuminate\Support\Facades\Notification::send(auth()->user(), new $notification($this->file_path));
    }
}
