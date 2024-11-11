<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService extends AbstractService
{
    /**
     * @param OrderRepositoryInterface $repository
     * @return void
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
