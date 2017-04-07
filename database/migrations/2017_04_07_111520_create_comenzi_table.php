<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComenziTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comenzi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nume')->nullable();
            $table->string('email')->nullable();
            $table->string('telefon')->nullable();
            $table->string('adresa')->nullable();
            $table->boolean('trecut')->default(0);
            $table->timestamp("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comenzi');
    }
}
