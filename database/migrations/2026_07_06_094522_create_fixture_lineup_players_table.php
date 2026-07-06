<?php

use App\Models\FixtureLineups;
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
        Schema::create('fixture_lineup_players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FixtureLineups::class, 'fixture_lineup_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('api_player_id')->nullable();
            $table->string('player_name');
            $table->string('player_photo')->nullable();
            $table->integer('number')->nullable();
            $table->string('position')->nullable();
            $table->string('grid')->nullable();
            $table->enum('type', ['start', 'substitute'])->default('start');
            $table->boolean('is_captain')->default(false);
            $table->boolean('is_goalkeeper')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['fixture_id']);
            $table->index(['team_id']);
            $table->index(['fixture_lineup_id']);
            $table->index(['api_player_id']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_lineup_players');
    }
};
