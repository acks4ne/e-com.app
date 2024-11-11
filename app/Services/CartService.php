<?php

namespace App\Services;

use App\Repositories\Interfaces\CartRepositoryInterface;

class CartService extends AbstractService
{
    /**
     * @param CartRepositoryInterface $repository
     * @return void
     */
    public function __construct(CartRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
