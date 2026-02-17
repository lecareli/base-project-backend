<?php

namespace App\Modules\Errors\Application\DTO;

use Illuminate\Database\Eloquent\Builder;

class ErrorLogFilterDTO
{
    public function __construct(
        public readonly ?string $q = null,
        public readonly ?string $level = null,
        public readonly ?string $source = null,
        public readonly ?string $errorCode = null,
        public readonly ?string $userId = null,
        public readonly ?bool $isResolved = null,
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
            $data['level'] ?? null,
            $data['source'] ?? null,
            $data['error_code'] ?? null,
            $data['user_id'] ?? null,
            array_key_exists('is_resolved', $data) ? (bool)$data['is_resolved'] : null,
            $data['correlation_id'] ?? null,
            $data['date_from'] ?? null,
            $data['date_to'] ?? null,
            (int) ($data['per_page'] ?? 25),
            $data['direction'] ?? 'desc',
        );
    }

    public function apply(Builder $query): Builder
    {
        if ($this->q) {
            $q = $this->q;
            $query->where(function ($w) use ($q) {
                $w->where('message', 'like', "%{$q}%")
                  ->orWhere('error_code', 'like', "%{$q}%")
                  ->orWhere('exception_class', 'like', "%{$q}%")
                  ->orWhere('correlation_id', 'like', "%{$q}%");
            });
        }

        if ($this->level) $query->where('level', $this->level);
        if ($this->source) $query->where('source', $this->source);
        if ($this->errorCode) $query->where('error_code', $this->errorCode);
        if ($this->userId) $query->where('user_id', $this->userId);
        if (!is_null($this->isResolved)) $query->where('is_resolved', $this->isResolved);
        if ($this->correlationId) $query->where('correlation_id', $this->correlationId);

        if ($this->dateFrom) $query->where('created_at', '>=', $this->dateFrom);
        if ($this->dateTo) $query->where('created_at', '<=', $this->dateTo);

        return $query;
    }
}
