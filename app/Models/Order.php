<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Supports\AmountValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property AmountValue $amount
 * @property Customer $customer
 * @property OrderStatusEnum $status
 */
class Order extends Model
{
    protected $fillable = [
        'uuid', 'customer_id',
        'amount', 'status'
    ];

    protected $casts = [
        'amount' => AmountValue::class,
        'status' => OrderStatusEnum::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
