<?php

namespace App\Jobs;

use App\Models\Page;
use App\Models\Path;
use App\Models\VisitDaysStat;
use App\Models\VisitHoursStat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class VisitStatJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public ?string $date;

    public int $tries = 3;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(?string $date = null)
    {
        $this->date = $date ?? now()->format('Y-m-d');
        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        $this->save_hours($this->date);
//        $this->save_days($this->date);
    }

    public function save_hours($date)
    {
        $visits = DB::table('visits')
            ->where('date', $date)
            ->selectRaw('
                date,
                hour,
                path,
                COUNT(*) as visits_count,
                COUNT(DISTINCT ip) as unique_visitors
            ')
            ->groupBy('date', 'hour', 'path')
            ->get();

        foreach ($visits as $visit) {
            $page = Path::firstOrCreate([
                'path' => $visit->path
            ]);

            $stat = VisitHoursStat::firstOrNew([
                'path_id' => $page->id,
                'date'    => $visit->date,
                'hour'    => $visit->hour,
            ]);

            $stat->visits_count    = $visit->visits_count;
            $stat->unique_visitors = $visit->unique_visitors;
            $stat->save();
        }
    }

    public function save_days($date)
    {
        $visits = DB::table('visits')
            ->where('date', $date)
            ->selectRaw('
                date,
                path,
                COUNT(*) as visits_count,
                COUNT(DISTINCT ip) as unique_visitors
            ')
            ->groupBy('date', 'path')
            ->get();

        foreach ($visits as $visit) {
            $page = Path::firstOrCreate([
                'path' => $visit->path
            ]);

            $stat = VisitDaysStat::firstOrNew([
                'path_id' => $page->id,
                'date'    => $visit->date,
            ]);

            $stat->visits_count    = $visit->visits_count;
            $stat->unique_visitors = $visit->unique_visitors;
            $stat->save();
        }
    }
}
