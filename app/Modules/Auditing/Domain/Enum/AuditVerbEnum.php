<?php

namespace App\Modules\Auditing\Domain\Enum;

enum AuditVerbEnum: string
{
    case CREATED = 'CREATED';
    case UPDATED = 'UPDATED';
    case DELETED = 'DELETED';

    case REGISTERED = 'REGISTERED';
    case LOGIN = 'LOGIN';
    case LOGOUT = 'LOGOUT';

    case STATUS_CHANGED = 'STATUS_CHANGED';
}
