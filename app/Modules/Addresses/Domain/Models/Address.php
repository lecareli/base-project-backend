<?php

namespace App\Modules\Addresses\Domain\Models;

use App\Core\Tenancy\Concerns\BelongsToTenant;
use App\Modules\Addresses\Domain\Enum\AddressTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasUuids, SoftDeletes, BelongsToTenant;

    protected $table = 'addresses';

    protected $fillable = [
        'tenant_id',
        'type',
        'is_primary',
        'zip',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'country',
        'ibge_code'
    ];

    protected $casts = [
        'type'          => AddressTypeEnum::class,
        'is_primary'    => 'boolean'
    ];

    //relationships
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
