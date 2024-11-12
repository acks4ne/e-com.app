<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    /**
     * @param CartService  $cartService
     * @param OrderService $orderService
     */
    public function __construct(
        protected CartService  $cartService,
        protected OrderService $orderService
    ) {}

    /**
     * @param Request $request
     * @param int     $userId
     * @param int     $orderId
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $userId, int $orderId): JsonResponse
    {
        $order = $this->orderService->firstById($orderId);

        if (!$order || $order['user_id'] !== $userId) {
            return $this->response(
                success:false,
                status:403,
                message:'Invalid cart.'
            );
        }

        if (!$request->hasValidSignature() || $order['status']['alias'] === 'OTMENEN') {
            return $this->response(
                success:false,
                status:403,
                message:'Payment link has expired or is invalid.'
            );
        }

        $data = md5($userId . $orderId . (int) $request->query('payment_method_id'));

        $token = $request->query('token');

        if ($data !== $token) {
            return $this->response(
                success:false,
                status:403,
                message:'Invalid token.'
            );
        }

        $orderUpdateLink = URL::temporarySignedRoute(
            'orders.submit',
            now()->addMinutes(30),
            ['id' => $order['id']]
        );

        return $this->response([
            'link' => $orderUpdateLink,
        ]);
    }
}
