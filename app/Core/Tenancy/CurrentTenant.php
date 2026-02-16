<?php

namespace App\Core\Tenancy;

use App\Core\Tenancy\Exceptions\TenantNotResolvedException;
use App\Modules\Tenants\Domain\Models\Tenant;

class CurrentTenant
{
    private ?Tenant $tenant = null;

    public function set(?Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function get(): ?Tenant
    {
        return $this->tenant;
    }

    public function id(): ?string
    {
        return $this->tenant?->getKey();
    }

    public function clear(): void
    {
        $this->tenant = null;
    }

    public function require(): Tenant
    {
        if(!$this->tenant) {
            throw TenantNotResolvedException::generic();
        }

        return $this->tenant;
    }
}
