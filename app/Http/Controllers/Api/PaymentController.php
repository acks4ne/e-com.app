<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    public function __construct(
        protected CartService  $cartService,
        protected OrderService $orderService
    ) {}

    /**
     * @param Request $request
     * @param int     $orderId
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $orderId): JsonResponse
    {
        $user = auth()->user();

        $order = $this->orderService->firstById($orderId);

        if (!$order || $order['user_id'] !== $user['id']) {
            return $this->response(success:false, status:403, message:'Invalid cart.');
        }

        if (!$request->hasValidSignature() || $order['status']['alias'] === 'OTMENEN') {
            return $this->response(success:false, status:403, message:'Payment link has expired or is invalid.');
        }

        $data = $user['id'] . $orderId . $request->query('expires') . $request->query('payment_method_id');

        $token = $request->query('token');
        if (!Hash::check($data, $token)) {
            return $this->response(success:false, status:403, message:'Invalid token.');
        }

        $orderUpdateLink = URL::temporarySignedRoute(
            'orders.submit',
            now()->addMinutes(30),
            ['order_id' => $order['id']]
        );

        return $this->response([
            'link' => $orderUpdateLink,
        ]);
    }
}
