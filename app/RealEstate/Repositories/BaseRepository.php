<?php

namespace App\RealEstate\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @return Model
     */
    public abstract function model(): Model;

    /**
     * @return Builder
     */
    public function query()
    {
        $model = $this->model();
        $builder = new QueryBuilder($model->getConnection());
        return (new Builder($builder))->setModel($model);
    }

    /**
     * @param Builder $builder
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search(Builder $builder)
    {
        return $builder->get();
    }
}