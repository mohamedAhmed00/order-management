<?php

namespace App\Services\Contract;

use App\Models\Order;

interface IOrderInterface
{
    public function getAll(int $userId, $request);

    public function create(array $products, int $userId);

    public function update(Order $order, array $data);

    public function delete(Order $order);
}
