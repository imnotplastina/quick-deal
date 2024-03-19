<?php

namespace App\Models;

use App\Models\Traits\Sortable;
use App\Supports\AmountValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static sorted()
 */
class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title', 'description',
        'price', 'quantity',
    ];

    protected $casts = [
        'price' => AmountValue::class,
    ];
}
