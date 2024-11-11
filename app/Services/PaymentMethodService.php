<?php

namespace App\Services;

use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;

class PaymentMethodService extends AbstractService
{
    /**
     * @param PaymentMethodRepositoryInterface $repository
     * @return void
     */
    public function __construct(PaymentMethodRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
