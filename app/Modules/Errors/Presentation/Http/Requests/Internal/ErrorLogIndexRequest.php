<?php

namespace App\Modules\Errors\Presentation\Http\Requests\Internal;

use Illuminate\Foundation\Http\FormRequest;

class ErrorLogIndexRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'q'                 => ['nullable', 'string', 'max:200'],

            'level'             => ['nullable', 'string', 'max:20'],
            'source'            => ['nullable', 'string', 'max:50'],
            'error_code'        => ['nullable', 'string', 'max:50'],
            'user_id'           => ['nullable', 'uuid'],
            'is_resolved'       => ['nullable', 'boolean'],
            'correlation_id'    => ['nullable', 'uuid'],

            'date_from'         => ['nullable', 'date'],
            'date_to'           => ['nullable', 'date'],

            'per_page'          => ['nullable', 'integer', 'min:1', 'max:200'],
            'direction'         => ['nullable', 'in:asc,desc'],
        ];
    }
}
