<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamPacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_packet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_packet');
            $table->integer('id_generated_packet');
            $table->integer('id_team');
            $table->integer('status')->default(0);
            $table->integer('has_started')->default(0);
            $table->integer('has_finished')->default(0);
            $table->text('time_remaining')->nullable();
            $table->text('team_ans')->nullable();
            $table->text('ans_stats')->nullable();
            $table->integer('final_score')->nullable();
            $table->text('packet_file_directory')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_packet');
    }
}
