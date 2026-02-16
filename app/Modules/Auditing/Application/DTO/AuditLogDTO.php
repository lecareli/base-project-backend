<?php

namespace App\Modules\Auditing\Application\DTO;

class AuditLogDTO
{
    public function __construct(
        public readonly string $action,
        public readonly string $auditableType,
        public readonly string $auditableId,
        public readonly ?string $description = null,
        public readonly ?array $before = null,
        public readonly ?array $after = null,
        public readonly ?string $tenantId = null,
        public readonly ?string $userId = null,
        public readonly ?string $ipAddress = null,
        public readonly ?string $userAgent = null,
        public readonly ?string $correlationId = null,
    ) {}
}
