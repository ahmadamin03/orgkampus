<?php

namespace App\Traits;

use Illuminate\Support\Facades\Context;

class TenantContext
{
    public static function setOrganizationId(?int $id): void
    {
        Context::add('organization_id', $id);
    }

    public static function getOrganizationId(): ?int
    {
        return Context::get('organization_id');
    }

    public static function clear(): void
    {
        Context::add('organization_id', null);
    }
}
