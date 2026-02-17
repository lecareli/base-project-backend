<?php

namespace App\Modules\Auditing\Presentation\Http\Requests\Internal;

use Illuminate\Foundation\Http\FormRequest;

class AuditLogIndexRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'q'                 => ['nullable', 'string', 'max:200'],
            'action'            => ['nullable', 'string', 'max:50'],
            'user_id'           => ['nullable', 'uuid'],
            'auditable_type'    => ['nullable', 'string', 'max:150'],
            'auditable_id'      => ['nullable', 'string', 'max:64'],
            'correlation_id'    => ['nullable', 'uuid'],
            'date_from'         => ['nullable', 'date'],
            'date_to'           => ['nullable', 'date'],
            'per_page'          => ['nullable', 'integer', 'min:1', 'max:200'],
            'direction'         => ['nullable', 'in:asc,desc'],
        ];
    }
}
