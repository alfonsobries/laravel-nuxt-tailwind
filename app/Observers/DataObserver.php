<?php

namespace App\Observers;

use App\Models\Data;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataObserver
{
    /**
     * Handle the column "creating" event.
     *
     * @param  \App\Models\Data  $data
     * @return void
     */
    public function creating(Data $data)
    {
        $data->id = $data->buildId();
    }

    /**
     * Handle the column "updating" event.
     *
     * @param  \App\Models\Data  $data
     * @return void
     */
    public function updating(Data $data)
    {
        $data->id = $data->buildId();
    }
}
