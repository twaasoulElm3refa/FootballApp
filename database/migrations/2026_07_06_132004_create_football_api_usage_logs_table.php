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
        Schema::create('football_api_usage_logs', function (Blueprint $table) {
            $table->id();

            $table->string('provider')->default('api-football')->index();

            $table->string('endpoint')->index();

            $table->string('method')->default('GET');

            $table->json('query_params')->nullable();

            $table->unsignedSmallInteger('status_code')->nullable();

            $table->boolean('success')->default(false)->index();

            $table->integer('response_count')->nullable();

            $table->unsignedInteger('duration_ms')->nullable();

            $table->text('error_message')->nullable();

            $table->integer('requests_limit')->nullable();
            $table->integer('requests_remaining')->nullable();

            $table->timestamp('requested_at')->nullable();

            $table->timestamps();

            $table->index(['endpoint', 'success']);
            $table->index(['provider', 'created_at']);
            $table->index(['requested_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_api_usage_logs');
    }
};
