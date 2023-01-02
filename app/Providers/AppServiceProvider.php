<?php

namespace App\Providers;

use App\Notifications\TelegramNotification;
use App\Services\PaymentService;
use App\сontracts\NotificationInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationInterface::class, TelegramNotification::class);
        $this->app->bind(PaymentService::class, function ($app){
            return new PaymentService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

    }
}
