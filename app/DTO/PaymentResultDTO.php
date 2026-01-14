<?php

namespace App\DTO;

class PaymentResultDTO
{
    public function __construct(
        public string $success,
        public string $transactionReference,
        public array $response = []
    ) {}
}
