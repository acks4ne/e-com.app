<?php

namespace App\Observers;

use App\Jobs\CancelUnpaidOrder;
use App\Models\Order;

class OrderObserver
{
    /**
     * @param Order $order
     * @return void
     */
    public function created(Order $order): void
    {
        dispatch(new CancelUnpaidOrder($order))->delay(now()->addMinutes(2));
    }
}
