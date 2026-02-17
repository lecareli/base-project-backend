<?php

namespace App\Modules\Auditing\Application\DTO;

use App\Core\Support\DTO\ToFillable;
use Illuminate\Database\Eloquent\Model;

class AuditLogDTO
{
    use ToFillable;

    public function __construct(
        public readonly string $action,
        public readonly string $auditableType,
        public readonly string $auditableId,
        public readonly ?string $description = null,
        public readonly ?array $beforeData = null,
        public readonly ?array $afterData = null,

        // contexto (pode vir null e o logger completa)
        public readonly ?string $tenantId = null,
        public readonly ?string $userId = null,
        public readonly ?string $ipAddress = null,
        public readonly ?string $userAgent = null,
        public readonly ?string $correlationId = null,
        public readonly ?string $createdAt = null,
    ) {}

    public static function forModel(
        string $action,
        Model $model,
        ?string $description = null,
        ?array $before = null,
        ?array $after = null,
    ): self {
        return new self(
            action: $action,
            auditableType: $model::class,
            auditableId: (string) $model->getKey(),
            description: $description,
            beforeData: $before,
            afterData: $after,
        );
    }
}
