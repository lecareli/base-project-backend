<?php

namespace App\Modules\Addresses\Domain\Enum;

enum AddressTypeEnum: string
{
    /**
     * Faturamento – onde saem notas / dados fiscais
    */
    case BILLING = 'BILLING';

    /**
     * Entrega – endereço de entrega de mercadorias
    */
    case SHIPPING = 'SHIPPING';

    /**
     * Cobrança – boletos, correspondências financeiras
    */
    case INVOICING = 'INVOICING';

    /**
     * Retirada em loja / balcão / ponto de coleta
    */
    case PICKUP = 'PICKUP';

    /**
     * Depósito / armazém / centro de distribuição
    */
    case WAREHOUSE = 'WAREHOUSE';

    /**
     * Endereço para comunicações jurídicas
    */
    case LEGAL = 'LEGAL';

    /**
     * Qualquer tipo que não se encaixe nos outros
    */
    case OTHER = 'OTHER';
}
