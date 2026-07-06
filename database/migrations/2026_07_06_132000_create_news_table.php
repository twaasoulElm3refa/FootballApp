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
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->foreignId('league_id')->nullable()->constrained('leagues')->nullOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->foreignId('fixture_id')->nullable()->constrained('fixtures')->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();

            $table->string('image')->nullable();

            $table->string('source_name')->nullable();
            $table->string('source_url')->nullable();

            $table->string('author_name')->nullable();

            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);

            $table->unsignedInteger('views_count')->default(0);

            $table->timestamp('published_at')->nullable();

            $table->json('tags')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index(['league_id']);
            $table->index(['team_id']);
            $table->index(['fixture_id']);
            $table->index(['is_featured']);
            $table->index(['is_breaking']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
