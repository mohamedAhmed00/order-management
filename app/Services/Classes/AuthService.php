<?php

namespace App\Services\Classes;

use App\Enums\OrderStatus;
use App\Factories\PaymentGatewayFactory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\Contract\IAuthInterface;
use App\Services\Contract\IPaymentInterface;
use DomainException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthInterface
{
    public function register(array $data): string
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return auth()->login($user);
    }

    public function login(array $data): string
    {
        if (!$token = auth()->attempt($data)) {
            throw new DomainException(__('Invalid credentials'));
        }

        return $token;
    }
}
