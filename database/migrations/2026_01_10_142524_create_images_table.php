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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('path');
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('hash')->nullable();
            $table->unsignedInteger('r')->nullable();
            $table->unsignedInteger('g')->nullable();
            $table->unsignedInteger('b')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
