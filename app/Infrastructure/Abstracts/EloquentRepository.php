<?php

namespace App\Infrastructure\Abstracts;

use App\Infrastructure\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

abstract class EloquentRepository implements BaseRepository
{
    protected Model $model;

    protected bool $withoutGlobalScopes = false;

    protected array $with = [];

    public function __constructor(Model $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function with(array $with = []): BaseRepository
    {
        $this->with = $with;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutGlobalScope(): BaseRepository
    {
        $this->withoutGlobalScopes = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(Model $model, array $data): Model
    {
        return tap($model)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function findByFilters(): LengthAwarePaginator
    {
        return $this->model->with($this->with)->paginate();
    }

    public function findOneById(string $id): Model
    {
        if (! Uuid::isValid($id)) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        if (! empty($this->with) || auth()->check()) {
            return $this->findOneBy(['id' => $id]);
        }

        $cacheKey = sprintf('%s:%s', $this->model->getTable(), $id);

        return Cache::remember($cacheKey, now()->addHour(), fn () => $this->findOneBy(['id' => $id]));
    }

    public function findOneBy(array $criteria): Model
    {
        if (! $this->withoutGlobalScopes) {
            return $this->model->with($this->with)->where($criteria)->orderByDesc('created_at')->firstOrFail();
        }

        return $this->model
            ->with($this->with)
            ->withoutGlobalScopes()
            ->where($criteria)
            ->orderByDesc('created_at')
            ->firstOrFail();
    }
}
