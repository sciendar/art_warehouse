<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ips', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true)->index();
            $table->ipAddress('ip')->index();
            $table->text('country')->nullable();
            $table->text('country_code')->nullable();
            $table->text('region')->nullable();
            $table->text('city')->nullable();
            $table->text('lat')->nullable();
            $table->text('lon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ips');
    }
};
