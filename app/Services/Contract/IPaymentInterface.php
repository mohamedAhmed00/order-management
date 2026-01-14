<?php

namespace App\Services\Contract;

use App\Models\Order;
use App\Models\Payment;

interface IPaymentInterface
{
    public function getAll(int $userID);

    public function pay(Order $order, string $method): Payment;
}
