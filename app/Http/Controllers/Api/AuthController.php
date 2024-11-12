<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'cart_id' => 1
        ]);

        $token = $user->createToken("Personal Access Token for {$user->login}")->plainTextToken;

        return $this->response(['token' => $token]);
    }

    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid login or password provided'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken("Personal Access Token for {$user->login}")->plainTextToken;

        return $this->response(['token' => $token]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->response(['message' => 'Logged out successfully!']);
    }
}
