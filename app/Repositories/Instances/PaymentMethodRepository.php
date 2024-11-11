<?php

namespace App\Repositories\Instances;

use App\Models\PaymentMethod;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\PaymentMethodRepositoryInterface as RepositoryInterface;

class PaymentMethodRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param PaymentMethod $model
     * @return void
     */
    public function __construct(PaymentMethod $model)
    {
        parent::__construct($model);
    }
}
