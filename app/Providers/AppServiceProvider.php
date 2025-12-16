<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\PaymentCompleted;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\SendPaymentNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            OrderPlaced::class,
            SendOrderConfirmation::class,
        );

        Event::listen(
            PaymentCompleted::class,
            SendPaymentNotification::class,
        );
    }
}
