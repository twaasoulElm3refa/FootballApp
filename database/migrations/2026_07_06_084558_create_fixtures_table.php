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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_fixture_id')->unique();
            $table->foreignIdFor(Leagues::class, 'league_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'home_team_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'away_team_id')->constrained()->cascadeOnDelete();
            $table->integer('season')->nullable();
            $table->string('round')->nullable();
            $table->dateTime('fixture_date');
            $table->unsignedBigInteger('timestamp')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('referee')->nullable();
            $table->unsignedBigInteger('venue_api_id')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('venue_city')->nullable();
            $table->string('status_long')->nullable();
            $table->string('status_short')->nullable();
            $table->integer('elapsed')->nullable();
            $table->integer('extra')->nullable();
            $table->integer('goals_home')->nullable();
            $table->integer('goals_away')->nullable();
            $table->integer('score_halftime_home')->nullable();
            $table->integer('score_halftime_away')->nullable();
            $table->integer('score_fulltime_home')->nullable();
            $table->integer('score_fulltime_away')->nullable();
            $table->integer('score_extratime_home')->nullable();
            $table->integer('score_extratime_away')->nullable();
            $table->integer('score_penalty_home')->nullable();
            $table->integer('score_penalty_away')->nullable();
            $table->boolean('home_winner')->nullable();
            $table->boolean('away_winner')->nullable();
            $table->boolean('is_live')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['league_id', 'season']);
            $table->index(['fixture_date']);
            $table->index(['status_short']);
            $table->index(['is_live']);
            $table->index(['is_finished']);
            $table->index(['home_team_id']);
            $table->index(['away_team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
