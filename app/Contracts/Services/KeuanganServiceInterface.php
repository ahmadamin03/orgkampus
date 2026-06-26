<?php

namespace App\Contracts\Services;

use App\Models\Keuangan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface KeuanganServiceInterface
{
    public function list(int $perPage = 20): array;

    public function create(array $data): Keuangan;

    public function getById(int $id): ?Keuangan;

    public function update(int $id, array $data): ?Keuangan;

    public function delete(int $id): bool;
}
