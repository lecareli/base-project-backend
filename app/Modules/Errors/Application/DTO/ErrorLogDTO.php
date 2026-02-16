<?php

namespace App\Modules\Errors\Application\DTO;

use App\Core\Support\DTO\ToFillable;
use App\Modules\Errors\Domain\Enum\ErrorLevelEnum;
use App\Modules\Errors\Domain\Enum\ErrorSourceEnum;
use Throwable;

class ErrorLogDTO
{
    use ToFillable;
    public function __construct(
        public readonly ErrorSourceEnum|string $source,
        public readonly ErrorLevelEnum|string $level,

        public readonly ?string $errorCode = null,
        public readonly ?string $exceptionClass = null,
        public readonly string $message = '',

        public readonly ?string $file = null,
        public readonly ?int $line = null,
        public readonly ?string $stackTrace = null,

        public readonly ?string $httpMethod = null,
        public readonly ?string $url = null,
        public readonly ?string $routeName = null,

        public readonly ?array $queryParams = null,
        public readonly ?array $requestPayload = null,
        public readonly ?array $requestHeaders = null,

        public readonly ?string $ipAddress = null,
        public readonly ?string $userAgent = null,

        public readonly ?string $appModule = null,
        public readonly ?string $jobName = null,

        public readonly ?string $correlationId = null,
        public readonly ?array $extraData = null,

        public readonly ?string $tenantId = null,
        public readonly ?string $userId = null,

        public readonly ?bool $isResolved = null,
        public readonly ?string $resolvedAt = null,
        public readonly ?string $resolvedBy = null,
        public readonly ?string $resolutionNote = null,

        public readonly mixed $createdAt = null,
    ) {}

    public static function fromThrowable(
        Throwable $e,
        ErrorSourceEnum|string $source = ErrorSourceEnum::API_INTERNAL,
        ErrorLevelEnum|string $level = ErrorLevelEnum::ERROR,
        ?string $errorCode = null,
        ?string $appModule = null,
        ?string $jobName = null,
        ?array $extraData = null,
    ): self {
        $code = $errorCode ?? (string)($e->getCode() ?: '');

        return new self(
            source: $source,
            level: $level,
            errorCode: $code !== '' ? $code : null,
            exceptionClass: $e::class,
            message: $e->getMessage(),
            file: $e->getFile(),
            line: $e->getLine(),
            stackTrace: $e->getTraceAsString(),
            appModule: $appModule,
            jobName: $jobName,
            extraData: $extraData,
        );
    }
}
