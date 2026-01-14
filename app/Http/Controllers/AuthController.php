<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Contract\IAuthInterface;

class AuthController extends Controller
{
    public function __construct(private readonly IAuthInterface $authService) {}

    public function register(RegisterRequest $registerRequest)
    {
        return response()->json([
            'message' => __('User registered successfully'),
            'data' => [
                'access_token' => $this->authService->register($registerRequest->validated()),
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
        ], 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        return response()->json([
            'access_token' => $this->authService->login($loginRequest->validated()),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]
        );
    }
}
