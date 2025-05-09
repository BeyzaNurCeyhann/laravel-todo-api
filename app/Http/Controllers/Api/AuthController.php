<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Auth\Interfaces\AuthServiceInterface;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $result = $this->authService->register($request);
        return response()->json($result, $result['code']);
    }

    public function login(Request $request)
    {
        $result = $this->authService->login($request);
        return response()->json($result, $result['code']);
    }

    public function me()
    {
        $result = $this->authService->me();
        return response()->json($result, $result['code']);
    }

    public function logout()
    {
        $result = $this->authService->logout();
        return response()->json($result, $result['code']);
    }
}
