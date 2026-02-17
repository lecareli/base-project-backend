<?php

namespace App\Modules\Errors\Application\Services;

use App\Modules\Errors\Application\DTO\ErrorLogFilterDTO;
use App\Modules\Errors\Domain\Models\ErrorLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ErrorLogService
{
    public function paginate(ErrorLogFilterDTO $filters): LengthAwarePaginator
    {
        $query = ErrorLog::query()->select([
            'id','tenant_id','user_id','resolved_by',
            'source','level','error_code','exception_class',
            'message','file','line',
            'http_method','url','route_name',
            'ip_address','user_agent',
            'app_module','job_name','correlation_id',
            'is_resolved','resolved_at','resolution_note',
            'created_at',
        ]);

        $filters->apply($query);

        $direction = in_array($filters->direction, ['asc', 'desc'], true) ? $filters->direction : 'desc';

        return $query->orderBy('created_at', $direction)->paginate($filters->perPage);
    }

    public function findOrFail(string $id): ErrorLog
    {
        return ErrorLog::query()->findOrFail($id);
    }

    public function resolve(ErrorLog $log, string $resolvedByUserId, ?string $note = null): ErrorLog
    {
        $log->update([
            'is_resolved'       => true,
            'resolved_at'       => now(),
            'resolved_by'       => $resolvedByUserId,
            'resolution_note'   => $note
        ]);

        return $log->fresh();
    }
}
