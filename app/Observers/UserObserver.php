<?php

namespace App\Observers;

use App\Models\User;
use App\Services\CartService;

class UserObserver
{
    public function __construct(protected CartService $cartService) {}

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $cart = $this->cartService->create([]);

        $user['cart_id'] = $cart['id'];

        $user->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
