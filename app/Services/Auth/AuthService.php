<?php

namespace App\Services\Auth;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'in:user,admin'
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->errors(), 'code' => 422];
        }

        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'status' => 'success',
            'data' => [
                'token' => $token,
                'user' => $user,
            ],
            'code' => 201
        ];
    }

    public function login(Request $request): array
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ['status' => 'error', 'message' => 'Invalid credentials', 'code' => 401];
            }
        } catch (JWTException $e) {
            return ['status' => 'error', 'message' => 'Token creation failed', 'code' => 500];
        }

        return [
            'status' => 'success',
            'data' => [
                'token' => $token,
                'user' => auth()->user(),
            ],
            'code' => 200
        ];
    }

    public function me(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'user' => auth()->user()
            ],
            'code' => 200
        ];
    }

    public function logout(): array
    {
        auth()->logout();

        return [
            'status' => 'success',
            'message' => 'Logged out',
            'code' => 200
        ];
    }
}
