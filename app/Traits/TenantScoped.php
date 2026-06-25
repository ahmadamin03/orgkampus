<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            $orgId = TenantContext::getOrganizationId();
            if ($orgId) {
                $builder->where('organization_id', $orgId);
            }
        });

        static::creating(function ($model) {
            $orgId = TenantContext::getOrganizationId();
            if ($orgId && empty($model->organization_id)) {
                $model->organization_id = $orgId;
            }
        });
    }
}
