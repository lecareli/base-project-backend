<?php

namespace App\Modules\Auditing\Presentation\Http\Resources\Internal;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'tenant_id'         => $this->tenant_id,
            'user_id'           => $this->user_id,
            'action'            => $this->action,
            'auditable_type'    => $this->auditable_type,
            'auditable_id'      => $this->auditable_id,
            'description'       => $this->description,
            'before_data'       => $this->before_data,
            'after_data'        => $this->after_data,
            'ip_address'        => $this->ip_address,
            'user_agent'        => $this->user_agent,
            'correlation_id'    => $this->correlation_id,
            'created_at'        => $this->created_at,
        ];
    }
}
