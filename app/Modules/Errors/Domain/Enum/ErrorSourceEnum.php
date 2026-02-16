<?php

namespace App\Modules\Errors\Domain\Enum;

enum ErrorSourceEnum: string
{
    case API_INTERNAL = 'API_INTERNAL';
    case API_EXTERNAL = 'API_EXTERNAL';
    case MOBILE = 'MOBILE';
    case JOB = 'JOB';
    case INTEGRATION = 'INTEGRATION';
    case SYSTEM = 'SYSTEM';
}
