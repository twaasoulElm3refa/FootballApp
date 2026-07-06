<?php

use App\Models\Fixtures;
use App\Models\User;
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
        Schema::create('favourite_fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Fixtures::class, 'fixture_id')->constrained()->cascadeOnDelete();
            $table->boolean('notifications_enabled')->default(true);
            $table->boolean('notify_before_match')->default(true);
            $table->boolean('notify_match_start')->default(true);
            $table->boolean('notify_goals')->default(true);
            $table->boolean('notify_half_time')->default(false);
            $table->boolean('notify_full_time')->default(true);
            $table->boolean('notify_lineups')->default(true);
            $table->boolean('notify_red_cards')->default(true);
            $table->boolean('notify_penalties')->default(true);
            $table->integer('remind_before_minutes')->default(15);
            $table->timestamps();
            $table->unique(['user_id', 'fixture_id']);
            $table->index(['user_id']);
            $table->index(['fixture_id']);
            $table->index(['notifications_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourite_fixtures');
    }
};
