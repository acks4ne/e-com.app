<?php

namespace App\Services;

use App\Models\OrderStatus;
use App\Repositories\Interfaces\OrderStatusRepositoryInterface;

/**
 * @method null|OrderStatus firstByAlias(string $alias)
 */
class OrderStatusService extends AbstractService
{
    /**
     * @param OrderStatusRepositoryInterface $repository
     * @return void
     */
    public function __construct(OrderStatusRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
