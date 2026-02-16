<?php

namespace App\Modules\Tenants\Domain\Enum;

enum DocumentTypeEnum: string
{
    case CNPJ = 'CNPJ';

    case CPF = 'CPF';
}
