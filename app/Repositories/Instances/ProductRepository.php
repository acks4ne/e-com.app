<?php

namespace App\Repositories\Instances;

use App\Models\Product;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface as RepositoryInterface;

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
}
