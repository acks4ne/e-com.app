<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\OrderService;
use App\Services\OrderStatusService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Queue\Queueable;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Throwable;

class CancelUnpaidOrder implements ShouldQueue
{
    use Queueable;

    /**
     * @var OrderService|Application|mixed
     */
    protected OrderService $orderService;
    /**
     * @var OrderStatusService|Application|mixed
     */
    protected OrderStatusService $orderStatusService;

    /**
     * @param Order $order
     */
    public function __construct(protected Order $order)
    {
        $this->orderService = app(OrderService::class);
        $this->orderStatusService = app(OrderStatusService::class);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        $order = $this->orderService->firstById($this->order['id']);

        $pendingStatusId = $this->checkIfStatusExists('NA_OPLATU')['id'];
        if ($order && $order['order_status_id'] === $pendingStatusId) {
            $canceledStatusId = $this->checkIfStatusExists('OTMENEN')['id'];
            $order->update(['order_status_id' => $canceledStatusId]);
        }
    }

    /**
     * @param string $alias
     * @return OrderStatus
     * @throws Throwable
     */
    private function checkIfStatusExists(string $alias): OrderStatus
    {
        $orderStatus = $this->orderStatusService->firstByAlias($alias);

        throw_if(is_null($orderStatus), new InternalErrorException('OrderStatus is not defined.'));

        return $orderStatus;
    }
}
