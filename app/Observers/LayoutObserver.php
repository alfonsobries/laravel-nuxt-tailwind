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

        Schema::create($layout->table_name, function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->string('id')->index()->unique();
            $table->unsignedInteger('layout_id')->nullable();
            $table->integer('row_number');
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('set null');
        });
    }

    public function updating(Layout $layout)
    {
        if ($layout->getOriginal('table_name') !== $layout->table_name) {
            Schema::rename($layout->getOriginal('table_name'), $layout->table_name);
        }
    }

    public function deleting(Layout $layout)
    {
        Schema::dropIfExists($layout->table_name);
    }
}
