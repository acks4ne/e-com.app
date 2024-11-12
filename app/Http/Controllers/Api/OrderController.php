<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use App\Services\OrderStatusService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService       $orderService,
        protected OrderStatusService $orderStatusService,
    ) {}

    /**
     * @param OrderFilterRequest $request
     * @return JsonResponse
     */
    public function index(OrderFilterRequest $request): JsonResponse
    {
        return $this->response(
            $this->toPaginateCollection(
                $this->orderService->getOrdersHistoryWithFilters(auth()->user()['id'], $request->validated()),
                OrderResource::class
            ),
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->firstById($id);

        throw_if(is_null($order), new NotFoundHttpException('Order is not found.'));

        return $this->response($order);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function submit(int $id): JsonResponse
    {
        $order = $this->orderService->firstById($id);

        $orderStatusId = $this->orderStatusService->firstByAlias('OPLACEN')?->id;

        throw_if(is_null($orderStatusId), new InternalErrorException('OrderStatus is not defined.', 500));

        $order->update([
            'order_status_id' => $orderStatusId
        ]);

        return $this->response(message:'Order is successfully paid.');
    }
}
