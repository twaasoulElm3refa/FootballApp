<?php

use App\Models\Fixtures;
use App\Models\Teams;
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
        Schema::create('fixture_player_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fixtures::class, 'fixture_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('api_player_id');
            $table->string('player_name');
            $table->string('player_photo')->nullable();
            $table->integer('number')->nullable();
            $table->string('position')->nullable();
            $table->integer('minutes')->nullable();
            $table->boolean('captain')->default(false);
            $table->boolean('substitute')->default(false);
            $table->decimal('rating', 4, 2)->nullable();
            $table->integer('goals_total')->nullable();
            $table->integer('goals_conceded')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('saves')->nullable();
            $table->integer('shots_total')->nullable();
            $table->integer('shots_on')->nullable();
            $table->integer('passes_total')->nullable();
            $table->integer('passes_key')->nullable();
            $table->string('passes_accuracy')->nullable();
            $table->integer('tackles_total')->nullable();
            $table->integer('tackles_blocks')->nullable();
            $table->integer('tackles_interceptions')->nullable();
            $table->integer('duels_total')->nullable();
            $table->integer('duels_won')->nullable();
            $table->integer('dribbles_attempts')->nullable();
            $table->integer('dribbles_success')->nullable();
            $table->integer('dribbles_past')->nullable();
            $table->integer('fouls_drawn')->nullable();
            $table->integer('fouls_committed')->nullable();
            $table->integer('yellow_cards')->nullable();
            $table->integer('red_cards')->nullable();
            $table->integer('penalty_won')->nullable();
            $table->integer('penalty_committed')->nullable();
            $table->integer('penalty_scored')->nullable();
            $table->integer('penalty_missed')->nullable();
            $table->integer('penalty_saved')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['fixture_id', 'team_id', 'api_player_id']);
            $table->index(['fixture_id']);
            $table->index(['team_id']);
            $table->index(['api_player_id']);
            $table->index(['rating']);
            $table->index(['position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_player_statistics');
    }
};
