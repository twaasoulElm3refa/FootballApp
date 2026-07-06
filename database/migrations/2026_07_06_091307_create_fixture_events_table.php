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
        Schema::create('fixture_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fixtures::class, 'fixture_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teams::class, 'team_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('api_player_id')->nullable();
            $table->string('player_name')->nullable();
            $table->unsignedBigInteger('api_assist_player_id')->nullable();
            $table->string('assist_player_name')->nullable();
            $table->integer('elapsed')->nullable();
            $table->integer('extra')->nullable();
            $table->string('type')->nullable();
            $table->string('detail')->nullable();
            $table->string('comments')->nullable();
            $table->integer('sort_order')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['fixture_id']);
            $table->index(['team_id']);
            $table->index(['type']);
            $table->index(['elapsed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_events');
    }
};
