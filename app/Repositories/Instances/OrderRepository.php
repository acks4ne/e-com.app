<?php

namespace App\Repositories\Instances;

use App\Models\Order;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface as RepositoryInterface;

class OrderRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param Order $model
     * @return void
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }
}
