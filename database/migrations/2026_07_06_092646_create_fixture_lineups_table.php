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
        Schema::create('fixture_lineups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fixtures::class, 'fixture_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->string('formation')->nullable();
            $table->unsignedBigInteger('api_coach_id')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('coach_photo')->nullable();
            $table->string('player_primary_color')->nullable();
            $table->string('player_number_color')->nullable();
            $table->string('player_border_color')->nullable();
            $table->string('goalkeeper_primary_color')->nullable();
            $table->string('goalkeeper_number_color')->nullable();
            $table->string('goalkeeper_border_color')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->json('meta')->nullable();
            $table->unique(['fixture_id', 'team_id']);
            $table->index(['fixture_id']);
            $table->index(['team_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_lineups');
    }
};
