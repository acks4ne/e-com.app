<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderStatusRepositoryInterface;

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
