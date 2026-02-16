<?php

namespace App\Modules\Errors\Domain\Models;

use App\Core\Tenancy\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasUuids, BelongsToTenant;

    public $timestamps = false;

    protected $table = 'error_logs';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'resolved_by',
        'source',
        'level',
        'error_code',
        'exception_class',
        'message',
        'file',
        'line',
        'stack_trace',
        'http_method',
        'url',
        'route_name',
        'query_params',
        'request_payload',
        'request_headers',
        'ip_address',
        'user_agent',
        'app_module',
        'job_name',
        'correlation_id',
        'extra_data',
        'is_resolved',
        'resolved_at',
        'resolution_note',
        'created_at',
    ];

    protected $casts = [
        'query_params'      => 'array',
        'request_payload'   => 'array',
        'request_headers'   => 'array',
        'extra_data'        => 'array',
        'is_resolved'       => 'boolean',
        'resolved_at'       => 'datetime',
        'created_at'        => 'datetime',
    ];
}
