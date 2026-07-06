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
        Schema::create('user_follow_suggestions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('suggestion_type')->index();

            $table->foreignId('team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('league_id')->nullable()->constrained('leagues')->cascadeOnDelete();
            $table->foreignId('fixture_id')->nullable()->constrained('fixtures')->cascadeOnDelete();

            $table->string('reason')->nullable();

            $table->decimal('score', 5, 2)->default(0);

            $table->boolean('is_seen')->default(false);
            $table->boolean('is_dismissed')->default(false);
            $table->boolean('is_followed')->default(false);

            $table->timestamp('seen_at')->nullable();
            $table->timestamp('dismissed_at')->nullable();
            $table->timestamp('followed_at')->nullable();

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'suggestion_type']);
            $table->index(['user_id', 'is_seen']);
            $table->index(['user_id', 'is_dismissed']);
            $table->index(['score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_follow_suggestions');
    }
};
