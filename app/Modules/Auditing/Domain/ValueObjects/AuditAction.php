<?php

namespace App\Modules\Auditing\Domain\ValueObjects;

use App\Modules\Auditing\Domain\Enum\AuditEntityEnum;
use App\Modules\Auditing\Domain\Enum\AuditVerbEnum;

final class AuditAction
{
    public static function make(AuditEntityEnum $entity, AuditVerbEnum $verb): string
    {
        return $entity->value . '.' . $verb->value;
    }
}
