<?php

namespace App\Traits;

use App\Models\Column;

trait HasManyColumns
{
    public function columns()
    {
        return $this->hasMany(Column::class);
    }
}
