<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBearerTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bearer_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->unsignedBigInteger('tokenable_id');
            $table->string('tokenable_type');
            $table->timestamps();

            $table->foreign('tokenable_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');

            $table->unique(['tokenable_id', 'tokenable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bearer_tokens');
    }
}
