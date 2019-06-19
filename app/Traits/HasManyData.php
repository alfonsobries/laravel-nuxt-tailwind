<?php

namespace App\Traits;

use App\Models\Column;
use App\Models\Data;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyData
{
    public function data()
    {
        return $this->hasMany(Data::class);
        // $table = $this->getDataTable();

        // return new HasMany(
        //     $table->newQuery(),
        //     $this,
        //     $table->getTable() . '.layout_id',
        //     'id'
        // );
    }

    /**
     * Create a new model instance for a related model.
     *
     * @param  string  $class
     * @return mixed
     */
    protected function newRelatedInstance($class)
    {
        if ($class === Data::class) {
            $model = new Data;
            $model->setTable($this->table_name);
            return tap($model, function ($instance) {
                if (! $instance->getConnectionName()) {
                    $instance->setConnection($this->connection);
                }
            });
        }

        return parent::newRelatedInstance($class);
    }
}
