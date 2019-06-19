<?php

namespace App\Models;

use App\Traits\BelongsToLayout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use SoftDeletes,
        BelongsToLayout;

    protected $guarded = [];
   
    protected $keyType = 'string';
    public $incrementing = false;

    public function buildId()
    {
        $columnNames = $this->layout->columnKeys()->pluck('slug');

        if (!$columnNames->count()) {
            return uniqid();
        }

        return $columnNames->map(function ($columnName) {
            return str_slug($this->{$columnName}, '-');
        })->implode('_');
    }
}
