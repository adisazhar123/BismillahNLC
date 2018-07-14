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
      Schema::create('generated_packet', function (Blueprint $table) {
        $table->integer('id', true);
        $table->integer('id_packet');
        $table->text('packet_type');
        $table->text('questions_order');
        $table->text('packet_file_directory');
        $table->integer('shuffle');
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
