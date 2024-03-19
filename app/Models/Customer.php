<?php

namespace App\Models;

use App\Supports\AmountValue;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @method static firstOrCreate(array $array, mixed $data)
 * @method static findOrFail(mixed $validated)
 * @property AmountValue $balance
 * @property Cart $cart
 */
class Customer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name', 'email', 'balance'
    ];

    protected $casts = [
        'balance' => AmountValue::class,
    ];

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
