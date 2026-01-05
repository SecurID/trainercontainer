<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('practices', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->index(['practice_id', 'player_id']);
            $table->index(['game_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('practices', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('players', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex(['practice_id', 'player_id']);
            $table->dropIndex(['game_id', 'player_id']);
        });
    }
};
