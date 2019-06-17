<?php

namespace App\Traits;

use App\Models\Layout;

trait BelongsToLayout
{
    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
