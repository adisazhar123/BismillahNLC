<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id_question');
            $table->integer('id_packet');
            $table->longText('question');
            $table->longText('option_1', 10);
            $table->longText('option_2', 10);
            $table->longText('option_3', 10);
            $table->longText('option_4', 10);
            $table->longText('option_5', 10);
            $table->longText('right_ans', 10);
            $table->longText('description')->nullable();
            $table->integer('related');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
