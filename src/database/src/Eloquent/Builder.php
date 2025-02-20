<?php

declare(strict_types=1);

/**
 * This file is part of the Max package.
 *
 * (c) Cheng Yao <987861463@qq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Max\Database\Eloquent;

use Max\Database\Collection;
use Max\Database\Exceptions\ModelNotFoundException;
use Max\Database\Query\Builder as QueryBuilder;
use PDO;
use Throwable;

class Builder extends QueryBuilder
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var string
     */
    protected string $class;

    /**
     * @param Model $model
     *
     * @return $this
     */
    public function setModel(Model $model): static
    {
        $this->model = $model;
        $this->class = $model::class;
        $this->from  = [$model->getTable(), ''];

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        return Collection::make(
            $this->query->statement($this->toSql($columns), $this->bindings)->fetchAll(PDO::FETCH_CLASS, $this->class)
        );
    }

    /**
     * @param array $columns
     *
     * @return Model|null
     */
    public function first(array $columns = ['*']): ?Model
    {
        try {
            return $this->firstOrFail($columns);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param array $columns
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function firstOrFail(array $columns = ['*']): Model
    {
        return $this->query->statement(
            $this->limit(1)->toSql($columns), $this->bindings
        )->fetchObject($this->class) ?: throw new ModelNotFoundException('No data was found.');
    }

    /**
     * @param             $id
     * @param array       $columns
     * @param string|null $identifier
     *
     * @return Model|null
     */
    public function find($id, array $columns = ['*'], ?string $identifier = null): ?Model
    {
        return $this->where($identifier ?? $this->model->getKey(), $id)->first($columns);
    }

    /**
     * @param        $id
     * @param array  $columns
     * @param string $identifier
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*'], string $identifier = 'id'): Model
    {
        return $this->where($this->model->getKey(), $id)->firstOrFail($columns);
    }
}
