<?php

namespace App\Services;

use App\Contracts\Services\OrganizationServiceInterface;
use App\Models\Organization;

class OrganizationService implements OrganizationServiceInterface
{
    public function create(array $data): Organization
    {
        return Organization::create($data);
    }

    public function getById(int $id): ?Organization
    {
        return Organization::find($id);
    }

    public function getBySlug(string $slug): ?Organization
    {
        return Organization::where('slug', $slug)->first();
    }
}
