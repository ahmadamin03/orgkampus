<?php

namespace App\Contracts\Services;

use App\Models\Organization;

interface OrganizationServiceInterface
{
    public function create(array $data): Organization;

    public function getById(int $id): ?Organization;

    public function getBySlug(string $slug): ?Organization;
}
