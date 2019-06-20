<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_relationship', function (Blueprint $table) {
            $table->unsignedInteger('foreign_column_id');
            $table->unsignedInteger('related_column_id');

            $table
                ->foreign('foreign_column_id')
                ->references('id')
                ->on('columns')
                ->onDelete('cascade');

            $table
                ->foreign('related_column_id')
                ->references('id')
                ->on('columns')
                ->onDelete('cascade');

            $table->index(['foreign_column_id', 'related_column_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_relationships');
    }
}
