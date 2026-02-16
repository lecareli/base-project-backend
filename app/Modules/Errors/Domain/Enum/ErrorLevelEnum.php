<?php

namespace App\Modules\Errors\Domain\Enum;

enum ErrorLevelEnum: string
{
    case DEBUG = 'DEBUG';
    case INFO = 'INFO';
    case WARNING = 'WARNING';
    case ERROR = 'ERROR';
    case CRITICAL = 'CRITICAL';
}
