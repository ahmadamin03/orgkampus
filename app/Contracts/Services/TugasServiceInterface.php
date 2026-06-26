<?php

namespace App\Contracts\Services;

use App\Models\Tugas;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TugasServiceInterface
{
    public function list(int $perPage = 20): LengthAwarePaginator;

    public function create(array $data): Tugas;

    public function getById(int $id): ?Tugas;

    public function update(int $id, array $data): ?Tugas;

    public function delete(int $id): bool;
}
