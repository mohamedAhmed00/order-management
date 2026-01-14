<?php

namespace App\Services\Classes\PaymentGateway;

use App\DTO\PaymentResultDTO;
use App\Models\Order;
use App\Services\Contract\IPaymentGateway;

class Paypal implements IPaymentGateway
{

    public function pay(Order $order)
    {
        return new PaymentResultDTO(
            success: 'successful',
            transactionReference: 'PayPal-' . uniqid(),
            response: [
                'provider' => 'paypal',
                'message' => 'Payment completed'
            ]
        );
    }
}
