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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->string('url');
            $table->string('path'); // только путь без домена
            $table->string('method', 10); // GET, POST, etc
            $table->string('user_agent')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 191)->nullable();
            $table->string('platform', 191)->nullable();
            $table->string('referer')->nullable();
            $table->json('query_params')->nullable(); // GET параметры
            $table->unsignedInteger('status_code')->default(200);
            $table->string('session_id')->nullable();

            // Поля для удобной агрегации статистики
            $table->date('date')->storedAs('DATE(created_at)'); // 2024-01-15
            $table->unsignedTinyInteger('hour')->storedAs('EXTRACT(HOUR FROM created_at)'); // 0-23
            $table->timestamps();

            $table->index(['date', 'path']);
            $table->index(['path', 'created_at']);
            $table->index(['date', 'hour']);
            $table->index(['ip', 'created_at']);
        });

        Schema::create('old_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ip_id')->index()->constrained('ips');
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->string('method', 10); // GET, POST, etc
            $table->string('user_agent')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 191)->nullable();
            $table->string('platform', 191)->nullable();
            $table->string('referer')->nullable();
            $table->json('query_params')->nullable(); // GET параметры
            $table->unsignedInteger('status_code')->default(200);
            $table->string('session_id')->nullable();

            // Поля для удобной агрегации статистики
            $table->date('date')->storedAs('DATE(created_at)'); // 2024-01-15
            $table->unsignedTinyInteger('hour')->storedAs('EXTRACT(HOUR FROM created_at)'); // 0-23
            $table->timestamps();

            $table->index(['date', 'path_id']);
            $table->index(['path_id', 'created_at']);
            $table->index(['date', 'hour']);
            $table->index(['ip_id', 'created_at']);
        });

        // Дополнительная таблица для агрегированных данных (опционально)
        Schema::create('paths', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->timestamps();
        });

        Schema::create('visit_hours_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->unsignedInteger('hour')->index();
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['date', 'hour', 'path_id']);
        });

        Schema::create('old_visit_hours_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->unsignedInteger('hour')->index();
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['date', 'hour', 'path_id']);
        });

        Schema::create('visit_days_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['date', 'path_id']);
        });

        Schema::create('old_visit_days_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['date', 'path_id']);
        });

        Schema::create('visit_months_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('month');
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['month', 'path_id']);
        });

        Schema::create('old_visit_months_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('month');
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['month', 'path_id']);
        });

        Schema::create('visit_years_stats', function (Blueprint $table) {
            $table->id();
            $table->year('year')->index();
            $table->unsignedBigInteger('path_id')->index()->constrained('paths');
            $table->unsignedInteger('visits_count')->default(0);
            $table->unsignedInteger('unique_visitors')->default(0);
            $table->timestamps();

            $table->unique(['year', 'path_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
        Schema::dropIfExists('visit_stats');
    }
};
