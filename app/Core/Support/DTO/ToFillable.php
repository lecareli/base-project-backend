<?php

namespace App\Core\Support\DTO;

use Illuminate\Support\Str;
use UnitEnum;

trait ToFillable
{
    public function toFillable(): array
    {
        $vars = get_object_vars($this);

        $out = [];
        foreach ($vars as $key => $value) {
            // Enum -> value
            if ($value instanceof UnitEnum) {
                $value = $value->value;
            }

            $out[Str::snake($key)] = $value;
        }

        // remove apenas null (mantém false/0/'')
        return array_filter($out, fn ($v) => $v !== null);
    }
}
