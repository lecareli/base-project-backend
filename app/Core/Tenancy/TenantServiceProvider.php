<?php

namespace App\Core\Tenancy;

use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CurrentTenant::class, fn () => new CurrentTenant());
        $this->app->singleton(TenantResolver::class, fn ($app) => new TenantResolver(
            $app->make(CurrentTenant::class),
        ));

        //alias
        $this->app->alias(CurrentTenant::class, CurrencyTenant::class);
    }

    public function boot(): void
    {

    }
}
