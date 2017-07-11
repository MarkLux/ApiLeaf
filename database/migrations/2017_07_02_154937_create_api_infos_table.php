<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('collection_id');
            $table->string('api_url');
            $table->string('api_name');
            $table->string('api_method');
            $table->string('api_description')->nullable();
            $table->json('request_headers')->nullable();
            $table->json('request_body')->nullable();
            $table->json('request_params')->nullable();
            $table->json('request_example')->nullable();
            $table->json('response_headers')->nullable();
            $table->json('response_body')->nullable();
            $table->json('response_example')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_infos');
    }
}
