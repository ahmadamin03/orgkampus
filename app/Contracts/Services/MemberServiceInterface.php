<?php

namespace App\Contracts\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MemberServiceInterface
{
    public function list(int $organizationId, int $perPage = 20): LengthAwarePaginator;

    public function create(array $data): User;

    public function getById(int $id, int $organizationId): ?User;

    public function update(int $id, array $data, int $organizationId): ?User;

    public function delete(int $id, int $organizationId): bool;
}
