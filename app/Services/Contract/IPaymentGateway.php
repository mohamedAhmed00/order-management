<?php

namespace App\Services\Contract;

use App\Models\Order;

interface IPaymentGateway
{
    public function pay(Order $order);
}
