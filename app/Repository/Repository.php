<?php

namespace App\Repository;

use App\Exceptions\DbErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class Repository implements RepositoryInterface
{
    /**
     * Container
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Eloquent
     *
     * @var Eloquent
     */
    protected Eloquent $model;


    /**
     * Repository constructor.
     *
     * @throws DbErrorException
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
        $this->make();
    }


    /**
     * @throws DbErrorException
     */
    public function make(): Eloquent
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Eloquent) {
            throw new DbErrorException("The {$this->model()} class must be instance of Eloquent Model");
        }

        return $this->model = $model;
    }


    /**
     * @throws Throwable
     */
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }


    /**
     * @throws Throwable
     */
    public function rollback(): void
    {
        DB::rollBack();
    }


    /**
     * @throws Throwable
     */
    public function commit(): void
    {
        DB::commit();
    }

    /**
     *
     * @return Builder
     */
    protected function fetchRelationQuery(): Builder
    {
        $relation = $this->hasRelation();

        return $this->model ? $this->model->with($relation) : $this->model->query();
    }


    /**
     * Returns the specify model class name
     *
     * @return string
     */
    abstract protected function model(): string;

    /**
     * @return string
     */
    abstract protected function hasRelation(): string;
}
