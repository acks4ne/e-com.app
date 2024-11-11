<?php

namespace App\Repositories\Instances;

use App\Models\Product;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Ramsey\Collection\Sort;

class ProductRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param Product $model
     * @return void
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getProductsWithFilters(array $filters): LengthAwarePaginator
    {
        return $this->newQuery()
            ->orderBy('price', $filters['order_by']['price'] ?? Sort::Descending->value)
            ->paginate($filters['limit'] ?? 20, page:$filters['page'] ?? 1);
    }
}
