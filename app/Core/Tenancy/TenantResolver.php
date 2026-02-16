<?php

namespace App\Core\Tenancy;

use App\Modules\Tenants\Domain\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantResolver
{
    public function __construct(
        private readonly CurrentTenant $currentTenant
    ) {}

    public function initialize(Request $request): ?Tenant
    {
        $tenant = $this->resolve($request);
        $this->currentTenant->set($tenant);

        return $tenant;
    }

    public function resolve(Request $request): ?Tenant
    {
        //auth user
        $user = $request->user();
        if($user?->tenant_id) {
            return Tenant::query()
                ->whereKey($user->tenant_id)
                ->where('is_active', true)
                ->first();
        }

        //header
        $headerName = config('tenant.header', 'X-Tenant-ID');
        $tenantId = $request->header($headerName);
        if(is_string($tenantId) && Str::isUuid($tenantId)) {
            return Tenant::query()
                ->whereKey($user->tenant_id)
                ->where('is_active', true)
                ->first();
        }

        //TODO domain/subdomain
        return null;
    }
}
