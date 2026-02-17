<?php

namespace App\Modules\Errors\Presentation\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Modules\Errors\Application\DTO\ErrorLogFilterDTO;
use App\Modules\Errors\Application\Services\ErrorLogService;
use App\Modules\Errors\Presentation\Http\Requests\Internal\ErrorLogIndexRequest;
use App\Modules\Errors\Presentation\Http\Resources\Internal\ErrorLogResource;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function __construct(
        private readonly ErrorLogService $service
    ) {}

    public function index(ErrorLogIndexRequest $request)
    {
        $filters = ErrorLogFilterDTO::fromArray($request->validated());
        $logs = $this->service->paginate($filters);

        return ErrorLogResource::collection($logs);
    }

    public function show(string $id)
    {
        $log = $this->service->findOrFail($id);
        return new ErrorLogResource($log);
    }

    public function resolve(string $id, Request $request)
    {
        $log = $this->service->findOrFail($id);
        $data = $request->validate([
            'resolution_note' => ['nullable', 'string', 'max:5000']
        ]);

        $updated = $this->service->resolve(
            $log,
            (string) auth()->id(),
            $data['resolution_note'] ?? null,
        );

        return new ErrorLogResource($updated);
    }
}
