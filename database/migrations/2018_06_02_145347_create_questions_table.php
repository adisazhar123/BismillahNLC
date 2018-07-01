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
            $table->text('question');
            $table->text('option_1', 10);
            $table->text('option_2', 10);
            $table->text('option_3', 10);
            $table->text('option_4', 10);
            $table->text('option_5', 10);
            $table->text('right_ans', 10);
            $table->text('description')->nullable();
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
