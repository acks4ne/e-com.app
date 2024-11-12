<?php

namespace App\Repositories\Instances;

use App\Models\Order;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Collection\Sort;

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

    /**
     * @param int   $userId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getOrdersHistoryWithFilters(int $userId, array $filters): LengthAwarePaginator
    {
        return $this->newQuery()
            ->where('user_id', $userId)
            ->when(
                isset($filters['filter']['order_status_id']),
                fn(Builder $q) => $q->where('order_status_id', $filters['filter']['order_status_id'])
            )
            ->orderBy('created_at', $filters['order_by']['created_at'] ?? Sort::Descending->value)
            ->paginate($filters['limit'] ?? 20, page:$filters['page'] ?? 1);
    }
}
