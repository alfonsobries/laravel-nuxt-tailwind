<?php

use App\Models\Column;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('layout_id');
            $table->string('name');
            $table->string('slug');
            $table->string('type')->default(Column::TYPE_TEXT);
            $table->string('default')->nullable();
            $table->string('when_duplicated')->default(Column::ACTION_REPLACE);
            $table->json('settings')->nullable();
            $table->boolean('required')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('layout_id')
                ->references('id')
                ->on('layouts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
}
