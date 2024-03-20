<?php

namespace App\Supports;

use Illuminate\Contracts\Database\Eloquent\Castable;

final class AmountValue implements Castable
{
    public function __construct(
        public readonly string $value
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

    public function add(string $amount): self
    {
        return new self(bcadd($this->value, $amount));
    }

    public function sub(string $amount): self
    {
        return new self(bcsub($this->value, $amount));
    }

    /* todo eq, gt, gte etc methods */

    public static function castUsing(array $arguments): string
    {
        return AmountCast::class;
    }

    public function __toString()
    {
        return $this->value();
    }
}
