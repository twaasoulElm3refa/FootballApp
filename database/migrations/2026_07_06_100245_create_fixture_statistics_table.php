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
        Schema::create('fixture_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fixtures::class, 'fixture_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->integer('shots_on_goal')->nullable();
            $table->integer('shots_off_goal')->nullable();
            $table->integer('total_shots')->nullable();
            $table->integer('blocked_shots')->nullable();
            $table->integer('shots_inside_box')->nullable();
            $table->integer('shots_outside_box')->nullable();
            $table->integer('fouls')->nullable();
            $table->integer('corner_kicks')->nullable();
            $table->integer('offsides')->nullable();
            $table->string('ball_possession')->nullable();
            $table->integer('yellow_cards')->nullable();
            $table->integer('red_cards')->nullable();
            $table->integer('goalkeeper_saves')->nullable();
            $table->integer('total_passes')->nullable();
            $table->integer('passes_accurate')->nullable();
            $table->string('passes_percentage')->nullable();
            $table->decimal('expected_goals', 5, 2)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['fixture_id', 'team_id']);
            $table->index(['fixture_id']);
            $table->index(['team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_statistics');
    }
};
