<?php

namespace App\Contracts\Services;

use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EventServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator;

    public function create(array $data): Event;

    public function getById(int $id): ?Event;

    public function update(int $id, array $data): ?Event;

    public function delete(int $id): bool;
}
