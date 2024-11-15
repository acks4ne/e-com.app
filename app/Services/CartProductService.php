<?php

namespace App\Services;

use App\Repositories\Interfaces\CartProductRepositoryInterface;

/**
 *
 * @method getByCartAndProductId(int $cartId, int $productId): CartProduct|null
 */
class CartProductService extends AbstractService
{
    /**
     * @param CartProductRepositoryInterface $repository
     * @return void
     */
    public function __construct(CartProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
