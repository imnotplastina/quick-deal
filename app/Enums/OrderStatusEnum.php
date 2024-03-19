<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case Completed = 'Завершен';
    case Canceled = 'Отменен';
    case Pending = 'В процессе';

    public function isCompleted(): bool
    {
        return $this === OrderStatusEnum::Completed;
    }
}
