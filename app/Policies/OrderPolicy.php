<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * @param User  $user
     * @param Order $order
     * @return bool
     */
    public function view(User $user, Order $order): bool
    {
        return $user['id'] === $order['user_id'];
    }
}
