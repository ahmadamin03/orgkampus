<?php

namespace App\Contracts\Services;

use App\Models\Proker;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProkerServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator;

    public function create(array $data): Proker;

    public function getById(int $id): ?Proker;

    public function update(int $id, array $data): ?Proker;

    public function delete(int $id): bool;
}
