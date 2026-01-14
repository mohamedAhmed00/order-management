<?php

namespace App\Providers;

use App\Services\Classes\AuthService;
use App\Services\Classes\OrderService;
use App\Services\Classes\PaymentService;
use App\Services\Contract\IAuthInterface;
use App\Services\Contract\IOrderInterface;
use App\Services\Contract\IPaymentInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->app->scoped(IAuthInterface::class, AuthService::class);
        $this->app->scoped(IOrderInterface::class, OrderService::class);
        $this->app->scoped(IPaymentInterface::class, PaymentService::class);
    }
}
