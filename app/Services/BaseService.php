<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected Model $model;

    public function create(array $data): Model
    {
        return $this->model->query()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->query()->update($data);
        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function find(int $id): ?Model
    {
        return $this->model->query()->find($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
