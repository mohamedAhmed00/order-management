<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at?->toISOString(),

            'products' => ProductResource::collection($this->whenLoaded('products')),

            'payments' => PaymentResource::collection(
                $this->whenLoaded('payments')
            ),
        ];
    }
}
