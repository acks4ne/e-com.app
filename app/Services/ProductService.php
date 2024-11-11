<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @method LengthAwarePaginator getProductsWithFilters(array $filters)
 */
class ProductService extends AbstractService
{
    /**
     * @param ProductRepositoryInterface $repository
     * @return void
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
