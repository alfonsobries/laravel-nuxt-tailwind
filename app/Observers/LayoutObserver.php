<?php

namespace App\Observers;

use App\Models\Layout;

class LayoutObserver
{
    public function creating(Layout $layout)
    {
        $layout->table_name = $layout->generateUniqueTableName();
    }
}
