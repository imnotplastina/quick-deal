<?php

namespace App\Http\Resources\Order;

use App\Enums\OrderStatusEnum;
use App\Http\Resources\Product\ProductResource;
use App\Supports\AmountValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Collection\Collection;

/**
 * @property string $uuid
 * @property int $customer_id
 * @property OrderStatusEnum $status
 * @property AmountValue $amount
 * @property Collection $products
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
            'amount' => $this->amount->value(),
            'products' => ProductResource::collection($this->products),
        ];
    }
}
