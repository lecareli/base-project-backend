<?php

namespace App\Core\Tenancy\Concerns;

use App\Core\Tenancy\CurrentTenant;
use App\Modules\Tenants\Domain\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    protected bool $applyTenantScope = true;

    protected static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model) {
            if(empty($model->getAttribute('tenant_id'))) {
                $tenantId = app(CurrentTenant::class)->id();
            }

            if($tenantId) {
                $model->setAttribute('tenant_id', $tenantId);
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $model = $builder->getModel();

            // Permite desligar por model (casos raros)
            if(property_exists($model, 'applyTenantScope') && $model->applyTenantScope === false) {
                return;
            }

            $tenantId = app(CurrentTenant::class)->id();

            // Se não tiver tenant resolvido, não filtra (ex.: rotas públicas)
            if (!$tenantId) {
                return;
            }

            $builder->where($model->getTable() . '.tenant_id', $tenantId);
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function scopeForTenant(Builder $query, string $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')
            ->where($this->getTable() . '.tenant_id', $tenantId);
    }
}
