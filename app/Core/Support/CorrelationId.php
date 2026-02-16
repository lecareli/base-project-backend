<?php

namespace App\Core\Support;

use Illuminate\Support\Str;

class CorrelationId
{
    private ?string $id = null;

    public function set(?string $id): void
    {
        $this->id = $id;
    }

    public function get(): string
    {
        return $this->id ??= (string) Str::uuid();
    }
}
