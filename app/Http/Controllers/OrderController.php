<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Contract\IOrderInterface;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    public function __construct(private readonly IOrderInterface $orderService)
    {
    }

    public function index()
    {
        return OrderResource::collection($this->orderService->getAll(auth()->id(), request()));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->create($request->validated()['products'], $request->user()->id);
        return response()->json([
            'message' => __('Order created successfully.'),
            'data' => new OrderResource($order),
        ], 201);
    }

    public function show(Order $order)
    {
        $order->load(['products', 'payments']);
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order = $this->orderService->update($order, $request->validated());
        return response()->json([
            'message' => __('Order updated successfully'),
            'data' => new OrderResource($order),
        ]);
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return response()->json(null, 204);
    }
}
