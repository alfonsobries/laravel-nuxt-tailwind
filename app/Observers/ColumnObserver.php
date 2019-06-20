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

        if ($column->reference_column_id) {
            $this->createRelationship($column);
        }
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

        if ($column->reference_column_id !== $column->getOriginal('reference_column_id')) {
            // Is new
            if (!$column->getOriginal('reference_column_id')) {
                $this->createRelationship($column, $column->reference_column_id);
            // Was removed
            } else if (!$column->reference_column_id) {
                $this->deleteRelationship($column, $column->getOriginal('reference_column_id'));
            // Was updated
            } else if ($column->getOriginal('reference_column_id') !== $column->reference_column_id) {
                $this->deleteRelationship($column, $column->getOriginal('reference_column_id'));
                $this->createRelationship($column, $column->reference_column_id);
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

    private function createRelationship($column, $reference_column_id = null)
    {
        $referencedColumn = $reference_column_id ? Column::find($reference_column_id) : $column->reference;

        // Force the user to manually set the unique key?
        Schema::table($referencedColumn->table_name, function (Blueprint $table) use ($referencedColumn) {
            $table->unique($referencedColumn->slug, $referencedColumn->slug . '_unique');
        });

        Schema::table($column->table_name, function (Blueprint $table) use ($column, $referencedColumn) {
            $table
                ->foreign($column->slug, sprintf('%s_%s_key', $column->slug, $referencedColumn->slug))
                ->references($referencedColumn->slug)
                ->on($referencedColumn->table_name)
                ->onDelete('set null')
                ->onUpdate('set null');
        });
    }

    private function deleteRelationship($column, $reference_column_id = null)
    {
        $referencedColumn = $reference_column_id ? Column::find($reference_column_id) : $column->reference;

        Schema::table($column->table_name, function (Blueprint $table) use ($column, $referencedColumn) {
            $table->dropForeign(sprintf('%s_%s_key', $column->slug, $referencedColumn->slug));
        });
        
        // Force the user to manually set the unique key?
        Schema::table($referencedColumn->table_name, function (Blueprint $table) use ($referencedColumn) {
            $table->dropUnique($referencedColumn->slug . '_unique');
        });
    }
}
