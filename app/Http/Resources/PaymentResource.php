<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'method' => $this->method,
            'amount' => $this->amount,
            'status' => $this->status,
            'transaction_reference' => $this->transaction_reference,
            'created_at' => $this->created_at?->toISOString(),
        ];    }
}
