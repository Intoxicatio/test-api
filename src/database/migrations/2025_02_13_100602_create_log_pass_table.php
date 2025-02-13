<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pass', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password');
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
        Schema::dropIfExists('log_pass');
    }
}
