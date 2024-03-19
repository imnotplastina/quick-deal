<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSorted(Builder $query): void
    {
        $query->when(request('sort'), function (Builder $q) {
            $column = request()->str('sort');

            if ($column->contains('price')) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $q->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }
}
