<?php

namespace App\Services\Classes;

use App\Enums\OrderStatus;
use App\Factories\PaymentGatewayFactory;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Contract\IPaymentInterface;
use DomainException;

class PaymentService implements IPaymentInterface
{
    public function __construct(
        private PaymentGatewayFactory $factory
    ) {}

    public function getAll(int $userID)
    {
        return Payment::whereHas('order', function ($q) use ($userID) {
            $q->where('user_id', $userID);
        })->latest()->paginate(10);
    }
    public function pay(Order $order, string $method): Payment
    {
        if ($order->status !== OrderStatus::CONFIRMED) {
            throw new DomainException(__('Order must be confirmed before payment'));
        }

        $gateway = $this->factory->make($method);
        $result  = $gateway->pay($order);

        return $order->payments()->create([
            'method' => $method,
            'amount' => $order->total_amount,
            'transaction_reference' => $result->transactionReference,
            'status' => $result->success,
            'response' => $result->response,
        ]);
    }
}
