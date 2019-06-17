<?php

namespace App\Traits;

use App\Models\Provider;

trait BelongsToProvider
{
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
