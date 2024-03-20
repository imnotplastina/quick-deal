<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Supports\AmountValue;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function completeOrder(Order $order)
    {
        $customer = $order->customer;

        // Если у покупателя достаточно средств на счету, то списываем нужную сумму и завершаем заказ
        if ($customer->balance >= $order->amount->value()) {
            DB::Transaction(function() use ($customer, $order) {
                $customer->update([
                    'balance' => $customer->balance->sub(
                        $order->amount->value()
                    )]);

                $order->update([
                    'status' => OrderStatusEnum::Completed,
                ]);

                // Удаляем товары из корзины, поскольку заказ завершен
                $customer->cart->products()->detach();
            });

        } else {
            // Здесь должно быть сообщение о нехватке средств на счету
            return response()->noContent();
        }
    }

    public function cancelOrder(Order $order): void
    {
        // Если товар уже оплачен, то возвращаем средства обратно
        if ($order->status->isCompleted()) {
            DB::Transaction(function () use ($order) {
                $order->customer->update([
                    'balance' => $order->customer->balance->add(
                            $order->amount->value()
                    )]);

                $order->update([
                    'status' => OrderStatusEnum::Canceled,
                ]);
            });
        }
    }
}
