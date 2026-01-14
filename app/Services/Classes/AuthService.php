<?php

namespace App\Services\Classes;

use App\Models\User;
use App\Services\Contract\IAuthInterface;
use DomainException;
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
