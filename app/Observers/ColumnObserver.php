<?php

namespace App\Observers;

use App\Models\Column;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ColumnObserver
{
    /**
     * Handle the column "creating" event.
     *
     * @param  \App\Models\Column  $column
     * @return void
     */
    public function creating(Column $column)
    {
        Schema::table($column->table_name, function (Blueprint $table) use ($column) {
            $table->{$column->column_type}($column->slug)->nullable()->default($column->default);
        });
    }

    /**
     * Handle the column "updating" event.
     *
     * @param  \App\Models\Column  $column
     * @return void
     */
    public function updating(Column $column)
    {
        if ($column->getOriginal('slug') !== $column->slug) {
            Schema::table($column->table_name, function (Blueprint $table) use ($column) {
                $table->renameColumn($column->getOriginal('slug'), $column->slug);
            });
        }

        if ($column->type !== $column->getOriginal('type')) {
            if (config('database.default') === 'pgsql') {
                $sql = "ALTER TABLE $column->table_name ALTER COLUMN $column->slug TYPE $column->sql_column_type USING $column->slug::$column->sql_column_type";
                DB::statement($sql);
            } else {
                Schema::table($column->table_name, function (Blueprint $table) use ($column) {
                    $table->{$column->column_type}($column->slug)->change();
                });
            }
        }
    }

    /**
     * Handle the user "force deleting" event.
     *
     * @param  \App\Models\Column  $column
     * @return void
     */
    public function forceDeleted(Column $column)
    {
        Schema::table($column->table_name, function (Blueprint $table) use ($column) {
            $table->dropColumn($column->slug);
        });
    }
}
