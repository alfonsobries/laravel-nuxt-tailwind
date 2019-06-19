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

    protected $connection = null;
    protected $table = null;
    protected $keyType = 'string';
    public $incrementing = false;

    public function bind(string $connection, string $table)
    {
       $this->setConnection($connection);
       $this->setTable($table);
    }

    public function newInstance($attributes = [], $exists = false)
    {
       $model = parent::newInstance($attributes, $exists);
       $model->setTable($this->table);

       return $model;
    }

    public function buildId()
    {
        return uniqid();
    }
}
