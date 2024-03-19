<?php

namespace App\Supports;

use Illuminate\Contracts\Database\Eloquent\Castable;

final class AmountValue implements Castable
{
    public function __construct(
        private readonly string $value
    ) {
        if (! is_numeric($value)) {
            throw new \InvalidArgumentException(
                'Invalid amount value: ' . $this->value
            );
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function castUsing(array $arguments): string
    {
        return AmountCast::class;
    }

    public function __toString()
    {
        return $this->value();
    }
}
