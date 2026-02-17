<?php

namespace App\Modules\Auditing\Presentation\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Modules\Auditing\Application\DTO\AuditLogFilterDTO;
use App\Modules\Auditing\Application\Services\AuditLogService;
use App\Modules\Auditing\Presentation\Http\Requests\Internal\AuditLogIndexRequest;
use App\Modules\Auditing\Presentation\Http\Resources\Internal\AuditLogResource;

class AuditLogController extends Controller
{
    public function __construct(
        private readonly AuditLogService $service
    ) {}

    public function index(AuditLogIndexRequest $request)
    {
        $filters = AuditLogFilterDTO::fromArray($request->validated());
        $logs = $this->service->paginate($filters);

        return AuditLogResource::collection($logs);
    }

    public function show(string $id)
    {
        $log = $this->service->findOrFail($id);
        return new AuditLogResource($log);
    }
}
