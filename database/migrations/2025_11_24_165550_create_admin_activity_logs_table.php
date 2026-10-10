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
        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('url');
            $table->string('method', 10);
            $table->ipAddress('ip');
            $table->text('user_agent')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 191)->nullable();
            $table->string('platform', 191)->nullable();
//            $table->string('country', 191)->nullable();
//            $table->string('city', 191)->nullable();
            $table->integer('status_code');
            $table->json('query_params')->nullable();
            $table->json('request_data')->nullable();
            $table->float('response_time')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('url');
            $table->index('ip');
//            $table->index('country');
//            $table->index('city');
            $table->index('device_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');
    }
};
