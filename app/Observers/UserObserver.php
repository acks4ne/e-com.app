<?php

namespace App\Observers;

use App\Models\User;
use App\Services\CartService;

class UserObserver
{
    public function __construct(protected CartService $cartService) {}

    /**
     * Handle the User "created" event.
     *
     * @param User $user
     */
    public function created(User $user): void
    {
        $cart = $this->cartService->create([]);

        $user['cart_id'] = $cart['id'];

        $user->save();
    }
}
