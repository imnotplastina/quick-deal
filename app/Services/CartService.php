<?php

namespace App\Services;

use App\Models\Cart;
use App\Supports\AmountValue;
use Illuminate\Database\Eloquent\Collection;

final class CartService
{
    public function getRelatedCart(int $customerId): Cart
    {
        return Cart::firstOrCreate(
            ['customer_id' => $customerId], [$customerId]
        );
    }

    public function calculateTotalPrice(Collection $products): AmountValue
    {
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price->value();
        }

        return new AmountValue($totalPrice);
    }
}
