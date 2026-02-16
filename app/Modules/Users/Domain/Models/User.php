<?php

namespace App\Modules\Users\Domain\Models;

use App\Core\Tenancy\Concerns\BelongsToTenant;
use App\Modules\Addresses\Domain\Models\Address;
use App\Modules\Tenants\Domain\Enum\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasUuids, SoftDeletes, BelongsToTenant;

    protected $table = 'users';

    protected $fillable = [
        'tenant_id',
        'is_active',
        'name',
        'email',
        'phone',
        'document_type',
        'document_number',
        'role',
        'password',
        'email_verified_at'
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'document_type'     => DocumentTypeEnum::class,
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    //relationships
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
