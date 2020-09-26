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
            $table->char('name','100');
            $table->text('focus')->nullable($value = true);
            $table->text('material')->nullable($value = true);
            $table->text('procedure')->nullable($value = true);
            $table->text('coaching')->nullable($value = true);
            $table->float('duration')->nullable($value = true);
            $table->integer('intensity')->nullable($value = true);
            $table->text('image')->nullable($value = true);
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
