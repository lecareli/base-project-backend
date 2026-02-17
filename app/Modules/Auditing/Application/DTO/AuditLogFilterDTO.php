<?php

namespace App\Modules\Auditing\Application\DTO;

use Illuminate\Database\Eloquent\Builder;

class AuditLogFilterDTO
{
    public function __construct(
        public readonly ?string $q = null,
        public readonly ?string $action = null,
        public readonly ?string $userId = null,
        public readonly ?string $auditableType = null,
        public readonly ?string $auditableId = null,
        public readonly ?string $correlationId = null,
        public readonly ?string $dateFrom = null,
        public readonly ?string $dateTo = null,
        public readonly int $perPage = 25,
        public readonly string $direction = 'desc',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['q'] ?? null,
            $data['action'] ?? null,
            $data['user_id'] ?? null,
            $data['auditable_type'] ?? null,
            $data['auditable_id'] ?? null,
            $data['correlation_id'] ?? null,
            $data['date_from'] ?? null,
            $data['date_to'] ?? null,
            (int) ($data['per_page'] ?? 25),
            $data['direction'] ?? 'desc',
        );
    }

    public function apply(Builder $query): Builder
    {
        if($this->q) {
            $q = $this->q;
            $query->where(function ($w) use ($q) {
                $w->where('action', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('auditable_id', 'like', "%{$q}%")
                    ->orWhere('correlation_id', 'like', "%{$q}%");
            });
        }

        if($this->action) $query->where('action', $this->action);
        if ($this->userId) $query->where('user_id', $this->userId);
        if ($this->auditableType) $query->where('auditable_type', $this->auditableType);
        if ($this->auditableId) $query->where('auditable_id', $this->auditableId);
        if ($this->correlationId) $query->where('correlation_id', $this->correlationId);

        if ($this->dateFrom) $query->where('created_at', '>=', $this->dateFrom);
        if ($this->dateTo) $query->where('created_at', '<=', $this->dateTo);

        return $query;
    }
}
