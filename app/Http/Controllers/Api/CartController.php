<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Services\OrderService;
use App\Services\OrderStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    public function __construct(
        protected OrderStatusService $orderStatusService,
        protected OrderService       $orderService
    ) {}

    public function index()
    {
        return auth()->user()->cart()->products;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        return $this->response();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateInCart(Request $request): JsonResponse
    {
        return $this->response();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function removeFromCart(Request $request): JsonResponse
    {
        return $this->response();
    }

    /**
     * @param BuyRequest $request
     * @return JsonResponse
     */
    public function buy(BuyRequest $request): JsonResponse
    {
        $user = auth()->user();
        $cart = $user['cart'];

        if (!$cart || $cart['products']->isEmpty()) {
            return $this->response(status:400, message:'Cart is empty.');
        }

        $paymentMethod = $request->input('payment_method_id') ?? $request->input('payment_method_alias');

        $paymentMethod = is_numeric($paymentMethod) ? $this->orderStatusService->firstById($paymentMethod) : $this->orderStatusService->firstByAlias($paymentMethod);

        $userId = $user['id'];

        $expiration = Carbon::now()->addMinutes(2);

        $order = $this->orderService->create([
            'user_id' => $userId,
            'order_status_id' => $paymentMethod,
            'data' => $cart->products,
            'payment_method_id' => $paymentMethod['id'],
        ]);

        $token = Hash::make($userId . $order['id'] . $expiration . $paymentMethod['id']);

        $paymentLink = URL::temporarySignedRoute(
            'orders.pay',
            $expiration,
            ['order_id' => $order['id'], 'payment_method_id' => $paymentMethod, 'token' => $token]
        );

        $cart->delete();

        $user->cart()->create();

        return $this->response([
            'link' => $paymentLink
        ]);
    }
}
