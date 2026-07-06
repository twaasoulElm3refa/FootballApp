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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('device_uuid')->index();
            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->enum('platform', ['android', 'ios', 'web'])->index();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('device_language')->nullable();
            $table->string('fcm_token')->nullable();
            $table->boolean('notification_enabled')->default(true);
            $table->timestamp('last_used_at')->nullable()->index();
            $table->ipAddress('last_ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
