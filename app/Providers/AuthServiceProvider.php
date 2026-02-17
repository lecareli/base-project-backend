<?php

namespace App\Providers;

use App\Modules\Auditing\Domain\Models\AuditLog;
use App\Modules\Auditing\Domain\Policies\AuditLogPolicy;
use App\Modules\Errors\Domain\Models\ErrorLog;
use App\Modules\Errors\Domain\Policies\ErrorLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        AuditLog::class => AuditLogPolicy::class,
        ErrorLog::class => ErrorLogPolicy::class,
    ];

    public function boot(): void
    {
        
    }
}
