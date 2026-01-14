<?php

namespace App\Services\Contract;

use App\Models\Order;
use App\Models\Payment;

interface IAuthInterface
{
    public function register(array $data): string;

    public function login(array $data): string;
}
