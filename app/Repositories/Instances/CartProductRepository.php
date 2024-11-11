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
}
