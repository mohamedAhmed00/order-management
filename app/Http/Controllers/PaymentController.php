<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Services\Contract\IPaymentInterface;

class PaymentController extends Controller
{
    public function __construct(private readonly IPaymentInterface $paymentService) {}

    public function index()
    {
        return PaymentResource::collection($this->paymentService->getAll(auth()->id()));
    }

    public function pay(PaymentRequest $paymentRequest, Order $order)
    {
        $payment = $this->paymentService->pay(
            $order,
            $paymentRequest->input('method')
        );

        return response()->json([
            'message' => __('Payment processed'),
            'data' => $payment,
        ], 201);
    }
}
