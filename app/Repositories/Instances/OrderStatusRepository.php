<?php

namespace App\Repositories\Instances;

use App\Models\OrderStatus;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\OrderStatusRepositoryInterface as RepositoryInterface;

class OrderStatusRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param OrderStatus $model
     * @return void
     */
    public function __construct(OrderStatus $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $alias
     * @return null|OrderStatus
     */
    public function firstByAlias(string $alias): ?OrderStatus
    {
        return $this->newQuery()
            ->firstWhere('alias', $alias);
    }
}
