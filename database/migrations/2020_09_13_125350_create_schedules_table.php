<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->nullable($value = true);
            $table->text('coaches')->nullable($value = true);
            $table->integer('fieldplayers')->nullable($value = true);
            $table->integer('goalkeeper')->nullable($value = true);
            $table->float('duration')->nullable($value = true);
            $table->foreignId('exercise_id');
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
        Schema::dropIfExists('schedules');
    }
}
