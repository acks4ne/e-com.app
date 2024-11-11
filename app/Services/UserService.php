<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService extends AbstractService
{
    /**
     * @param UserRepositoryInterface $repository
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
