<?php

namespace App\Http\Controllers\API;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Supports\AmountValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create(CartService $service, Request $request): OrderResource
    {
        $order = Order::query()->create([
            'uuid' => Str::uuid(),
            'customer_id' => $request->user()->id,
            'status' => OrderStatusEnum::Pending,
            'amount' => new AmountValue(
                $service->calculateTotalPrice(
                    $request->user()->cart->products
                )
            ),
        ]);

        return new OrderResource($order);
    }

    public function complete(Order $order, OrderService $service): OrderResource
    {
        $service->completeOrder($order);

        return new OrderResource($order);
    }

    public function cancel(Order $order, OrderService $service): OrderResource
    {
        $service->cancelOrder($order);

        return new OrderResource($order);
    }
}
