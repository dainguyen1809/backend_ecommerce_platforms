<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepository
{
    /**
     *   Set the relationship of the query
     */
    public function with(array $with = []): BaseRepository;

    /**
     * Set withoutGlobalScopes attribute to true and apply it to the query.
     */
    public function withoutGlobalScope(): BaseRepository;

    /**
     * Find a resource by id.
     *
     * @throws ModelNotFoundException
     */
    public function findOneById(string $id): Model;

    /**
     * Find a resource by key value criteria.
     *
     * @throws ModelNotFoundException
     */
    public function findOneBy(array $criteria): Model;

    /**
     * Search All resources by spatie query builder.
     */
    public function findByFilters(): LengthAwarePaginator;

    /**
     * Save a resource.
     */
    public function store(array $data): Model;

    /**
     * Update a resource.
     */
    public function update(Model $model, array $data): Model;
}
