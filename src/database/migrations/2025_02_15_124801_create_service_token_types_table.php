<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTokenTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_token_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('token_type_id');
            $table->timestamps();

            $table->unique(['service_id', 'token_type_id']);

            $table->foreign('service_id')
            ->references('id')
            ->on('services')
            ->onDelete('cascade');
            $table->foreign('token_type_id')
            ->references('id')
            ->on('token_types')
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
        Schema::dropIfExists('service_token_types');
    }
}
