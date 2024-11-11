<?php

namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use stdClass;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    /**
     * @var array
     */
    protected array $params = [];

    /**
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * @param int      $perPage
     * @param string[] $columns
     * @param string   $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        return $this->newQuery()->toBase()->paginate($perPage, $columns, $pageName, $page);
    }

    /**
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @param int $id
     * @return null|Model
     */
    public function firstById(int $id): ?stdClass
    {
        return $this->first($id);
    }

    /**
     * @param mixed  $value
     * @param string $column
     *
     * @return stdClass|null
     */
    public function first(mixed $value, string $column = 'id'): ?stdClass
    {
        $qb = $this->newQuery()->toBase();

        return is_array($value)
            ? $qb->where($value)->first()
            : $qb->where($column, '=', $value)->first();
    }

    /**
     * @param array  $fillable
     * @param string $orderField
     * @param string $orderType
     * @return Collection
     */
    public function where(array $fillable, string $orderField = 'id', string $orderType = 'desc'): Collection
    {
        return $this->newQuery()->where($fillable)
            ->orderBy($orderField, $orderType)
            ->get();
    }

    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->newQuery()->get();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return $this->exists($id);
    }

    /**
     * @param        $value
     * @param string $column
     * @return bool
     */
    public function exists($value, string $column = 'id'): bool
    {
        $qb = $this->newQuery()->toBase();

        return is_array($value)
            ? $qb->where($value)->exists()
            : $qb->where($column, '=', $value)->exists();
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return Builder|Model
     */
    public function firstOrCreate(array $attributes = [], array $values = []): Model|Builder
    {
        return $this->newQuery()->firstOrCreate($attributes, $values);
    }

    /**
     * @param int|array $id
     * @return bool
     */
    public function destroyById(int|array $id): bool
    {
        return $this->getModel()::destroy($id);
    }

    /**
     * @return Model
     */
    public function getModel(): string
    {
        return $this->model::class;
    }

    /**
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->newQuery()->find($id)->update($data);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return bool
     */
    public function updateOrCreate(array $attributes, array $values = []): bool
    {
        return $this->newQuery()->updateOrCreate($attributes, $values);
    }

    /**
     * @param $array
     * @return mixed
     */
    public function factory($array): Factory
    {
        return $this->getModel()::factory();
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function createOrNull(array $data): Model|null
    {
        try {
            $entity = $this->getModel()::query()->create($data);
        } catch (Exception $e) {
            return null;
        }

        return $entity;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->getModel()::create($data);
    }
}
