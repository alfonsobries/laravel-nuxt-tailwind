<?php

namespace App\Observers;

use App\Models\Layout;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LayoutObserver
{
    public function creating(Layout $layout)
    {
        $layout->table_name = $layout->generateUniqueTableName();

        Schema::create($layout->table_name, function (Blueprint $table) use ($layout) {
            $table->string('id');
            $table->unsignedInteger('layout_id')->nullable();
            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->integer('database_row')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $foreign_prefix = $layout->generateForeignKeyPrefix();

            $table
                ->foreign('layout_id', $foreign_prefix . '_layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('set null');

            $table
                ->foreign('created_by_id', $foreign_prefix . '_created_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table
                ->foreign('updated_by_id', $foreign_prefix . '_updated_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->primary('id', $foreign_prefix . '_id_primary');
        });
    }

    public function updating(Layout $layout)
    {
        if ($layout->getOriginal('table_name') !== $layout->table_name) {
            Schema::rename($layout->getOriginal('table_name'), $layout->table_name);
        }
    }

    public function forceDeleted(Layout $layout)
    {
        Schema::dropIfExists($layout->table_name);
    }
}
