<?php

namespace App\Repositories\Instances;

use App\Models\Cart;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\CartRepositoryInterface as RepositoryInterface;

class CartRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param Cart $model
     * @return void
     */
    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }
}
