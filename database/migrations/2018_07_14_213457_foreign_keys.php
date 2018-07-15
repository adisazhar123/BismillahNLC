<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('team_packet', function(Blueprint $table){
          $table->foreign('id_team')->references('id_team')->on('team')->onDelete('cascade');
          $table->foreign('id_packet')->references('id_packet')->on('packet')->onDelete('cascade');
        });
        Schema::table('question', function(Blueprint $table){
          $table->foreign('id_packet')->references('id_packet')->on('packet')->onDelete('cascade');
        });
        Schema::table('generated_packet', function(Blueprint $table){
          $table->foreign('id_packet')->references('id_packet')->on('packet')->onDelete('cascade');
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
