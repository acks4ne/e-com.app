<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

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
