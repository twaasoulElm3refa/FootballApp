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
        Schema::create('league_teams', function (Blueprint $table) {
            $table->foreignId('league_id')
                ->constrained('leagues')
                ->cascadeOnDelete();
            $table->foreignId('team_id')
                ->constrained('teams')
                ->cascadeOnDelete();
            $table->integer('season');
            $table->string('group_name')->nullable();
            $table->string('round')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['league_id', 'team_id', 'season']);
            $table->index(['league_id', 'season']);
            $table->index(['team_id']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_teams');
    }
};
