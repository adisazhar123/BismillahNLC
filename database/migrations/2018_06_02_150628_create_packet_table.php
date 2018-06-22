<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packet', function (Blueprint $table) {
            $table->increments('id_packet');
            $table->text('name', 1024);
            $table->binary('file');
            $table->date('active_date');
            $table->text('start_time', 20);
            $table->text('end_time', 20);
            $table->integer('duration');
            $table->integer('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packet');
    }
}
