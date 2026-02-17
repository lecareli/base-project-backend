<?php

namespace App\Modules\Errors\Presentation\Http\Resources\Internal;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'tenant_id'         => $this->tenant_id,
            'user_id'           => $this->user_id,
            'resolved_by'       => $this->resolved_by,
            'source'            => $this->source,
            'level'             => $this->level,
            'error_code'        => $this->error_code,
            'exception_class'   => $this->exception_class,
            'message'           => $this->message,
            'file'              => $this->file,
            'line'              => $this->line,
            'stack_trace'       => $this->stack_trace,
            'http_method'       => $this->http_method,
            'url'               => $this->url,
            'route_name'        => $this->route_name,
            'query_params'      => $this->query_params,
            'request_payload'   => $this->request_payload,
            'request_headers'   => $this->request_headers,
            'ip_address'        => $this->ip_address,
            'user_agent'        => $this->user_agent,
            'app_module'        => $this->app_module,
            'job_name'          => $this->job_name,
            'correlation_id'    => $this->correlation_id,
            'extra_data'        => $this->extra_data,
            'is_resolved'       => $this->is_resolved,
            'resolved_at'       => $this->resolved_at,
            'resolution_note'   => $this->resolution_note,
            'created_at'        => $this->created_at,
        ];
    }
}
