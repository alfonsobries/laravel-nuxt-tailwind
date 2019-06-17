<?php

namespace App\Models;

use App\Traits\BelongsToLayout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use SoftDeletes,
        BelongsToLayout;
}
