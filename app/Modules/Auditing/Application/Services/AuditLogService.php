<?php

namespace App\Modules\Auditing\Application\Services;

use App\Modules\Auditing\Application\DTO\AuditLogFilterDTO;
use App\Modules\Auditing\Domain\Models\AuditLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuditLogService
{
    public function paginate(AuditLogFilterDTO $filters): LengthAwarePaginator
    {
        $query = AuditLog::query();
        $filters->apply($query);

        $direction = in_array($filters->direction, ['asc', 'desc'], true) ? $filters->direction : 'desc';

        return $query
            ->orderBy('created_at', $direction)
            ->paginate($filters->perPage);
    }

    public function findOrFail(string $id): AuditLog
    {
        return AuditLog::query()->findOrFail($id);
    }
}
