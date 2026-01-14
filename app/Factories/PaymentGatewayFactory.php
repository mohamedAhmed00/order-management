<?php

namespace App\Factories;

use App\Services\Classes\PaymentGateway\CreditCard;
use App\Services\Classes\PaymentGateway\Paypal;
use App\Services\Contract\IPaymentGateway;
use DomainException;

class PaymentGatewayFactory
{
    public function make(string $method): IPaymentGateway
    {
        return match ($method) {
            'credit_card' => new CreditCard(),
            'paypal' => new Paypal(),
            default => throw new DomainException('Unsupported payment method'),
        };
    }
}
