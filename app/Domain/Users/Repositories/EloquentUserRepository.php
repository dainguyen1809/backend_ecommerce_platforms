<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Contracts\UserRepository;
use App\Infrastructure\Abstracts\EloquentRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = ['id', 'email', 'is_active', 'email_verified_at', 'created_at', 'updated_at'];

    private array $allowedFilters = ['is_active'];

    private array $allowedSorts = ['updated_at', 'created_at'];

    private array $allowedIncludes = ['notifications'];
}
