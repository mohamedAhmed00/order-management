<?php

namespace App\Services\Contract;

interface IAuthInterface
{
    public function register(array $data): string;

    public function login(array $data): string;
}
