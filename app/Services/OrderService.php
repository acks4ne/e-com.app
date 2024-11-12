<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method LengthAwarePaginator getOrdersHistoryWithFilters(int $userId, array $filters)
 */
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
