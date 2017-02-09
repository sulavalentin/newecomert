<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificationnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specificationname', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('table_id');
            $table->integer('group_id');
            $table->string('specification_name');
            $table->boolean("addname")->default(0);
            $table->boolean("addsearch")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specificationname');
    }
}
