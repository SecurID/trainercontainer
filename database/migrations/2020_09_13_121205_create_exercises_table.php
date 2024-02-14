<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name','100');
            $table->string('focus')->nullable();
            $table->string('material')->nullable();
            $table->text('procedure')->nullable();
            $table->text('coaching')->nullable();
            $table->integer('duration')->nullable();
            $table->string('intensity')->nullable();
            $table->string('image')->nullable();
            $table->integer('playerCount')->nullable();
            $table->integer('goalkeeperCount')->nullable();
            $table->integer('level')->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
}
