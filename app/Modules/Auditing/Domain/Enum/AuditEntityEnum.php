<?php

namespace App\Modules\Auditing\Domain\Enum;

enum AuditEntityEnum: string
{
    case TENANT  = 'TENANT';
    case USER    = 'USER';
    case ADDRESS = 'ADDRESS';
    case PRODUCT = 'PRODUCT';
}
