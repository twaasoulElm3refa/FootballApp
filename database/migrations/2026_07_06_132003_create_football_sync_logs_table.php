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
        Schema::create('football_sync_logs', function (Blueprint $table) {
            $table->id();

            $table->string('sync_type')->index();

            $table->foreignId('league_id')->nullable()->constrained('leagues')->nullOnDelete();
            $table->foreignId('fixture_id')->nullable()->constrained('fixtures')->nullOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();

            $table->integer('season')->nullable();

            $table->date('sync_date')->nullable();

            $table->enum('status', ['started', 'success', 'failed', 'partial'])->default('started')->index();

            $table->integer('records_fetched')->default(0);
            $table->integer('records_created')->default(0);
            $table->integer('records_updated')->default(0);
            $table->integer('records_failed')->default(0);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->unsignedInteger('duration_ms')->nullable();

            $table->text('error_message')->nullable();

            $table->json('params')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->index(['sync_type', 'status']);
            $table->index(['league_id', 'season']);
            $table->index(['fixture_id']);
            $table->index(['sync_date']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_sync_logs');
    }
};
