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
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create(CartService $service, Request $request): OrderResource
    {
        $products = $request->user()->cart->products;

        /** @var Order $order */
        $order = Order::query()->create([
            'uuid' => Str::uuid(),
            'customer_id' => $request->user()->id,
            'status' => OrderStatusEnum::Pending,
            'amount' => new AmountValue(
                $service->calculateTotalPrice($products)
            ),
        ]);

        $order->products()->attach($products);

        return new OrderResource($order);
    }

    public function complete(Order $order, OrderService $service): OrderResource|Response
    {
        // Если у покупателя достаточно средств на счету, то списываем нужную сумму и завершаем заказ
        if ($order->customer->balance->gte($order->amount->value)) {
            $order = $service->completeOrder($order);
        } else {
            // Здесь должно быть сообщение о нехватке средств
            return response()->noContent();
        }

        return new OrderResource($order);
    }

    public function cancel(Order $order, OrderService $service): OrderResource
    {
        $order = $service->cancelOrder($order);

        return new OrderResource($order);
    }
}
