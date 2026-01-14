<?php

namespace App\Services\Classes;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\Contract\IOrderInterface;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService implements IOrderInterface
{

    public function getAll(int $userId, $request)
    {
        $query = Order::where('user_id', $userId);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->with(['products', 'payments'])->latest()->paginate(10);
    }

    public function create(array $products, int $userId): Order
    {
        return DB::transaction(function () use ($products, $userId) {
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'status' => OrderStatus::PENDING,
                'user_id' => $userId,
                'total_amount' => 0,
            ]);
            $totalAmount = 0;
            foreach ($products as $product) {
                $order->products()->create([
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
                $totalAmount += $product['quantity'] * $product['price'];
            }
            $order->update([
                'total_amount' => number_format($totalAmount, 2, '.', ''),
            ]);
            return $order->load('products');
        });
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    public function update(Order $order, array $data): Order
    {
        if ($order->status !== OrderStatus::PENDING) {
            throw new DomainException('Only pending orders can be updated');
        }

        return DB::transaction(function () use ($order, $data) {
            $order->products()->delete();
            $totalAmount = $order->total_amount;
            if ($data['products']){
                $totalAmount = 0;
                foreach ($data['products'] as $product) {
                    $order->products()->create([
                        'name' => $product['name'],
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                    ]);
                    $totalAmount += $product['quantity'] * $product['price'];
                }
            }
            $order->update([
                'status' => $data['status'],
                'total_amount' => $totalAmount,
            ]);
            return $order->load('products');
        });
    }

    public function delete(Order $order): void
    {
        if ($order->payments()->exists()) {
            throw new DomainException(__('Order with payments cannot be deleted'));
        }
        $order->update([
            'status' => OrderStatus::CANCELLED->value,
        ]);
    }
}
