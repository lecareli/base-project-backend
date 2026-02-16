<?php

namespace App\Modules\Tenants\Domain\Models;

use App\Modules\Addresses\Domain\Models\Address;
use App\Modules\Tenants\Domain\Enum\DocumentTypeEnum;
use App\Modules\Tenants\Domain\Enum\PersonTypeEnum;
use App\Modules\Users\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    //relationships
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
