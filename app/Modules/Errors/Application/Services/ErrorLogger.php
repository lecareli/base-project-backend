<?php

namespace App\Modules\Errors\Application\Services;

use App\Core\Support\CorrelationId;
use App\Core\Tenancy\CurrentTenant;
use App\Modules\Errors\Application\DTO\ErrorLogDTO;
use App\Modules\Errors\Domain\Enum\ErrorLevelEnum;
use App\Modules\Errors\Domain\Enum\ErrorSourceEnum;
use App\Modules\Errors\Domain\Models\ErrorLog;
use Illuminate\Support\Arr;
use Throwable;

class ErrorLogger
{
    public function __construct(
        private readonly CurrentTenant $currentTenant,
        private readonly CorrelationId $correlationId,
    ) {}

    public function log(ErrorLogDTO $dto): ErrorLog
    {
        $data = $dto->toFillable();

        $data['tenant_id'] ??= $this->currentTenant->id();
        $data['user_id'] ??= auth()->id();

        $req = request();
        $data['http_method'] ??= $req?->getMethod();
        $data['url'] ??= $req?->fullUrl();
        $data['route_name'] ??= $req?->route()?->getName();

        // evita salvar coisas gigantescas sem necessidade
        $data['query_params'] ??= $req?->query();
        $data['request_payload'] ??= $this->safeRequestPayload();
        $data['request_headers'] ??= $this->safeRequestHeaders();

        $data['ip_address'] ??= $req?->ip();
        $data['user_agent'] ??= $req?->userAgent();

        $data['correlation_id'] ??= $this->correlationId->get();
        $data['created_at'] ??= now();

        // garante defaults de resolução
        $data['is_resolved'] ??= false;

        return ErrorLog::create($data);
    }

    public function logThrowable(
        Throwable $e,
        ErrorSourceEnum|string $source = ErrorSourceEnum::API_INTERNAL,
        ErrorLevelEnum|string $level = ErrorLevelEnum::ERROR,
        ?string $errorCode = null,
        ?string $appModule = null,
        ?string $jobName = null,
        ?array $extraData = null,
    ): ErrorLog {
        return $this->log(
            ErrorLogDTO::fromThrowable(
                e: $e,
                source: $source,
                level: $level,
                errorCode: $errorCode,
                appModule: $appModule,
                jobName: $jobName,
                extraData: $extraData,
            )
        );
    }

    private function safeRequestPayload(): ?array
    {
        $req = request();
        if (!$req) return null;

        // NÃO logar senha/token por segurança
        $all = $req->all();
        $sanitized = Arr::except($all, [
            'password',
            'password_confirmation',
            'current_password',
            'token',
            'access_token',
            'refresh_token',
        ]);

        return $sanitized;
    }

    private function safeRequestHeaders(): ?array
    {
        $req = request();
        if (!$req) return null;

        $headers = $req->headers->all();

        // Não logar Authorization/Cookie
        unset($headers['authorization'], $headers['cookie']);

        return $headers;
    }
}
