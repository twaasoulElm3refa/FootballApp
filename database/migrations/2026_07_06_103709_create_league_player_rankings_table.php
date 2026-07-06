<?php

use App\Models\Leagues;
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
        Schema::create('league_player_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Leagues::class, 'league_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->integer('season');
            $table->enum('type', [
                'top_scorers',
                'top_assists',
                'top_yellow_cards',
                'top_red_cards',
            ]);
            $table->integer('rank')->nullable();
            $table->unsignedBigInteger('api_player_id');
            $table->string('player_name');
            $table->string('player_firstname')->nullable();
            $table->string('player_lastname')->nullable();
            $table->integer('player_age')->nullable();
            $table->date('player_birth_date')->nullable();
            $table->string('player_birth_place')->nullable();
            $table->string('player_birth_country')->nullable();
            $table->string('player_nationality')->nullable();
            $table->string('player_height')->nullable();
            $table->string('player_weight')->nullable();
            $table->boolean('player_injured')->default(false);
            $table->string('player_photo')->nullable();
            $table->integer('appearances')->nullable();
            $table->integer('lineups')->nullable();
            $table->integer('minutes')->nullable();
            $table->string('position')->nullable();
            $table->decimal('rating', 4, 2)->nullable();
            $table->boolean('captain')->default(false);
            $table->integer('goals')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('goals_conceded')->nullable();
            $table->integer('saves')->nullable();
            $table->integer('shots_total')->nullable();
            $table->integer('shots_on')->nullable();
            $table->integer('passes_total')->nullable();
            $table->integer('passes_key')->nullable();
            $table->string('passes_accuracy')->nullable();
            $table->integer('yellow_cards')->nullable();
            $table->integer('red_cards')->nullable();
            $table->integer('penalty_won')->nullable();
            $table->integer('penalty_committed')->nullable();
            $table->integer('penalty_scored')->nullable();
            $table->integer('penalty_missed')->nullable();
            $table->integer('penalty_saved')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['league_id', 'season', 'type', 'api_player_id']);
            $table->index(['league_id', 'season']);
            $table->index(['team_id']);
            $table->index(['type']);
            $table->index(['rank']);
            $table->index(['api_player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_player_rankings');
    }
};
