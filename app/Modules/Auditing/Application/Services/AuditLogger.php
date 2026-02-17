<?php

namespace App\Modules\Auditing\Application\Services;

use App\Core\Support\CorrelationId;
use App\Core\Tenancy\CurrentTenant;
use App\Modules\Auditing\Application\DTO\AuditLogDTO;
use App\Modules\Auditing\Domain\Models\AuditLog;
use RuntimeException;

class AuditLogger
{
    public function __construct(
        private readonly CurrentTenant $currentTenant,
        private readonly CorrelationId $correlationId,
    ) {}

    public function log(AuditLogDTO $dto): AuditLog
    {
        $data = $dto->toFillable();

        $data['tenant_id'] ??= $this->currentTenant->id();
        if (!$data['tenant_id']) {
            throw new RuntimeException('Tenant não resolvido para auditoria.');
        }

        $data['user_id'] ??= auth()->id();
        $data['ip_address'] ??= request()?->ip();
        $data['user_agent'] ??= request()?->userAgent();
        $data['correlation_id'] ??= $this->correlationId->get();
        $data['created_at'] ??= now();

        return AuditLog::create($data);
    }
}
