<?php

namespace App\Modules\Tenants\Domain\Models;

use App\Modules\Tenants\Domain\Enum\DocumentTypeEnum;
use App\Modules\Tenants\Domain\Enum\PersonTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tenants';

    protected $fillable = [
        'is_active',
        'type', //PF/PJ
        'display_name',
        'legal_name',
        'trade_name',
        'document_type', //CNPJ/CPF
        'document_number', //somente numeros
        'email',
        'phone',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'type'          => PersonTypeEnum::class,
        'document_type' => DocumentTypeEnum::class,
    ];
}
