<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyRequest;
use App\Http\Requests\DestroyProductInCartRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\StoreProductToCartRequest;
use App\Http\Requests\UpdateProductInCartRequest;
use App\Http\Resources\CartProductResource;
use App\Models\Cart;
use App\Services\CartProductService;
use App\Services\OrderService;
use App\Services\OrderStatusService;
use App\Services\PaymentMethodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CartController extends Controller
{
    /**
     * @param OrderStatusService $orderStatusService
     * @param OrderService       $orderService
     * @param CartProductService $cartProductService
     */
    public function __construct(
        protected OrderStatusService   $orderStatusService,
        protected OrderService         $orderService,
        protected CartProductService   $cartProductService,
        protected PaymentMethodService $paymentMethodService
    ) {}

    /**
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $cart = $this->getCart();

        $products = $cart->products();

        return $this->response(
            $this->toPaginateCollection(
                $products->paginate(perPage:$request['limit'], page:$request['page']),
                CartProductResource::class
            ),
        );
    }

    /**
     * @return Cart
     */
    private function getCart(): Cart
    {
        $user = auth()->user();

        return optional($user)['cart'];
    }

    /**
     * @param StoreProductToCartRequest $request
     * @return JsonResponse
     */
    public function addToCart(StoreProductToCartRequest $request): JsonResponse
    {
        $cart = $this->getCart();
        $cartProduct = $this->cartProductService->getByCartAndProductId($cart['id'], $request['product_id']);

        if (is_null($cartProduct)) {
            $this->cartProductService->create([
                'product_id' => $request['product_id'],
                'cart_id' => $cart['id'],
                'quantity' => $request['quantity'],
            ]);
        } else {
            $this->cartProductService->update($cartProduct['id'], [
                'quantity' => $cartProduct['quantity'] + $request['quantity'],
            ]);
        }

        return $this->response(message:'Product added to cart successfully.');
    }

    /**
     * @param UpdateProductInCartRequest $request
     * @return JsonResponse
     */
    public function updateInCart(UpdateProductInCartRequest $request): JsonResponse
    {
        $cart = $this->getCart();
        $cartProduct = $this->cartProductService->getByCartAndProductId($cart['id'], $request['product_id']);

        if (is_null($cartProduct)) {
            return $this->response(
                success:false,
                status:404,
                message:'Product not found in the cart.'
            );
        }

        if ($request['quantity'] === 0) {
            $this->cartProductService->destroyById($cartProduct['id']);

            return $this->response(message:'Product was removed successfully.');
        }

        $this->cartProductService->update($cartProduct['id'], [
            'quantity' => $request['quantity'],
        ]);

        return $this->response(message:'Product was updated successfully.');
    }

    /**
     * @param DestroyProductInCartRequest $request
     * @return JsonResponse
     */
    public function removeFromCart(DestroyProductInCartRequest $request): JsonResponse
    {
        $cart = $this->getCart();
        $cartProduct = $this->cartProductService->getByCartAndProductId($cart['id'], $request['product_id']);

        if (is_null($cartProduct)) {
            return $this->response(
                success:false,
                status:404,
                message:'Product not found in the cart.'
            );
        }

        $this->cartProductService->destroyById($cartProduct['id']);

        return $this->response(message:'Product was removed successfully.');
    }

    /**
     * @param BuyRequest $request
     * @return JsonResponse
     */
    public function pay(BuyRequest $request): JsonResponse
    {
        $user = auth()->user();
        $cart = $user['cart'];

        if (!$cart || $cart['products']->isEmpty()) {
            return $this->response(
                success:false,
                status:400,
                message:'Cart is empty.'
            );
        }

        $paymentMethod = $request->input('payment_method_id') ?? $request->input('payment_method_alias');

        $paymentMethod = is_numeric($paymentMethod) ? $this->paymentMethodService->firstById($paymentMethod) : $this->paymentMethodService->firstByAlias($paymentMethod);

        $userId = $user['id'];

        $expiration = Carbon::now()->addMinutes(2);

        $orderStatus = $this->orderStatusService->firstByAlias('NA_OPLATU');

        $order = $this->orderService->create([
            'user_id' => $userId,
            'order_status_id' => $orderStatus['id'],
            'data' => $cart['products'],
            'payment_method_id' => $paymentMethod['id'],
        ]);

        $token = md5($userId . $order['id'] . $paymentMethod['id']);

        $paymentLink = URL::temporarySignedRoute(
            'orders.pay',
            $expiration,
            [
                'user_id' => $userId,
                'order_id' => $order['id'],
                'payment_method_id' => $paymentMethod,
                'token' => $token
            ]
        );

        $cart->delete();

        $user->cart()->create();

        return $this->response([
            'link' => $paymentLink
        ]);
    }
}
