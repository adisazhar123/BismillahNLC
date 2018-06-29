<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RandomizedPacket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('randomized_packet', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('id_packet');
        $table->text('packet_type');
        $table->text('randomized_questions');
        $table->text('packet_file_directory');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
