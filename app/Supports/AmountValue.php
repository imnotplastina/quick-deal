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

    public function eq(string $amount): bool
    {
        return (bccomp($this->value, $amount) === 0);
    }

    public function gt(string $amount): bool
    {
        return (bccomp($this->value, $amount) === 1);
    }

    public function gte(string $amount): bool
    {
        return $this->eq($amount) || $this->gt($amount);
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
