<?php

namespace App\Supports;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AmountCast implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): AmountValue
    {
        return new AmountValue($value);
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($value instanceof AmountValue) {
            return $value->value();
        }

        throw new \InvalidArgumentException(
            'Value must be instance of AmountValue'
        );
    }
}
