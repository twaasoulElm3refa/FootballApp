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
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Leagues::class, 'league_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->integer('season');
            $table->string('group_name')->default('Overall');
            $table->integer('rank')->nullable();
            $table->integer('points')->nullable();
            $table->integer('goals_diff')->nullable();
            $table->string('status')->nullable();
            $table->integer('all_played')->default(0);
            $table->integer('all_win')->default(0);
            $table->integer('all_draw')->default(0);
            $table->integer('all_lose')->default(0);
            $table->integer('all_goals_for')->default(0);
            $table->integer('all_goals_against')->default(0);
            $table->integer('home_played')->default(0);
            $table->integer('home_win')->default(0);
            $table->integer('home_draw')->default(0);
            $table->integer('home_lose')->default(0);
            $table->integer('home_goals_for')->default(0);
            $table->integer('home_goals_against')->default(0);
            $table->integer('away_played')->default(0);
            $table->integer('away_win')->default(0);
            $table->integer('away_draw')->default(0);
            $table->integer('away_lose')->default(0);
            $table->integer('away_goals_for')->default(0);
            $table->integer('away_goals_against')->default(0);
            $table->timestamp('api_updated_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['league_id', 'team_id', 'season', 'group_name']);
            $table->index(['league_id', 'season']);
            $table->index(['team_id']);
            $table->index(['rank']);
            $table->index(['group_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};
