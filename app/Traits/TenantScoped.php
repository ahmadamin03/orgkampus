<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken;

trait TenantScoped
{
    private static bool $resolvingOrgId = false;

    protected static function bootTenantScoped()
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            $orgId = TenantContext::getOrganizationId() ?? static::resolveOrgId();
            if ($orgId) {
                $builder->where('organization_id', $orgId);
            }
        });

        static::creating(function ($model) {
            $orgId = TenantContext::getOrganizationId() ?? static::resolveOrgId();
            if ($orgId && empty($model->organization_id)) {
                $model->organization_id = $orgId;
            }
        });
    }

    private static function resolveOrgId(): ?int
    {
        if (static::$resolvingOrgId) {
            return null;
        }

        static::$resolvingOrgId = true;

        try {
            $user = static::resolveSanctumUserFromRequest() ?? auth()->user();

            return $user?->organization_id;
        } finally {
            static::$resolvingOrgId = false;
        }
    }

    private static function resolveSanctumUserFromRequest(): ?object
    {
        $request = request();

        if (!$request || !$request->bearerToken()) {
            return null;
        }

        $accessToken = PersonalAccessToken::findToken($request->bearerToken());

        return $accessToken?->tokenable;
    }
}
