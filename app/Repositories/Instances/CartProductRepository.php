<?php

namespace App\Repositories\Instances;

use App\Models\CartProduct;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\CartProductRepositoryInterface as RepositoryInterface;

class CartProductRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param CartProduct $model
     * @return void
     */
    public function __construct(CartProduct $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $cartId
     * @param int $productId
     * @return CartProduct|null
     */
    public function getByCartAndProductId(int $cartId, int $productId): CartProduct|null
    {
        return $this->newQuery()
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();
    }
}
