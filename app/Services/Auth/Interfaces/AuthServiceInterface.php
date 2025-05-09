<?php

namespace App\Services\Auth\Interfaces;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(Request $request): array;
    public function login(Request $request): array;
    public function me(): array;
    public function logout(): array;
}
