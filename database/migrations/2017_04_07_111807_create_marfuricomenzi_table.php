<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarfuricomenziTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marfuricomenzi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_produs')->nullable();
            $table->integer("id_comenzi");
            $table->string('originalnameprodus');
            $table->string('nameprodus');
            $table->decimal('priceprodus',15,2);
            $table->integer('cantitateprodus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marfuricomenzi');
    }
}
