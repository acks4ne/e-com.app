<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Repositories\Interfaces\PaymentMethodRepositoryInterface;

/**
 * @method null|PaymentMethod firstByAlias(string $alias)
 */
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
