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
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('user_id')->index()->constrained();
            $table->unsignedBigInteger('warehouse_id')->index()->constrained();
            $table->unsignedBigInteger('painting_id')->index()->nullable()->constrained();
            $table->unsignedBigInteger('auction_id')->index()->nullable()->constrained();
            $table->string('code');
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('track_number')->nullable();
            $table->text('description')->nullable();
            $table->text('condition')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('lot')->nullable();
            $table->timestamp('tracking_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paintings');
    }
};
