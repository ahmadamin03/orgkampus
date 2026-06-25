<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

class TenantContext
{
    protected static ?int $organizationId = null;

    public static function setOrganizationId(?int $id): void
    {
        static::$organizationId = $id;
    }

    public static function getOrganizationId(): ?int
    {
        return static::$organizationId ?? Auth::user()?->organization_id;
    }

    public static function clear(): void
    {
        static::$organizationId = null;
    }
}
