<?php

namespace App\Core\Tenancy\Http\Middleware;

use App\Core\Tenancy\Exceptions\TenantNotResolvedException;
use App\Core\Tenancy\TenantResolver;
use Closure;
use Illuminate\Http\Request;

class InitializeTenancy
{
    public function __construct(
        private readonly TenantResolver $resolver,
    ) {}

    /**
     * Use:
     * - tenant:true  (default) -> exige tenant
     * - tenant:false -> não exige (ex: rota pública de register)
    */
    public function handle(Request $request, Closure $next, string $required = 'true')
    {
        $tenant = $this->resolver->initialize($request);

        $isRequired = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        if($isRequired && !$tenant) {
            throw TenantNotResolvedException::generic();
        }

        return $next($request);
    }
}
