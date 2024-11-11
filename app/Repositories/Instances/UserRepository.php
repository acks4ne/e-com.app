<?php

namespace App\Repositories\Instances;

use App\Models\User;
use App\Repositories\AbstractRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as RepositoryInterface;

class UserRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @param User $model
     * @return void
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
