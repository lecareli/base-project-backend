<?php

namespace App\Modules\Auditing\Application\Services;

use App\Core\Support\CorrelationId;
use App\Core\Tenancy\CurrentTenant;
use App\Modules\Auditing\Application\DTO\AuditLogDTO;
use App\Modules\Auditing\Domain\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class AuditLogger
{
    public function __construct(
        private readonly CurrentTenant $currentTenant,
        private readonly CorrelationId $correlationId,
    ) {}

    public function log(AuditLogDTO $dto): AuditLog
    {
        $tenantId = $dto->tenantId ?? $this->currentTenant->id();
        if(!$tenantId) {
            throw new RuntimeException('Tenant não resolvido para auditoria.');
        }

        return AuditLog::create([
            'tenant_id'      => $tenantId,
            'user_id'        => $dto->userId ?? auth()->id(),
            'action'         => $dto->action,
            'auditable_type' => $dto->auditableType,
            'auditable_id'   => $dto->auditableId,
            'description'    => $dto->description,
            'before_data'    => $dto->before,
            'after_data'     => $dto->after,
            'ip_address'     => $dto->ipAddress ?? request()?->ip(),
            'user_agent'     => $dto->userAgent ?? request()?->userAgent(),
            'correlation_id' => $dto->correlationId ?? $this->correlationId->get(),
            'created_at'     => now(),
        ]);
    }

    public function logForModel(
        string $action,
        Model $model,
        ?string $description = null,
        ?array $before = null,
        ?array $after = null,
        ?string $userId = null
    ): AuditLog
    {
        return $this->log(new AuditLogDTO(
            $action,
            $model::class,
            (string) $model->getKey(),
            $description,
            $before,
            $after,
            $userId
        ));
    }
}
