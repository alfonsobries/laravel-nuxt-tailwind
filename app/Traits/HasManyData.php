<?php

namespace App\Traits;

use App\Models\Column;
use App\Models\Data;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyData
{
    public function data()
    {
        $table = $this->getDataTable();

        return new HasMany(
            $table->newQuery(),
            $this,
            $table->getTable() . '.layout_id',
            'id'
        );
    }
}
