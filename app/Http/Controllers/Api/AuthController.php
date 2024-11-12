<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\CartService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected CartService $cartService,
    ) {}

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create([
            'login' => $request['login'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken("Personal Access Token for {$user['login']}", ['*'],
            Carbon::now()->addHours())->plainTextToken;

        return $this->response(['token' => $token]);
    }

    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return $this->response(
                success:false,
                status:401,
                message:'Invalid login or password provided');
        }

        $user = Auth::user();

        $token = $user->createToken("Personal Access Token for {$user['login']}", ['*'],
            Carbon::now()->addHours())->plainTextToken;

        return $this->response(['token' => $token]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->response(message:'Logged out successfully!');
    }
}
