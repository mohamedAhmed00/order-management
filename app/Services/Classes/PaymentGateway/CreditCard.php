<?php

namespace App\Services\Classes\PaymentGateway;

use App\DTO\PaymentResultDTO;
use App\Models\Order;
use App\Services\Contract\IPaymentGateway;

class CreditCard implements IPaymentGateway
{

    public function pay(Order $order)
    {
        // $apiKey = config("payments.gateways.credit_card.api_key");

        return new PaymentResultDTO(
            success: 'successful',
            transactionReference: 'CreditCard-' . uniqid(),
            response: [
                'provider' => 'credit_card',
                'message' => __('Payment approved')
            ]
        );
    }
}
