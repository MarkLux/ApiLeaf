<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataDictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dicts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('collection_id');
            $table->string('name');
            $table->string('key_index');
            $table->string('description');
            $table->text('body'); // JSON
            $table->timestamps();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_dicts');
    }
}
