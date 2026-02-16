<?php

namespace App\Core\Tenancy\Exceptions;

use RuntimeException;

class TenantNotResolvedException extends RuntimeException
{
    public static function generic(): self
    {
        return new self('Tenant não identificado para esta requisição');
    }
}
