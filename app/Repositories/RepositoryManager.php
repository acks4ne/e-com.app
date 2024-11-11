<?php

namespace App\Repositories;

class RepositoryManager
{
    /**
     * @param AbstractRepositoryInterface $repository
     */
    public function __construct(
        protected AbstractRepositoryInterface $repository,
    ) {}

    /**
     * @param string $name
     * @param array  $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        return $this->repository->{$name}(...$arguments);
    }
}
