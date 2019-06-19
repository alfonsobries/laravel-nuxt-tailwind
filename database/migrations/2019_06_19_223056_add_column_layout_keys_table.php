<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLayoutKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_layout_keys', function (Blueprint $table) {
            $table->unsignedInteger('layout_id');
            $table->unsignedInteger('column_id');

            $table
                ->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('cascade');

            $table
                ->foreign('column_id')
                ->references('id')
                ->on('columns')
                ->onDelete('cascade');

            $table->index(['layout_id', 'column_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
