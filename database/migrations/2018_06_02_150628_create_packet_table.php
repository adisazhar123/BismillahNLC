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
            $table->integer('id_packet', true);
            $table->text('name', 1024);
            $table->date('active_date');
            $table->text('start_time', 20)->nullable();
            $table->text('end_time', 20)->nullable();
            $table->integer('duration');
            $table->integer('active');
            $table->string('type')->default('online')->nullable();
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
